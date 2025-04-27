<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    // Trang chủ chung cho cả người dùng đã đăng nhập và chưa đăng nhập
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
            
        return view('home.index', compact('products'));
    }
    
    // Chuyển hướng từ /home về trang chủ
    public function home()
    {
        return redirect()->route('index');
    }
    
    // Xử lý tìm kiếm sách
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $products = Product::where('name', 'like', "%{$query}%")
            ->paginate(12);
        
        return view('home.search', compact('products', 'query'));
    }
}
