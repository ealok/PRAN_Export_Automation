<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model{
    
    protected $table = 'user_roles';
    protected $fillable = [
        'user_id', 'role_id', 'assigned_by', 'expires_at', 'is_active'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }
    
    public function assignedBy()
    {
        return $this->belongsTo('App\User', 'assigned_by');
    }

}
