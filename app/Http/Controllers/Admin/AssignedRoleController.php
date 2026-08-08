<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssignedRole;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssignedRoleController extends Controller
{
    public function index()
    {
        $assignedRoles = AssignedRole::withCount(['users', 'permissions'])
            ->orderBy('label')
            ->paginate(20);

        return view('admin.assigned-roles.index', compact('assignedRoles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('group')->orderBy('label')->get()->groupBy('group');

        return view('admin.assigned-roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateAssignedRole($request);

        $assignedRole = AssignedRole::create([
            'name' => $validated['name'],
            'label' => $validated['label'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        $assignedRole->permissions()->sync($validated['permissions'] ?? []);

        return redirect()
            ->route('admin.assigned-roles.index')
            ->with('success', 'Assigned role created successfully.');
    }

    public function edit(AssignedRole $assignedRole)
    {
        $assignedRole->load('permissions');
        $permissions = Permission::orderBy('group')->orderBy('label')->get()->groupBy('group');

        return view('admin.assigned-roles.edit', compact('assignedRole', 'permissions'));
    }

    public function update(Request $request, AssignedRole $assignedRole)
    {
        $validated = $this->validateAssignedRole($request, $assignedRole);

        $assignedRole->update([
            'name' => $validated['name'],
            'label' => $validated['label'],
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', $assignedRole->is_active),
        ]);

        $assignedRole->permissions()->sync($validated['permissions'] ?? []);

        return redirect()
            ->route('admin.assigned-roles.edit', $assignedRole)
            ->with('success', 'Assigned role updated successfully.');
    }

    protected function validateAssignedRole(Request $request, ?AssignedRole $assignedRole = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('assigned_roles', 'name')->ignore($assignedRole?->id),
            ],
            'label' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);
    }
}
