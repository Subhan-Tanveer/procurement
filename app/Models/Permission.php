<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'group',
    ];

    public function assignedRoles()
    {
        return $this->belongsToMany(AssignedRole::class, 'assigned_role_permission')->withTimestamps();
    }
}
