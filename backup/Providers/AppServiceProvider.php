<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use DB;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {

            $userMenusGrouped = Session::get('user_menus');
            if (!$userMenusGrouped) {
                try {
                    if (Auth::check()) {

                        $role_id = Auth::user()->role_id;
                        $userMenus = DB::table('menus as t1')
                            ->leftJoin('menus as m2', 't1.id', '=', 'm2.root_id')
                            ->leftJoin('permissions', 'permissions.menu_id', '=', DB::raw('IFNULL(m2.id, t1.id)'))
                            ->select(
                                't1.id as root_id',
                                't1.menu_name as root_menu_name',
                                't1.menu_url as root_menu_url',
                                't1.menu_icon as root_menu_icon',
                                't1.priority as root_priority',
                                DB::raw('IFNULL(m2.id, t1.id) as child_id'),
                                'm2.priority as child_priority',
                                'm2.menu_name as child_menu_name',
                                'm2.menu_url as child_menu_url',
                                'm2.menu_icon as child_menu_icon'
                            )
                            ->where('t1.root_id', 0)
                            ->where('permissions.wsmu_vsbl', 'Y')
                            ->where('permissions.role_id', $role_id)
                            ->orderBy('t1.priority', 'ASC')
                            ->orderBy('m2.priority', 'ASC')
                            ->get();

                        $userMenusGrouped = $userMenus->groupBy('root_menu_name');
                        Session::put('user_menus', $userMenusGrouped);
                    }
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
                
            }

            // Share the user menu with all views
            view()->share('user_menus', $userMenusGrouped);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
