@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Giỏ hàng của bạn</h1>
        
        @if($cartItems->isEmpty())
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <p class="text-gray-700 text-lg text-center py-8">Giỏ hàng của bạn đang trống</p>
                <div class="text-center">
                    <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sản phẩm
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Đơn giá
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Số lượng
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thành tiền
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thao tác
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 object-cover" 
                                                src="{{ asset('images/uploads/' . $item->product->image) }}" 
                                                alt="{{ $item->product->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->product->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ number_format($item->product->price) }}đ</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                            class="w-16 border border-gray-300 rounded px-2 py-1">
                                        <button type="submit" class="ml-2 text-xs bg-gray-200 hover:bg-gray-300 py-1 px-2 rounded">
                                            Cập nhật
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ number_format($item->product->price * $item->quantity) }}đ
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-700">Tổng số sản phẩm: <span class="font-semibold">{{ $cartItems->sum('quantity') }}</span></p>
                        <p class="text-gray-700 text-xl mt-2">Tổng tiền: <span class="font-bold text-red-600">{{ number_format($total) }}đ</span></p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('home') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                            Tiếp tục mua sắm
                        </a>
                        <a href="{{ route('orders.checkout') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Thanh toán
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection 