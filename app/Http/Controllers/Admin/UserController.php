<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignedRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('assignedRoles')->orderBy('name');

        if ($request->filled('search')) {
            $term = '%' . $request->search . '%';
            $query->where(function ($builder) use ($term) {
                $builder->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('department', 'like', $term)
                    ->orWhere('job_title', 'like', $term);
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $assignedRoles = AssignedRole::where('is_active', true)->orderBy('label')->get();

        return view('admin.users.create', compact('assignedRoles'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateUser($request, null, true);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'job_title' => $validated['job_title'] ?? null,
            'department' => $validated['department'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $user->assignedRoles()->sync($validated['assigned_roles'] ?? []);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $assignedRoles = AssignedRole::where('is_active', true)->orderBy('label')->get();
        $user->load('assignedRoles');

        return view('admin.users.edit', compact('user', 'assignedRoles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateUser($request, $user, false);

        if (
            $user->isSuperAdmin()
            && (
                ($validated['role'] ?? $user->role) !== 'super_admin'
                || !$request->boolean('is_active', $user->is_active)
            )
            && User::where('role', 'super_admin')->where('is_active', true)->count() <= 1
        ) {
            return back()->withInput()->with('error', 'The last active super admin cannot be downgraded or deactivated.');
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
            'role' => $validated['role'],
            'job_title' => $validated['job_title'] ?? null,
            'department' => $validated['department'] ?? null,
            'is_active' => $request->boolean('is_active', $user->is_active),
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->assignedRoles()->sync($validated['assigned_roles'] ?? []);

        return redirect()
            ->route('admin.users.edit', $user)
            ->with('success', 'User updated successfully.');
    }

    protected function validateUser(Request $request, ?User $user, bool $passwordRequired): array
    {
        $passwordRules = $passwordRequired ? ['required', 'confirmed', 'min:8'] : ['nullable', 'confirmed', 'min:8'];

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'role' => ['required', Rule::in(['super_admin', 'admin', 'user'])],
            'job_title' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'password' => $passwordRules,
            'assigned_roles' => ['nullable', 'array'],
            'assigned_roles.*' => ['exists:assigned_roles,id'],
        ]);
    }
}
