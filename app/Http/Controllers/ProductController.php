<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
    
    public function image($filename)
    {
        // Nếu file tồn tại trong thư mục uploads, trả về file đó
        if (file_exists(public_path($filename))) {
            return response()->file(public_path($filename));
        }
        
        // Nếu không, trả về ảnh mặc định
        return response()->file(public_path('images/book-placeholder.jpg'));
    }
}
