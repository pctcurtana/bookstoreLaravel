@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Đơn hàng của tôi</h1>

        @if($orders->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <p class="text-gray-700 text-lg text-center py-8">Bạn chưa có đơn hàng nào</p>
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Mua sắm ngay
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                            <div>
                                <span class="font-semibold">Đơn hàng #{{ $order->id }}</span>
                                <span class="text-gray-600 text-sm ml-4">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                @if($order->status == 'Chờ xử lý')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $order->status }}</span>
                                @elseif($order->status == 'Đang giao')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">{{ $order->status }}</span>
                                @elseif($order->status == 'Đã giao')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $order->status }}</span>
                                @elseif($order->status == 'Đã hủy')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs">{{ $order->status }}</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $order->status }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="border-b pb-4 mb-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center mb-3">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 object-cover" 
                                                src="{{ asset('images/uploads/' . $item->product->image) }}" 
                                                alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="ml-4 flex-grow">
                                            <div class="flex justify-between">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                                    <div class="text-sm text-gray-500">SL: {{ $item->quantity }}</div>
                                                </div>
                                                <div class="text-sm font-medium text-gray-900">{{ number_format($item->price * $item->quantity) }}đ</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-gray-700"><span class="font-semibold">Địa chỉ:</span> {{ $order->address }}</p>
                                    <p class="text-gray-700"><span class="font-semibold">Điện thoại:</span> {{ $order->phone }}</p>
                                </div>
                                <div>
                                    <p class="text-xl font-bold text-red-600">{{ number_format($order->total_amount) }}đ</p>
                                    <div class="mt-2">
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection 