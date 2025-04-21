@extends('layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold">Chi tiết đơn hàng #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
        <i class="fas fa-arrow-left mr-2"></i> Quay lại
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <!-- Thông tin đơn hàng -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold border-b pb-2 mb-4">Thông tin đơn hàng</h2>
        <div class="space-y-3">
            <p class="flex justify-between">
                <span class="font-medium">Mã đơn hàng:</span>
                <span>#{{ $order->id }}</span>
            </p>
            <p class="flex justify-between">
                <span class="font-medium">Ngày đặt:</span>
                <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </p>
            <p class="flex justify-between">
                <span class="font-medium">Trạng thái:</span>
                <span>
                    @if($order->status == 'Chờ xử lý')
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $order->status }}</span>
                    @elseif($order->status == 'Đang giao')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">{{ $order->status }}</span>
                    @elseif($order->status == 'Đã giao')
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $order->status }}</span>
                    @else
                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">{{ $order->status }}</span>
                    @endif
                </span>
            </p>
            <p class="flex justify-between">
                <span class="font-medium">Tổng tiền:</span>
                <span class="font-semibold text-red-600">{{ number_format($order->total_amount) }}đ</span>
            </p>
        </div>
    </div>

    <!-- Thông tin khách hàng -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold border-b pb-2 mb-4">Thông tin khách hàng</h2>
        <div class="space-y-3">
            <p class="flex justify-between">
                <span class="font-medium">Họ tên:</span>
                <span>{{ $order->user->username }}</span>
            </p>
            <p class="flex justify-between">
                <span class="font-medium">Email:</span>
                <span>{{ $order->user->email }}</span>
            </p>
            <p class="flex justify-between">
                <span class="font-medium">Địa chỉ giao hàng:</span>
                <span>{{ $order->address }}</span>
            </p>
            <p class="flex justify-between">
                <span class="font-medium">Số điện thoại:</span>
                <span>{{ $order->phone }}</span>
            </p>
        </div>
    </div>
</div>

<!-- Chi tiết sản phẩm -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <h2 class="text-lg font-semibold border-b pb-2 mb-4">Chi tiết sản phẩm</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đơn giá</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-14 w-10 object-cover" 
                                         src="{{ asset('images/uploads/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($item->price) }}đ</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ number_format($item->price * $item->quantity) }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Tổng cộng:</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-red-600">{{ number_format($order->total_amount) }}đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection 