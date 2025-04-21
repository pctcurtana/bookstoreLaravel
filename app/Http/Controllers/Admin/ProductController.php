<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
        }
        
        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/uploads'), $imageName);
        }
        
        // Create product
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imageName ?? null,
        ]);
        
        return redirect()->route('admin.products.index')
                        ->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && File::exists(public_path('images/uploads/' . $product->image))) {
                File::delete(public_path('images/uploads/' . $product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/uploads'), $imageName);
            
            $product->image = $imageName;
        }
        
        // Update product
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
        
        return redirect()->route('admin.products.index')
                        ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the product image if it exists
        if ($product->image && File::exists(public_path('images/uploads/' . $product->image))) {
            File::delete(public_path('images/uploads/' . $product->image));
        }
        
        $product->delete();
        
        return redirect()->route('admin.products.index')
                        ->with('success', 'Sản phẩm đã được xóa thành công!');
    }
} 