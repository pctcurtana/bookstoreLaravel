@extends('layouts.auth')

@section('title', 'Đăng nhập')

@section('content')
    <div class="container mx-auto">
        <div class="max-w-md mx-auto">
            <div class="text-center">
                <a href="{{ route('index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-home mr-1"></i> Quay lại trang chủ
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-2xl font-bold text-center">Đăng nhập</h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-solid fa-user"></i> Tên đăng nhập</label>
                            <input id="username" type="text" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('username') border-red-500 @enderror" 
                                name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                            @error('username')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-solid fa-key"></i> Mật khẩu</label>
                            <input id="password" type="password" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" 
                                name="password" required autocomplete="current-password">
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" id="remember" class="mr-2">
                                <span class="text-sm text-gray-700">Ghi nhớ đăng nhập</span>
                            </label>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                <i class="fa-solid fa-earth-americas"></i> Đăng nhập
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600 mb-2">Chưa có tài khoản? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800">Đăng ký ngay</a></p>
                        <p class="text-sm text-gray-600"><a href="#" class="text-blue-600 hover:text-blue-800">Quên mật khẩu?</a></p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-6">
                <p class="text-gray-600 mb-4">Hoặc đăng nhập với</p>
                <div class="flex justify-center gap-4">
                    <button onclick="alert('Chức năng không có làm mà bấm cái gì.')" class="px-4 py-2 border rounded hover:bg-gray-50 bg-white">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i> Facebook
                    </button>
                    <button onclick="alert('Chức năng không có làm mà bấm cái gì.')" class="px-4 py-2 border rounded hover:bg-gray-50 bg-white">
                        <i class="fab fa-google text-red-600 mr-2"></i> Google
                    </button>
                </div>
            </div>
            
        </div>
    </div>
@endsection 