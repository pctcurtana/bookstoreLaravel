@extends('layouts.app')

@section('title', 'Thanh toán')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Thanh toán</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Thông tin giao hàng</h2>
                    
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Địa chỉ giao hàng</label>
                            <textarea id="address" name="address" rows="3" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address') border-red-500 @enderror">{{ $user->address }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" value="{{ $user->phone }}" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end">
                            <a href="{{ route('cart.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded mr-4">
                                Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Hoàn tất đặt hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Đơn hàng của bạn</h2>
                    
                    <div class="border-b pb-4 mb-4">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <span class="mr-2">{{ $item->quantity }}x</span>
                                    <span class="text-sm">{{ $item->product->name }}</span>
                                </div>
                                <span class="text-sm font-medium">{{ number_format($item->quantity * $item->product->price) }}đ</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-b pb-4 mb-4">
                        <div class="flex justify-between mb-2">
                            <span>Tạm tính</span>
                            <span>{{ number_format($total) }}đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Phí vận chuyển</span>
                            <span>Miễn phí</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-between font-bold">
                        <span>Tổng cộng</span>
                        <span class="text-red-600">{{ number_format($total) }}đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 