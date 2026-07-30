<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserRole;
use App\User;
use App\Menu;
use App\Permission;
use App\UserPermission;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('*', function ($view) {
            $userMenusGrouped = Session::get('user_menus');
            
            if (!$userMenusGrouped) {
                try {
                    if (Auth::check()) {
                        $userId = Auth::user()->id;
                        
                        // Get user roles from user_roles table
                        $userRoles = UserRole::where('user_id', $userId)
                            ->where('is_active', 1)
                            ->pluck('role_id')
                            ->toArray();
                        
                        // If no roles found, try from users table (fallback)
                        if (empty($userRoles)) {
                            $userRoles = User::where('id', $userId)
                                ->pluck('role_id')
                                ->toArray();
                        }
                        
                        // Get all root menus with children
                        $allMenus = DB::table('menus as t1')
                            ->leftJoin('menus as m2', 't1.id', '=', 'm2.root_id')
                            ->select(
                                't1.id as root_id',
                                't1.menu_name as root_menu_name',
                                't1.menu_url as root_menu_url',
                                't1.menu_icon as root_menu_icon',
                                't1.priority as root_priority',
                                'm2.id as child_id',
                                'm2.priority as child_priority',
                                'm2.menu_name as child_menu_name',
                                'm2.menu_url as child_menu_url',
                                'm2.menu_icon as child_menu_icon'
                            )
                            ->where('t1.root_id', 0)
                            ->where('t1.status', 1)
                            ->orderBy('t1.priority', 'ASC')
                            ->orderBy('m2.priority', 'ASC')
                            ->get();
                        
                        $filteredMenus = $this->filterMenus($allMenus, $userId, $userRoles);
                        $userMenusGrouped = $filteredMenus->groupBy('root_menu_name');
                        Session::put('user_menus', $userMenusGrouped);
                        
                    } else {
                        $userMenusGrouped = collect([]);
                    }
                } catch (\Exception $e) {
                    $userMenusGrouped = collect([]);
                }
            }
            
            View::share('user_menus', $userMenusGrouped);
        });
    }

    private function filterMenus($allMenus, $userId, $userRoles)
    {
        $filteredMenus = collect();
        foreach ($allMenus as $menu) {
            $menuId = $this->getMenuId($menu);
            $hasPermission = $this->checkMenuPermission($userId, $menuId, $userRoles);
            
            if ($hasPermission) {
                if ($this->isChildMenu($menu)) {
                    $hasChildPermission = $this->checkMenuPermission($userId, $menu->child_id, $userRoles);
                    if ($hasChildPermission) {
                        $filteredMenus->push($menu);
                    }
                } else {
                    $filteredMenus->push($menu);
                }
            }
        }
        
        return $filteredMenus;
    }

    private function getMenuId($menu)
    {
        return (isset($menu->child_id) && !is_null($menu->child_id)) 
            ? $menu->child_id 
            : $menu->root_id;
    }

    private function isChildMenu($menu)
    {
        return isset($menu->child_id) && !is_null($menu->child_id);
    }

    /**
     * 🔥 Main Permission Check Function
     * Priority: User Custom Permission > Role Permission
     * Supports: permissions table (Y/N) and user_permissions table (1/0)
     */
    private function checkMenuPermission($userId, $menuId, $userRoles)
    {
        // 1. Check User Custom Permission (Highest Priority) - uses 1/0
        $userPerm = UserPermission::where('user_id', $userId)
            ->where('menu_id', $menuId)
            ->first();
        
        if ($userPerm && isset($userPerm->wsmu_vsbl) && !is_null($userPerm->wsmu_vsbl)) {
            // user_permissions uses '1' or '0'
            return ($userPerm->wsmu_vsbl == '1');
        }
        
        // 2. Check Role Permission (Fallback) - uses Y/N
        if (!empty($userRoles)) {
            $rolePerm = Permission::whereIn('role_id', $userRoles)
                ->where('menu_id', $menuId)
                ->where('wsmu_vsbl', 'Y')
                ->exists();
            
            if ($rolePerm) {
                return true;
            }
        }
        
        return false;
    }

    public function register()
    {
        //
    }
}