@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Quản lý sản phẩm</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        <i class="fas fa-plus mr-2"></i> Thêm sách mới
    </a>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <label for="search" class="sr-only">Tìm kiếm</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm sản phẩm..." 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        
        <div class="md:w-48">
            <label for="sort" class="sr-only">Sắp xếp</label>
            <select id="sort" name="sort" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
            </select>
        </div>
        
        <div>
            <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                <i class="fas fa-filter mr-2"></i> Lọc
            </button>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kho</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" 
                                     src="{{ asset('images/uploads/' . $product->image) }}" 
                                     alt="{{ $product->name }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($product->name, 30) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($product->price) }} đ</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($product->stock > 10)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $product->stock }}
                            </span>
                        @elseif($product->stock > 0)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ $product->stock }}
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Hết hàng
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                   onclick="return confirm('Bạn có chắc muốn xóa sách này?')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        Không có sản phẩm nào.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $products->withQueryString()->links() }}
</div>
@endsection

@push('scripts')
<script>
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush 