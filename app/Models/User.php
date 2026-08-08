<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'phone_number',
        'role',
        'job_title',
        'department',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function approvedQuotations()
    {
        return $this->hasMany(Quotation::class, 'approved_by');
    }

    public function rejectedQuotations()
    {
        return $this->hasMany(Quotation::class, 'rejected_by');
    }

    public function paidQuotations()
    {
        return $this->hasMany(Quotation::class, 'paid_by');
    }

    public function assignedOrders()
    {
        return $this->hasMany(Order::class, 'assigned_to');
    }

    public function assignedRoles()
    {
        return $this->belongsToMany(AssignedRole::class, 'assigned_role_user')->withTimestamps();
    }

    /**
     * Get the blog posts authored by the user.
     */
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    /**
     * Get the product pages created by the user.
     */
    public function createdPages()
    {
        return $this->hasMany(ProductPage::class, 'created_by');
    }

    /**
     * Get the product pages updated by the user.
     */
    public function updatedPages()
    {
        return $this->hasMany(ProductPage::class, 'updated_by');
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function isSupplier(): bool
    {
        return $this->role === 'supplier';
    }

    public function supplierProfile()
    {
        return $this->hasOne(SupplierProfile::class);
    }

    /**
     * Check if user is an editor.
     */
    public function isEditor()
    {
        return false;
    }

    /**
     * Check if user has admin or editor role.
     */
    public function canManageContent()
    {
        return $this->hasPermission('products.manage')
            || $this->hasPermission('product_pages.manage')
            || $this->hasPermission('marketing_templates.manage');
    }

    public function hasBaseRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function hasAnyBaseRole(array $roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function hasAssignedRole(string $role): bool
    {
        return $this->assignedRoles->contains('name', $role);
    }

    public function hasAnyAssignedRole(array $roles): bool
    {
        return $this->assignedRoles->whereIn('name', $roles)->isNotEmpty();
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        if ($this->isAdmin() && $this->isAdminSystemPermission($permission)) {
            return true;
        }

        return $this->assignedRoles()
            ->where('assigned_roles.is_active', true)
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('permissions.name', $permission);
            })
            ->exists();
    }

    public function canAccessAdmin(): bool
    {
        if ($this->isSupplier()) {
            return false;
        }

        if ($this->hasAnyBaseRole(['super_admin', 'admin'])) {
            return $this->is_active;
        }

        return $this->is_active && $this->assignedRoles()->where('assigned_roles.is_active', true)->exists();
    }

    protected function isAdminSystemPermission(string $permission): bool
    {
        return in_array($permission, [
            'dashboard.view',
            'users.view',
            'users.create',
            'users.update',
            'users.assign_roles',
            'assigned_roles.view',
            'assigned_roles.create',
            'assigned_roles.update',
            'assigned_roles.assign_permissions',
        ], true);
    }
}
