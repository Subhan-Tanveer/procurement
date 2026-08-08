<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:5120'],
        ]);

        $profile = Auth::user()->supplierProfile;
        $file = $request->file('file');

        $path = $file->store('media/' . date('Y/m'), 'public');

        $media = MediaFile::create([
            'uploader_id' => Auth::id(),
            'supplier_id' => $profile->id,
            'file_name'   => $file->getClientOriginalName(),
            'file_path'   => $path,
            'file_size'   => $file->getSize(),
            'mime_type'   => $file->getMimeType(),
            'alt_text'    => $request->input('alt_text'),
            'title'       => $request->input('title'),
        ]);

        return response()->json([
            'id'   => $media->id,
            'url'  => asset('storage/' . $path),
            'path' => $path,
        ]);
    }

    public function index(Request $request)
    {
        $profile = Auth::user()->supplierProfile;

        $media = MediaFile::where('supplier_id', $profile->id)
            ->latest()
            ->paginate(40);

        $items = $media->map(fn ($m) => [
            'id'        => $m->id,
            'url'       => asset('storage/' . $m->file_path),
            'path'      => $m->file_path,
            'file_name' => $m->file_name,
            'alt_text'  => $m->alt_text,
        ]);

        return response()->json([
            'data'         => $items,
            'current_page' => $media->currentPage(),
            'last_page'    => $media->lastPage(),
        ]);
    }
}
