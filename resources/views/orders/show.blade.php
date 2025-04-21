@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Chi tiết đơn hàng #{{ $order->id }}</h1>
            <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
                <div>
                    <span class="text-gray-600">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</span>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Thông tin vận chuyển</h2>
                        <p class="text-gray-700">Địa chỉ: {{ $order->address }}</p>
                        <p class="text-gray-700">Số điện thoại: {{ $order->phone }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Thông tin đơn hàng</h2>
                        <p class="text-gray-700">Trạng thái: 
                            @if($order->status == 'Chờ xử lý')
                                <span class="text-blue-600">{{ $order->status }}</span>
                            @elseif($order->status == 'Đang giao')
                                <span class="text-yellow-600">{{ $order->status }}</span>
                            @elseif($order->status == 'Đã giao')
                                <span class="text-green-600">{{ $order->status }}</span>
                            @elseif($order->status == 'Đã hủy')
                                <span class="text-red-600">{{ $order->status }}</span>
                            @else
                                <span>{{ $order->status }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <h2 class="text-lg font-semibold mb-4">Chi tiết sản phẩm</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 object-cover" src="{{ asset('images/uploads/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($item->price) }}đ</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($item->price * $item->quantity) }}đ</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 text-right">
                    <div class="text-gray-700 mb-2">Tạm tính: {{ number_format($order->total_amount) }}đ</div>
                    <div class="text-gray-700 mb-2">Phí vận chuyển: Miễn phí</div>
                    <div class="text-xl font-bold text-red-600">Tổng cộng: {{ number_format($order->total_amount) }}đ</div>
                </div>
            </div>
        </div>
    </div>
@endsection 