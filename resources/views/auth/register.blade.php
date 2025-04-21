@extends('layouts.auth')

@section('title', 'Đăng ký')

@section('content')
    <div class="container mx-auto">
        <div class="max-w-lg mx-auto">
            <div class="text-center">
                <a href="{{ route('index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-home mr-1"></i> Quay lại trang chủ
                </a>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b">
                    <h2 class="text-2xl font-bold text-center">Đăng ký tài khoản</h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('register') }}">
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

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-solid fa-envelope"></i> Email</label>
                            <input id="email" type="email" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-solid fa-key"></i> Mật khẩu</label>
                            <input id="password" type="password" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror" 
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2"><i class="fa-solid fa-key"></i> Xác nhận mật khẩu</label>
                            <input id="password-confirm" type="password" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                <i class="fa-solid fa-pen"></i> Đăng ký
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">Đã có tài khoản? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
@endsection 