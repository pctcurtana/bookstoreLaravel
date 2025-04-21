<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Hiển thị trang dashboard
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_amount');
        
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $topProducts = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $product = Product::find($item->product_id);
                if (!$product) {
                    return null;
                }
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'total_sold' => $item->total_sold
                ];
            })
            ->filter(function($item) {
                return $item !== null;
            });
            
        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalProducts', 
            'totalOrders', 
            'totalRevenue', 
            'recentOrders', 
            'topProducts'
        ));
    }
}
