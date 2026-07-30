<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use DateTime;
use App\DashboardSetup;
use App\MenuSetup;
use Auth;
class HomeController extends Controller{
   
    public function __construct(){

        $this->middleware('auth');
    }

    public function index()
    {   
        $results=DashboardSetup::orderBy('seq','asc')->get();
        return view('home')->with('results',$results);

    }
    
   // Get top menus API endpoint - FIXED
    public function getTopMenus()
    {

        try {

            $menus = DB::table('menus')
                      ->where('is_feature', 1)
                      ->where('status', 1)
                      ->select('id', 'menu_name as name', 'description', 'menu_icon as icon', 'menu_url as url', 'color')
                      ->orderBy('priority', 'asc')
                      ->get();

            return response()->json([
                'success' => true,
                'data' => $menus
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to load menus'
            ], 500);

        }
    }
    
    // Save user menu selection - FIXED
    public function saveUserMenus(Request $request)
    {
        try {
            $userId = Auth::id();
            $selectedMenus = $request->input('selectedMenus', []);
            $menuOrder = $request->input('menuOrder', []);
            
            
            
            // Validate - শুধু feature menu গুলোই save করা যাবে
            $validMenuIds = DB::table('menus')
                             ->where('is_feature', 1)
                             ->where('status', 1)
                             ->whereIn('id', $selectedMenus)
                             ->pluck('id')
                             ->toArray();
            
            $filteredMenus = array_intersect($selectedMenus, $validMenuIds);
            
            DB::beginTransaction();
            
            // Delete existing user menus
            DB::table('user_dashboard_menus')
                ->where('user_id', $userId)
                ->delete();
            
            // Insert new selections with order
            $insertData = [];
            foreach ($filteredMenus as $menuId) {
                $orderIndex = array_search($menuId, $menuOrder);
                $insertData[] = [
                    'user_id' => $userId,
                    'menu_id' => $menuId,
                    'sort_order' => $orderIndex !== false ? $orderIndex : 0,
                    'created_at' => date('Y-m-d'),
                    'updated_at' => date('Y-m-d')
                ];
            }
            
            if (!empty($insertData)) {
                DB::table('user_dashboard_menus')->insert($insertData);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Dashboard saved successfully',
                'saved_count' => count($insertData)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to save dashboard: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // Get user's dashboard menus - FIXED
    public function getUserDashboard()
    {
        try {
            $userId = Auth::id();
            
            $menus = DB::table('user_dashboard_menus')
                      ->join('menus', 'user_dashboard_menus.menu_id', '=', 'menus.id')
                      ->where('user_dashboard_menus.user_id', $userId)
                      ->where('menus.is_feature', 1)
                      ->where('menus.status', 1)
                      ->select('menus.id', 'menus.menu_name as name', 'menus.description', 
                               'menus.menu_icon as icon', 'menus.menu_url as url', 
                               'menus.color')
                      ->orderBy('user_dashboard_menus.sort_order', 'asc')
                      ->get();
            
            return response()->json([
                'success' => true,
                'data' => $menus
            ]);
        } catch (\Exception $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load dashboard'
            ], 500);
        }
    }

}
