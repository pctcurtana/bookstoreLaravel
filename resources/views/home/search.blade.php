@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Kết quả tìm kiếm: "{{ $query }}"</h1>
    
    @if ($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image-wrapper">
                        <img src="{{ asset('images/uploads/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="product-image">
                    </div>
                    <div class="p-4">
                        <h3 class="card-title font-semibold">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $product->author }}</p>
                        <p class="text-red-600 font-bold mt-2">{{ number_format($product->price) }}đ</p>
                        <div class="mt-4 space-y-2">
                            @auth
                                <a href="{{ route('products.show', $product->id) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded">
                                    <i class="fa-solid fa-circle-info"></i> Xem chi tiết
                                </a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="block w-full border border-blue-600 text-blue-600 hover:bg-blue-50 text-center py-2 rounded">
                                        <i class="fas fa-cart-plus mr-2"></i> Thêm vào giỏ
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('products.show', $product->id) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded">
                                    <i class="fa-solid fa-circle-info"></i> Xem chi tiết
                                </a>
                                <a href="{{ route('login') }}" class="block w-full border border-blue-600 text-blue-600 hover:bg-blue-50 text-center py-2 rounded">
                                    <i class="fas fa-cart-plus mr-2"></i> Thêm vào giỏ
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $products->appends(['query' => $query])->links() }}
        </div>
    @else
        <div class="bg-blue-50 p-6 rounded-lg text-center">
            <i class="fas fa-book-open text-blue-500 text-4xl mb-4"></i>
            <h3 class="text-xl font-semibold mb-2">Không tìm thấy sách nào</h3>
            <p class="text-gray-600 mb-4">Chúng tôi không tìm thấy sách nào phù hợp với từ khóa "{{ $query }}"</p>
            <a href="{{ route('index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded inline-block">
                <i class="fas fa-arrow-left mr-1"></i> Quay lại trang chủ
            </a>
        </div>
    @endif
</div>
@endsection 