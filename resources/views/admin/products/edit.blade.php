@extends('layouts.admin')

@section('title', 'Sửa Thông Tin Sách')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Sửa Thông Tin Sách</h3>
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại
                    </a>
                </div>
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tên sách *</label>
                        <input type="text" name="name" class="w-full px-3 py-2 border rounded @error('name') border-red-500 @enderror" 
                               value="{{ old('name', $product->name) }}">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Mô tả</label>
                        <textarea name="description" class="w-full px-3 py-2 border rounded" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Giá bán *</label>
                        <input type="number" name="price" class="w-full px-3 py-2 border rounded @error('price') border-red-500 @enderror"
                               value="{{ old('price', $product->price) }}">
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Ảnh sách hiện tại</label>
                        @if($product->image)
                            <img src="{{ asset('images/uploads/' . $product->image) }}" class="h-40 object-contain mb-2" alt="{{ $product->name }}">
                        @else 
                            <p class="text-gray-500 mb-2">Không có ảnh</p>
                        @endif
                        
                        <input type="file" name="image" class="w-full px-3 py-2 border rounded mt-2 @error('image') border-red-500 @enderror">
                        <small class="text-gray-500">Chỉ chọn ảnh nếu muốn thay đổi</small>
                        
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tác giả *</label>
                        <input type="text" name="author" class="w-full px-3 py-2 border rounded @error('author') border-red-500 @enderror"
                               value="{{ old('author', $product->author) }}">
                        @error('author')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nhà xuất bản</label>
                        <input type="text" name="publisher" class="w-full px-3 py-2 border rounded"
                               value="{{ old('publisher', $product->publisher ?? '') }}">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Thể loại</label>
                        <select name="category" class="w-full px-3 py-2 border rounded">
                            @php
                                $categories = array('Văn học', 'Kinh tế', 'Kỹ năng sống', 'Tâm lý', 'Thiếu nhi', 'Giáo khoa');
                            @endphp
                            
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ (old('category', $product->category) == $category) ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Số lượng trong kho</label>
                        <input type="number" name="stock" class="w-full px-3 py-2 border rounded" 
                               value="{{ old('stock', $product->stock) }}">
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Cập nhật sách
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 