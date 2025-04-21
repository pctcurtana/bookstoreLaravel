@extends('layouts.app')

@section('title', 'Trang chủ')

@section('content')
    <section class="hero-section relative py-20 bg-gradient-to-r from-blue-900 to-blue-600" style="background-image: url('{{ asset('images/bookhome.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="w-full md:w-2/3 lg:w-1/2">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 text-white">Khám phá thế giới sách</h1>
                <p class="text-xl mb-8 text-white">Hàng nghìn đầu sách chất lượng đang chờ đón bạn</p>
                @guest
                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg inline-block">
                    Đăng ký ngay
                </a>
                @endguest
            </div>
        </div>
    </section>

    <div id="product" class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-8">Sách nổi bật</h2>
        
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
    </div>

    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Giao hàng miễn phí</h3>
                    <p class="text-gray-600">Cho đơn hàng từ 300.000đ</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-undo text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Đổi trả dễ dàng</h3>
                    <p class="text-gray-600">30 ngày đổi trả miễn phí</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Hỗ trợ 24/7</h3>
                    <p class="text-gray-600">Luôn sẵn sàng hỗ trợ bạn</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-gift text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Mua 1 tặng 1</h3>
                    <p class="text-gray-600">Tính tiền 2</p>
                </div>
            </div>
        </div>
    </section>
@endsection 