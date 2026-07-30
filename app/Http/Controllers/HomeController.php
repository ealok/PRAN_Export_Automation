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
    
    //Get top menus API endpoint - FIXED
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

    public function getSoftwareList(Request $request)
    {
        try {
            // API Call
            $curl = curl_init();
            $staffId = isset($request->staffId) ? $request->staffId : "334052";
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://hrisapi.prangroup.com:8083/v1/PPGSoftList/SoftwareList',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    "staffId" => $staffId
                ]),
                CURLOPT_HTTPHEADER => array(
                    'S_KEYL: RxsJ4LQdkVFTv37rYfW9b6',
                    'Content-Type: application/json',
                    'Authorization: Basic YXV0aDoxMlByYW5AMTIzNDU2JA=='
                ),
            ));
            
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);
            curl_close($curl);
            if ($error) {
                throw new \Exception("CURL Error: " . $error);
            }
            
            if ($httpCode != 200) {
                throw new \Exception("API Error: HTTP Code " . $httpCode);
            }
            
            $data = json_decode($response, true);
            
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid response from API',
                    'data' => []
                ]);
            }
            
            if (!isset($data['successCode'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid response format',
                    'data' => []
                ]);
            }
            
            if ($data['successCode'] != '2000') {
                $message = isset($data['successMessage']) ? $data['successMessage'] : 'No software found';
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'data' => []
                ]);
            }
            
            if (empty($data['data'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No software found',
                    'data' => []
                ]);
            }
            
            // Group by project type with sorting
            $categorizedData = $this->groupByType($data['data']);
            
            return response()->json([
                'success' => true,
                'message' => 'Software list retrieved successfully',
                'data' => $categorizedData,
                'total' => count($data['data'])
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch software: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Group by project type with sorting (A-Z)
     */
    private function groupByType($softwareList)
    {
        $grouped = array();
        
        foreach ($softwareList as $software) {
            // project_type ফিল্ড থেকে Category Name নিন
            $type = 'Uncategorized';
            if (isset($software['project_type']) && !empty($software['project_type'])) {
                $type = $software['project_type'];
            }
            
            // Group by project_type
            if (!isset($grouped[$type])) {
                $grouped[$type] = array(
                    'name' => $type,
                    'items' => array()
                );
            }
            $grouped[$type]['items'][] = $software;
        }
        
        // Sort categories by name (A-Z)
        ksort($grouped);
        
        // Sort items within each category by title (A-Z)
        foreach ($grouped as $key => $category) {
            usort($grouped[$key]['items'], function($a, $b) {
                $titleA = isset($a['project_title']) ? strtoupper($a['project_title']) : '';
                $titleB = isset($b['project_title']) ? strtoupper($b['project_title']) : '';
                return strcmp($titleA, $titleB);
            });
        }
        
        return array_values($grouped);
    }

    /**
     * Save Category Order
     */
    public function saveCategoryOrder(Request $request)
    {
        try {
            // Check if user is logged in
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ]);
            }

            $userId = Auth::user()->id;
            $categoryIds = json_decode($request->categoryIds, true);
            
            // Check if category IDs exist
            if (empty($categoryIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No categories provided'
                ]);
            }
            
            $categoryNames = array();
            if (isset($request->category_names)) {
                $categoryNames = $request->category_names;
            }
            
            $currentDate = date('Y-m-d H:i:s');
            
            // Delete existing order for this user
            DB::table('user_software_category_order')
                ->where('user_id', $userId)
                ->delete();
            
            // Insert new order
            foreach ($categoryIds as $index => $categoryId) {
                $categoryName = $categoryId;
                if (isset($categoryNames[$index])) {
                    $categoryName = $categoryNames[$index];
                }
                
                DB::table('user_software_category_order')->insert(array(
                    'user_id' => $userId,
                    'category_id' => $categoryId,
                    'category_name' => $categoryName,
                    'order_position' => $index + 1,
                    'created_at' => $currentDate,
                    'updated_at' => $currentDate
                ));
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Category order saved successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save category order: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Save Item Order
     */
    public function saveItemOrder(Request $request)
    {
        try {
            // Check if user is logged in
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ]);
            }

            $userId = Auth::user()->id;
            $orderData = json_decode($request->orderData, true);
            
            // Check if order data exists
            if (empty($orderData)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No items provided'
                ]);
            }
            
            $currentDate = date('Y-m-d H:i:s');
            
            // Delete existing item orders for this user
            DB::table('user_software_item_order')
                ->where('user_id', $userId)
                ->delete();
            
            // Insert new item orders
            foreach ($orderData as $categoryData) {
                $categoryId = '';
                if (isset($categoryData['categoryId'])) {
                    $categoryId = $categoryData['categoryId'];
                }
                
                $itemIds = array();
                if (isset($categoryData['itemIds'])) {
                    $itemIds = $categoryData['itemIds'];
                }
                
                foreach ($itemIds as $position => $itemId) {
                    DB::table('user_software_item_order')->insert(array(
                        'user_id' => $userId,
                        'category_id' => $categoryId,
                        'item_id' => $itemId,
                        'order_position' => $position + 1,
                        'created_at' => $currentDate,
                        'updated_at' => $currentDate
                    ));
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Item order saved successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save item order: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get All Orders
     */
    public function getOrders(Request $request)
    {
        try {
            // Check if user is logged in
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ]);
            }

            $userId = Auth::user()->id;
            
            // Get Category Order
            $categoryOrders = DB::table('user_software_category_order')
                ->where('user_id', $userId)
                ->orderBy('order_position', 'asc')
                ->get();
            
            // Get Item Order
            $itemOrders = DB::table('user_software_item_order')
                ->where('user_id', $userId)
                ->orderBy('order_position', 'asc')
                ->get();
            
            // Format Category Order with names
            $categoryOrder = array();
            $categoryNameMap = array();
            
            foreach ($categoryOrders as $cat) {
                $categoryOrder[] = $cat->category_id;
                $categoryNameMap[$cat->category_id] = $cat->category_name;
            }
            
            // Format Item Order
            $itemOrderMap = array();
            
            foreach ($itemOrders as $item) {
                if (!isset($itemOrderMap[$item->category_id])) {
                    $itemOrderMap[$item->category_id] = array();
                }
                $itemOrderMap[$item->category_id][] = $item->item_id;
            }
            
            // Convert to array format
            $itemOrder = array();
            foreach ($itemOrderMap as $categoryId => $itemIds) {
                $itemOrder[] = array(
                    'categoryId' => $categoryId,
                    'itemIds' => $itemIds
                );
            }
            
            return response()->json(array(
                'success' => true,
                'data' => array(
                    'categoryOrder' => $categoryOrder,
                    'categoryNameMap' => $categoryNameMap,
                    'itemOrder' => $itemOrder
                )
            ));
            
        } catch (\Exception $e) {
            return response()->json(array(
                'success' => false,
                'message' => 'Failed to get orders: ' . $e->getMessage()
            ));
        }
    }

}
