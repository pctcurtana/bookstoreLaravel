<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Hiển thị lịch sử đặt hàng
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->with('orderItems.product')
            ->get();
            
        return view('orders.index', compact('orders'));
    }
    
    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->with('orderItems.product')
            ->firstOrFail();
            
        return view('orders.show', compact('order'));
    }
    
    // Hiển thị form thanh toán
    public function checkout()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();
            
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }
        
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('orders.checkout', compact('cartItems', 'total', 'user'));
    }
    
    // Xử lý đặt hàng
    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)
            ->with('product')
            ->get();
            
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }
        
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
        ]);
        
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        DB::beginTransaction();
        
        try {
            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'Chờ xử lý',
                'address' => $request->address,
                'phone' => $request->phone,
            ]);
            
            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
                
                // Giảm số lượng sản phẩm trong kho
                $product = Product::find($item->product_id);
                $product->stock -= $item->quantity;
                $product->save();
            }
            
            // Xóa giỏ hàng
            Cart::where('user_id', $user->id)->delete();
            
            DB::commit();
            
            return redirect()->route('orders.success', $order->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    
    // Hiển thị trang đặt hàng thành công
    public function success($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->with('orderItems.product')
            ->firstOrFail();
            
        return view('orders.success', compact('order'));
    }
}
