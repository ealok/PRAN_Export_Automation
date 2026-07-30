<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'slug', 'description', 'is_visible'];
    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'role_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'role_id');
    }

}
