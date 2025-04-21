<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    // Thêm sản phẩm vào giỏ hàng (Xử lý GET request từ liên kết)
    public function add($id)
    {
        $product = Product::findOrFail($id);
        
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();
            
        if ($existingCart) {
            $existingCart->quantity += 1;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
    }
    
    // Thêm sản phẩm vào giỏ hàng (Xử lý POST request từ form)
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $productId = $request->product_id;
        $quantity = $request->quantity;
        
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();
            
        if ($existingCart) {
            $existingCart->quantity += $quantity;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
        
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng');
    }
    
    // Cập nhật số lượng
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);
        
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();
        
        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật');
    }
    
    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng');
    }
}
