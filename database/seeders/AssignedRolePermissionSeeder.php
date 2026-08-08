<?php

namespace Database\Seeders;

use App\Models\AssignedRole;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class AssignedRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'dashboard.view', 'label' => 'View Dashboard', 'group' => 'dashboard'],
            ['name' => 'products.manage', 'label' => 'Manage Products', 'group' => 'catalog'],
            ['name' => 'categories.manage', 'label' => 'Manage Categories', 'group' => 'catalog'],
            ['name' => 'services.manage', 'label' => 'Manage Services', 'group' => 'catalog'],
            ['name' => 'product_pages.manage', 'label' => 'Manage Product Pages', 'group' => 'catalog'],
            ['name' => 'marketing_templates.manage', 'label' => 'Manage Marketing Templates', 'group' => 'catalog'],
            ['name' => 'quotations.view', 'label' => 'View Quotations', 'group' => 'quotations'],
            ['name' => 'quotations.update', 'label' => 'Update Quotations', 'group' => 'quotations'],
            ['name' => 'quotations.assign', 'label' => 'Assign Quotations', 'group' => 'quotations'],
            ['name' => 'quotations.accept', 'label' => 'Accept Quotations', 'group' => 'quotations'],
            ['name' => 'quotations.reject', 'label' => 'Reject Quotations', 'group' => 'quotations'],
            ['name' => 'quotations.mark_paid', 'label' => 'Mark Quotations Paid', 'group' => 'quotations'],
            ['name' => 'quotations.convert_to_order', 'label' => 'Convert Quotations to Orders', 'group' => 'quotations'],
            ['name' => 'orders.view', 'label' => 'View Orders', 'group' => 'orders'],
            ['name' => 'orders.update', 'label' => 'Update Orders', 'group' => 'orders'],
            ['name' => 'orders.assign', 'label' => 'Assign Orders', 'group' => 'orders'],
            ['name' => 'users.view', 'label' => 'View Users', 'group' => 'system'],
            ['name' => 'users.create', 'label' => 'Create Users', 'group' => 'system'],
            ['name' => 'users.update', 'label' => 'Update Users', 'group' => 'system'],
            ['name' => 'users.assign_roles', 'label' => 'Assign User Roles', 'group' => 'system'],
            ['name' => 'assigned_roles.view', 'label' => 'View Assigned Roles', 'group' => 'system'],
            ['name' => 'assigned_roles.create', 'label' => 'Create Assigned Roles', 'group' => 'system'],
            ['name' => 'assigned_roles.update', 'label' => 'Update Assigned Roles', 'group' => 'system'],
            ['name' => 'assigned_roles.assign_permissions', 'label' => 'Assign Permissions to Roles', 'group' => 'system'],
            ['name' => 'suppliers.view', 'label' => 'View Suppliers', 'group' => 'suppliers'],
            ['name' => 'suppliers.manage', 'label' => 'Manage Suppliers', 'group' => 'suppliers'],
            ['name' => 'supplier_products.approve', 'label' => 'Approve/Reject Supplier Products', 'group' => 'suppliers'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        $roles = [
            'procurement_manager' => [
                'label' => 'Procurement Manager',
                'description' => 'Oversees quotations, procurement workflow, and order handoff.',
                'permissions' => [
                    'dashboard.view',
                    'quotations.view',
                    'quotations.update',
                    'quotations.assign',
                    'quotations.accept',
                    'quotations.reject',
                    'quotations.convert_to_order',
                    'orders.view',
                ],
            ],
            'quotation_officer' => [
                'label' => 'Quotation Officer',
                'description' => 'Handles quotation review and quotation approval decisions.',
                'permissions' => [
                    'dashboard.view',
                    'quotations.view',
                    'quotations.update',
                    'quotations.assign',
                    'quotations.accept',
                    'quotations.reject',
                ],
            ],
            'finance_officer' => [
                'label' => 'Finance Officer',
                'description' => 'Handles invoice review, payment confirmation, and order finance visibility.',
                'permissions' => [
                    'dashboard.view',
                    'quotations.view',
                    'quotations.mark_paid',
                    'orders.view',
                ],
            ],
            'logistics_officer' => [
                'label' => 'Logistics Officer',
                'description' => 'Manages order conversion, tracking, and delivery updates.',
                'permissions' => [
                    'dashboard.view',
                    'quotations.view',
                    'quotations.convert_to_order',
                    'orders.view',
                    'orders.update',
                    'orders.assign',
                ],
            ],
            'content_editor' => [
                'label' => 'Content Editor',
                'description' => 'Manages products, pages, services, and marketing content.',
                'permissions' => [
                    'dashboard.view',
                    'products.manage',
                    'categories.manage',
                    'services.manage',
                    'product_pages.manage',
                    'marketing_templates.manage',
                ],
            ],
            'support_officer' => [
                'label' => 'Support Officer',
                'description' => 'Monitors customer quotations and order records for support.',
                'permissions' => [
                    'dashboard.view',
                    'quotations.view',
                    'orders.view',
                ],
            ],
        ];

        foreach ($roles as $name => $roleData) {
            $assignedRole = AssignedRole::updateOrCreate(
                ['name' => $name],
                [
                    'label' => $roleData['label'],
                    'description' => $roleData['description'],
                    'is_active' => true,
                ]
            );

            $permissionIds = Permission::whereIn('name', $roleData['permissions'])->pluck('id');
            $assignedRole->permissions()->sync($permissionIds);
        }
    }
}
