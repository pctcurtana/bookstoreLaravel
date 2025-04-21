@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    <div class="aspect-w-1 aspect-h-1 relative">
                        <img src="{{ asset('images/uploads/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="object-cover w-full h-full">
                    </div>
                </div>
                
                <div class="md:w-1/2 p-8">
                    <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>
                    
                    <div class="mb-4">
                        <span class="text-2xl font-bold text-red-600">{{ number_format($product->price) }}đ</span>
                    </div>
                    
                    <div class="mb-6">
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <span class="text-gray-700 font-medium">Tình trạng:</span>
                        @if($product->stock > 0)
                            <span class="text-green-600 font-semibold">Còn hàng ({{ $product->stock }})</span>
                        @else
                            <span class="text-red-600 font-semibold">Hết hàng</span>
                        @endif
                    </div>
                    
                    @auth
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center mb-4">
                                    <label for="quantity" class="mr-4 text-gray-700 font-medium">Số lượng:</label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                        class="w-20 border border-gray-300 rounded px-3 py-2">
                                </div>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">
                                    <i class="fas fa-shopping-cart mr-2"></i> Thêm vào giỏ hàng
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="mb-6">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">
                                Đăng nhập để mua hàng
                            </a>
                        </div>
                    @endauth
                    
                    <div class="border-t pt-4">
                        <span class="text-gray-700 font-medium">Danh mục:</span> 
                        <span>Sách</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- <div class="mt-8 bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Thông tin chi tiết</h2>
            <div class="prose max-w-none">
                {!! $product->content !!}
            </div>
        </div> --}}
    </div>
@endsection 