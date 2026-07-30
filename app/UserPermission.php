<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'user_permissions';
    protected $fillable = ['user_id', 'menu_id', 'wsmu_vsbl', 'wsmu_crat', 'wsmu_read', 'wsmu_updt', 'wsmu_delt'];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id');
    }
}
