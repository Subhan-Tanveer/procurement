<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::withCount(['products', 'details'])
            ->orderBy('sort_order')
            ->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'why_choose_title' => 'nullable|string|max:255',
            'why_choose_intro' => 'nullable|string',
            'why_choose_theme' => 'nullable|in:dark,light',
            'why_choose_features' => 'nullable|array|max:4',
            'why_choose_features.*.title' => 'required_with:why_choose_features|string|max:255',
            'why_choose_features.*.description' => 'nullable|string',
            'why_choose_features.*.items' => 'nullable|string',
            'why_choose_features.*.image' => 'nullable|image|max:5120',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'is_active' => 'nullable',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'details' => 'nullable|array',
            'details.*.title' => 'required|string|max:255',
            'details.*.content' => 'required|string',
            'details.*.type' => 'required|in:feature,benefit,pricing,specification',
        ]);

        DB::beginTransaction();
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('services', 'public');
            }

            $whyChooseFeatures = $this->buildWhyChooseFeatures($request);

            $service = Service::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'short_description' => $request->short_description,
                'description' => $request->description,
                'why_choose_title' => $request->why_choose_title,
                'why_choose_intro' => $request->why_choose_intro,
                'why_choose_theme' => $request->why_choose_theme ?? 'dark',
                'why_choose_features' => $whyChooseFeatures,
                'icon' => $request->icon,
                'image' => $imagePath ? 'storage/' . $imagePath : null,
                'is_active' => $request->boolean('is_active', true),
                'sort_order' => Service::max('sort_order') + 1,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            if ($request->filled('details')) {
                foreach ($request->details as $index => $detail) {
                    $service->details()->create([
                        'title' => $detail['title'],
                        'content' => $detail['content'],
                        'type' => $detail['type'],
                        'sort_order' => $index,
                        'is_active' => true,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.services.index')
                ->with('success', 'Service created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Failed to create service: ' . $e->getMessage());
        }
    }

    public function edit(Service $service)
    {
        $service->load('details');
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'why_choose_title' => 'nullable|string|max:255',
            'why_choose_intro' => 'nullable|string',
            'why_choose_theme' => 'nullable|in:dark,light',
            'why_choose_features' => 'nullable|array|max:4',
            'why_choose_features.*.title' => 'required_with:why_choose_features|string|max:255',
            'why_choose_features.*.description' => 'nullable|string',
            'why_choose_features.*.items' => 'nullable|string',
            'why_choose_features.*.image' => 'nullable|image|max:5120',
            'why_choose_features.*.existing_image' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120',
            'is_active' => 'nullable',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'details' => 'nullable|array',
            'details.*.title' => 'required|string|max:255',
            'details.*.content' => 'required|string',
            'details.*.type' => 'required|in:feature,benefit,pricing,specification',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'short_description' => $request->short_description,
                'description' => $request->description,
                'why_choose_title' => $request->why_choose_title,
                'why_choose_intro' => $request->why_choose_intro,
                'why_choose_theme' => $request->why_choose_theme ?? 'dark',
                'icon' => $request->icon,
                'is_active' => $request->boolean('is_active', true),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ];

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('services', 'public');
                $data['image'] = 'storage/' . $imagePath;
            }

            $data['why_choose_features'] = $this->buildWhyChooseFeatures($request, $service);

            $service->update($data);

            // Replace details
            $service->details()->delete();
            if ($request->filled('details')) {
                foreach ($request->details as $index => $detail) {
                    $service->details()->create([
                        'title' => $detail['title'],
                        'content' => $detail['content'],
                        'type' => $detail['type'],
                        'sort_order' => $index,
                        'is_active' => true,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.services.index')
                ->with('success', 'Service updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()
                ->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    public function destroy(Service $service)
    {
        if ($service->products()->count() > 0) {
            return redirect()->route('admin.services.index')
                ->with('error', 'Cannot delete service with linked products.');
        }

        $service->details()->delete();
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    private function buildWhyChooseFeatures(Request $request, ?Service $service = null): array
    {
        $rawFeatures = $request->input('why_choose_features', []);
        $files = $request->file('why_choose_features', []);
        $features = [];

        foreach (array_slice($rawFeatures, 0, 4) as $index => $feature) {
            if (!is_array($feature)) {
                continue;
            }

            $title = trim($feature['title'] ?? '');
            if ($title === '') {
                continue;
            }

            $description = trim($feature['description'] ?? '');
            $itemsRaw = $feature['items'] ?? '';
            $items = array_values(array_filter(array_map('trim', preg_split('/\\r\\n|\\r|\\n/', (string) $itemsRaw))));

            $imagePath = $feature['existing_image'] ?? null;
            $file = $files[$index]['image'] ?? null;
            if ($file) {
                $storedPath = $file->store('services/why-choose', 'public');
                $imagePath = 'storage/' . $storedPath;

                if ($service && $feature['existing_image'] ?? false) {
                    $oldPath = $feature['existing_image'];
                    if (str_starts_with($oldPath, 'storage/')) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $oldPath));
                    }
                }
            }

            $features[] = [
                'title' => $title,
                'description' => $description,
                'items' => $items,
                'image' => $imagePath,
            ];
        }

        return $features;
    }
}
