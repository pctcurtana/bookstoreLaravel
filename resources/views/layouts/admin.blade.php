<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin Book Store</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        /* Toast notifications */
        .colored-toast {
            border-radius: 10px !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;
        }
        .colored-toast.swal2-icon-success {
            background-color: #93c5fd !important;
        }
        .colored-toast.swal2-icon-error {
            background-color: #f87171 !important;
        }
        .toast-title {
            color: white !important;
            font-weight: 600 !important;
            margin-bottom: 5px !important;
        }
        .toast-text {
            color: white !important;
        }
        .swal2-icon {
            scale: 0.7;
            margin: 0 0.5rem 0 0 !important;
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-48 flex-shrink-0 hidden md:block">
            <div class="p-4 font-bold text-xl flex items-center">
                <i class="fas fa-book-reader mr-2"></i> Book Store
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-4 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }} text-white">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center p-4 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} text-white">
                    <i class="fas fa-shopping-bag mr-3"></i> Sản phẩm
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center p-4 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} text-white">
                    <i class="fas fa-shopping-cart mr-3"></i> Đơn hàng
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} text-white">
                    <i class="fas fa-users mr-3"></i> Người dùng
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="flex items-center p-4 hover:bg-gray-700 text-white w-full text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i> Đăng xuất
                    </button>
                </form>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white shadow-sm p-4 flex justify-between items-center">
                <button class="md:hidden text-gray-500 focus:outline-none" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="relative">
                    <span class="text-gray-700">Xin chào, {{ Auth::guard('admin')->user()->username }}</span>
                </div>
            </header>
            
            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-4">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Sidebar -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden" id="mobile-sidebar-overlay">
        <div class="bg-gray-800 text-white w-64 h-full" id="mobile-sidebar">
            <div class="p-4 font-bold text-xl flex items-center justify-between">
                <div>
                    <i class="fas fa-book-reader mr-2"></i> Book Store
                </div>
                <button class="text-white focus:outline-none" id="close-sidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-4 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }} text-white">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center p-4 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} text-white">
                    <i class="fas fa-shopping-bag mr-3"></i> Sản phẩm
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center p-4 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} text-white">
                    <i class="fas fa-shopping-cart mr-3"></i> Đơn hàng
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }} text-white">
                    <i class="fas fa-users mr-3"></i> Người dùng
                </a>
                <a href="#" class="flex items-center p-4 hover:bg-gray-700 text-white">
                    <i class="fas fa-cog mr-3"></i> Cài đặt
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="flex items-center p-4 hover:bg-gray-700 text-white w-full text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i> Đăng xuất
                    </button>
                </form>
            </nav>
        </div>
    </div>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Mobile menu toggle
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('mobile-sidebar-overlay').classList.remove('hidden');
        });
        
        document.getElementById('close-sidebar').addEventListener('click', function() {
            document.getElementById('mobile-sidebar-overlay').classList.add('hidden');
        });
        
        document.getElementById('mobile-sidebar-overlay').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
        
        // Display notifications
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast',
                        title: 'toast-title',
                        htmlContainer: 'toast-text'
                    }
                });
            @endif
            
            @if(session('error'))
                Swal.fire({
                    title: 'Lỗi!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast',
                        title: 'toast-title',
                        htmlContainer: 'toast-text'
                    }
                });
            @endif
        });
    </script>
    
    @stack('scripts')
</body>
</html> 