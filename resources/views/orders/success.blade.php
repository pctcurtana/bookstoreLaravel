@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-8">
            <div class="text-center mb-8">
                <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Đặt hàng thành công!</h1>
                <p class="text-gray-600">Cảm ơn bạn đã mua sắm tại Book Store</p>
            </div>
            
            <div class="border-t border-b py-4 mb-6">
                <h2 class="font-semibold text-lg mb-2">Thông tin đơn hàng #{{ $order->id }}</h2>
                <p class="text-gray-600 mb-1">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p class="text-gray-600">Tổng tiền: <span class="font-semibold text-red-600">{{ number_format($order->total_amount) }}đ</span></p>
            </div>
            
            <div class="mb-8">
                <h2 class="font-semibold text-lg mb-2">Đơn hàng sẽ được giao đến</h2>
                <p class="text-gray-700">{{ $order->address }}</p>
                <p class="text-gray-700">Điện thoại: {{ $order->phone }}</p>
            </div>
            
            <div class="border-t pt-6">
                <h2 class="font-semibold text-lg mb-4">Đơn hàng của bạn</h2>
                
                <div class="space-y-4 mb-6">
                    @foreach($order->orderItems as $item)
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                <img class="h-16 w-16 object-cover rounded" 
                                    src="{{ asset('images/uploads/' . $item->product->image) }}" 
                                    alt="{{ $item->product->name }}">
                            </div>
                            <div class="ml-4 flex-grow">
                                <div class="flex justify-between">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->quantity }} x {{ number_format($item->price) }}đ</div>
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ number_format($item->price * $item->quantity) }}đ</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="flex justify-between text-lg font-bold mb-6">
                    <span>Tổng cộng</span>
                    <span class="text-red-600">{{ number_format($order->total_amount) }}đ</span>
                </div>
                
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('orders.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded">
                        Xem đơn hàng của tôi
                    </a>
                    <a href="{{ route('home') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded">
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mt-4">
                <h3 class="text-lg font-semibold mb-2">Chi tiết đơn hàng:</h3>
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                    <div class="flex justify-between">
                        <div>
                            <span class="font-medium">{{ $item->product->name }}</span>
                            <span class="text-gray-600"> x {{ $item->quantity }}</span>
                        </div>
                        <span>{{ number_format($item->price * $item->quantity) }}đ</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection 