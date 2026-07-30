<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Menu;
use App\Permission;
use App\UserPermission;
use App\UserRole;
use App\MenuSetup;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $permission;
    protected $canView = false;
    protected $canCreate = false;
    protected $canRead = false;
    protected $canUpdate = false;
    protected $canDelete = false;
    protected $viewPermissions;
    public function __construct()
    {
    
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            
            $action_url = $request->path();        
            $menu = MenuSetup::where('menu_url', '/' . $action_url)->first();
            if($menu){

                $userId = Auth::user()->id;
                $userRoles = UserRole::where('user_id', $userId)
                    ->where('is_active', 1)
                    ->pluck('role_id')
                    ->toArray();

                $rolePermission = Permission::whereIn('role_id', $userRoles)
                    ->where('menu_id', $menu->id)
                    ->first();

                $userPermission = UserPermission::where('user_id', $userId)
                    ->where('menu_id', $menu->id)
                    ->first();      
                
                // Merge permissions (user custom overrides role)
                $finalVsbl = $this->getFinalPermission($rolePermission, $userPermission, 'wsmu_vsbl');
                $finalCrat = $this->getFinalPermission($rolePermission, $userPermission, 'wsmu_crat');
                $finalRead = $this->getFinalPermission($rolePermission, $userPermission, 'wsmu_read');
                $finalUpdt = $this->getFinalPermission($rolePermission, $userPermission, 'wsmu_updt');
                $finalDelt = $this->getFinalPermission($rolePermission, $userPermission, 'wsmu_delt');
                
                // Set permission flags
                $this->canView = ($finalVsbl == '1');
                $this->canCreate = ($finalCrat == '1');
                $this->canRead = ($finalRead == '1');
                $this->canUpdate = ($finalUpdt == '1');
                $this->canDelete = ($finalDelt == '1');
                
                // Store full permission object
                $this->permission = (object)[
                    'wsmu_vsbl' => $finalVsbl,
                    'wsmu_crat' => $finalCrat,
                    'wsmu_read' => $finalRead,
                    'wsmu_updt' => $finalUpdt,
                    'wsmu_delt' => $finalDelt,
                ];
                
            } else {
                // No menu found, allow all actions
                $this->canView = true;
                $this->canCreate = true;
                $this->canRead = true;
                $this->canUpdate = true;
                $this->canDelete = true;
            }
            
            // NEW: Create view permissions object
            $this->viewPermissions = (object)[
                'can_view' => $this->canView,
                'can_create' => $this->canCreate,
                'can_read' => $this->canRead,
                'can_update' => $this->canUpdate,
                'can_delete' => $this->canDelete
            ];

            view()->share('viewPermissions', $this->viewPermissions);
            return $next($request);

        });
    }
    
    /**
     * Get final permission (user custom overrides role)
     */
    private function getFinalPermission($rolePermission, $userPermission, $field)
    {
        // Check user custom permission first (highest priority)
        if ($userPermission && $userPermission->$field !== null) {
            return $userPermission->$field;
        }
        // Fallback to role permission
        if ($rolePermission) {
            return $rolePermission->$field;
        }
        // Default to '0' (no permission)
        return '0';
    }
    
    /**
     * Check permission and abort if not allowed (auto abort)
     */
    protected function canView()
    {
        if (!$this->canView) {
            abort(403, 'You do not have permission to view this page.');
        }
        return true;
    }
    
    protected function canCreate()
    {
        if (!$this->canCreate) {
            abort(403, 'You do not have permission to create new records.');
        }
        return true;
    }
    
    protected function canRead()
    {
        if (!$this->canRead) {
            abort(403, 'You do not have permission to read this data.');
        }
        return true;
    }
    
    protected function canUpdate()
    {
        if (!$this->canUpdate) {
            abort(403, 'You do not have permission to update this data.');
        }
        return true;
    }
    
    protected function canDelete()
    {
        if (!$this->canDelete) {
            abort(403, 'You do not have permission to delete this data.');
        }
        return true;
    }
    
    /**
     * Check permission and return boolean (without abort)
     */
    protected function hasViewPermission()
    {
        return $this->canView;
    }
    
    protected function hasCreatePermission()
    {
        return $this->canCreate;
    }
    
    protected function hasReadPermission()
    {
        return $this->canRead;
    }
    
    protected function hasUpdatePermission()
    {
        return $this->canUpdate;
    }
    
    protected function hasDeletePermission()
    {
        return $this->canDelete;
    }
    
    /**
     * Get all permissions as array
     */
    protected function getAllPermissions()
    {
        return [
            'view' => $this->canView,
            'create' => $this->canCreate,
            'read' => $this->canRead,
            'update' => $this->canUpdate,
            'delete' => $this->canDelete,
        ];
    }
    
    /**
     * Get permission object
     */
    protected function getPermission()
    {
        return $this->permission;
    }
    
    /**
     * NEW: Get view permissions object
     */
    protected function getViewPermissions()
    {
        return $this->viewPermissions;
    }
}