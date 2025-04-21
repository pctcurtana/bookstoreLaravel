<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
    {
        $orders = Order::with('user')
                  ->orderBy('created_at', 'desc')
                  ->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])
                ->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status' => 'required|string|in:Chờ xử lý,Đang giao,Đã giao,Đã hủy',
        ]);
        
        $order = Order::findOrFail($request->order_id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Đã cập nhật trạng thái đơn hàng #' . $order->id . ' từ "' . $oldStatus . '" sang "' . $request->status . '"'
        ]);
    }
} 