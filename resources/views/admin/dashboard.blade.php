@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 mb-8">
        <div class="bg-white rounded-lg shadow p-3">
            <div class="flex items-center">
                <div class="p-1 rounded bg-blue-500 bg-opacity-10 text-blue-500">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Người dùng</p>
                    <h3 class="text-2xl font-bold">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3">
            <div class="flex items-center">
                <div class="px-2 py-1 rounded bg-green-500 bg-opacity-10 text-green-500">
                    <i class="fas fa-shopping-bag text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Sản phẩm</p>
                    <h3 class="text-2xl font-bold">{{ $totalProducts }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3">
            <div class="flex items-center">
                <div class="p-1 rounded bg-purple-500 bg-opacity-10 text-purple-500">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Đơn hàng</p>
                    <h3 class="text-2xl font-bold">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3">
            <div class="flex items-center">
                <div class="p-1 rounded bg-red-500 bg-opacity-10 text-red-500">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Doanh thu</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalRevenue) }}đ</h3>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">Đơn hàng gần đây</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mã đơn
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Khách hàng
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ngày đặt
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tổng tiền
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->created_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($order->total_amount) }}đ</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->status == 'Chờ xử lý')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $order->status }}
                                    </span>
                                @elseif($order->status == 'Đang giao')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $order->status }}
                                    </span>
                                @elseif($order->status == 'Đã giao')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $order->status }}
                                    </span>
                                @elseif($order->status == 'Đã hủy')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        {{ $order->status }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $order->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Top Products -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">Sản phẩm bán chạy</h2>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($topProducts as $product)
                <div class="bg-gray-50 rounded p-4 flex flex-col items-center">
                    <img src="{{ asset('images/uploads/' . $product['image']) }}" 
                         alt="{{ $product['name'] }}" 
                         class="w-20 h-20 object-cover rounded mb-2">
                    <h3 class="text-sm font-medium text-center">{{ $product['name'] }}</h3>
                    <span class="text-xs text-gray-500 mt-1">Đã bán: {{ $product['total_sold'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection 