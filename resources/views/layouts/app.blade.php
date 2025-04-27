<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BookStore') - Nhà sách trực tuyến</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Custom CSS -->
    <style>
        .hero-section {
            min-height: 500px;
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .product-card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background-color: white;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-image-wrapper {
            height: 250px;
            overflow: hidden;
        }
        
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .card-title {
            height: 48px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        /* Navigation link styles */
        .nav-link {
            position: relative;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: #2563eb;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 70%;
        }
        
        .nav-link.active {
            color: #2563eb;
            background-color: rgba(219, 234, 254, 0.4);
        }
        
        .nav-link.active::after {
            width: 70%;
        }
        
        /* Dropdown menu styles */
        .dropdown-menu {
            visibility: hidden;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease-in-out;
            pointer-events: none;
        }
        
        .dropdown-container:hover .dropdown-menu, 
        .dropdown-menu:hover {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        
        .dropdown-arrow::after {
            content: '';
            position: absolute;
            top: -8px;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid white;
        }
        
        /* Toast notifications */
        .colored-toast {
            border-radius: 10px !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;
        }
        .colored-toast.swal2-icon-success {
            background-color: #93c5fd!important;
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
</head>
<body id="top" class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-30">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('index') }}" class="text-2xl font-bold text-blue-600 flex items-center">
                    <i class="fa-solid fa-book mr-2 text-blue-500"></i> 
                    <span class="bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text">BookStore</span>
                </a>
                
                <!-- Mobile menu button -->
                <button type="button" class="md:hidden text-gray-700 hover:text-blue-600" id="mobile-menu-button">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('index') }}" class="nav-link {{ request()->routeIs('index') || request()->routeIs('home') ? 'active' : '' }}">
                        <i class="fas fa-home mr-1"></i> Trang chủ
                    </a>
                    <a href="#product" class="nav-link">
                        <i class="fas fa-book mr-1"></i> Sản phẩm
                    </a>
                    <a href="#about" class="nav-link">
                        <i class="fas fa-info-circle mr-1"></i> Về chúng tôi
                    </a>
                    
                </div>
                
                <!-- Search Bar -->
                <div class="hidden md:block flex-grow max-w-md mx-4">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input 
                            type="text" 
                            name="query" 
                            placeholder="Tìm sách mà bạn cần" 
                            class="w-full px-4 py-2 pl-10 pr-8 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required
                        >
                        <button type="submit" class="absolute inset-y-0 left-0 pl-3 flex items-center">
                            <i class="fas fa-search text-gray-500"></i>
                        </button>
                    </form>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative p-2 hover:bg-blue-50 rounded-full transition-colors">
                            <i class="fas fa-shopping-cart text-gray-700 hover:text-blue-600"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                                {{ \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') }}
                            </span>
                        </a>
                        <div class="relative dropdown-container group">
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-full transition-colors">
                                <i class="fas fa-user"></i>
                                <span>{{ Auth::user()->username }}</span>
                                <i class="fas fa-chevron-down text-xs ml-1"></i>
                            </button>
                            <div class="absolute right-0 mt-3 w-56 bg-white rounded-lg shadow-lg py-2 z-10 dropdown-menu dropdown-arrow border border-gray-100">
                                <a href="{{ route('orders.index') }}" class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-shopping-bag mr-3 text-gray-500"></i> Đơn hàng của tôi
                                </a>
                                <div class="border-t my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full text-left px-5 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3 text-gray-500"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 hover:bg-gray-100 rounded-md transition-colors">
                            <i class="fas fa-user mr-1"></i> Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-sm transition-colors">
                            Đăng ký
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer id="about" class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">BookStore</h3>
                    <p class="mb-4">Nhà sách trực tuyến hàng đầu Việt Nam</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white hover:text-blue-400"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white hover:text-blue-400"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Danh mục</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Sách tiếng Việt</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Sách ngoại văn</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Sách thiếu nhi</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Sách học tập</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Hỗ trợ</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Hướng dẫn mua hàng</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Phương thức thanh toán</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Chính sách đổi trả</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên hệ</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                            <span>Nguyễn Văn Linh, An Khánh, Ninh Kiều, TP CT</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-2"></i>
                            <span>0857120004</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-2"></i>
                            <span>phamthat2206@gmail.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-gray-700 my-6">
            
            <p class="text-center text-gray-400">
                &copy; {{ date('Y') }} BookStore. Tất cả quyền được bảo lưu.
            </p>
        </div>
    </footer>

    <!-- Mobile Menu -->
    <div class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden" id="mobile-menu-overlay">
        <div class="bg-white h-full w-64 p-5 shadow-lg transform transition-transform duration-300 -translate-x-full" id="mobile-menu">
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('index') }}" class="text-xl font-bold text-blue-600 flex items-center">
                    <i class="fa-solid fa-book mr-2 text-blue-500"></i> 
                    <span class="bg-gradient-to-r from-blue-600 to-blue-400 text-transparent bg-clip-text">BookStore</span>
                </a>
                <button type="button" class="text-gray-700 hover:text-red-500 transition-colors" id="close-mobile-menu">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <nav class="mb-6">
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('index') }}" class="mobile-nav-link block text-gray-700 hover:text-blue-600 hover:bg-blue-50 py-3 px-4 rounded-lg transition-colors {{ request()->routeIs('index') || request()->routeIs('home') ? 'text-blue-600 bg-blue-50 font-medium' : '' }}">
                            <i class="fas fa-home mr-2"></i> Trang chủ
                        </a>
                    </li>
                    <li>
                        <a href="#product" class="mobile-nav-link block text-gray-700 hover:text-blue-600 hover:bg-blue-50 py-3 px-4 rounded-lg transition-colors">
                            <i class="fas fa-book mr-2"></i> Sản phẩm
                        </a>
                    </li>
                    <li>
                        <a href="#about" class="mobile-nav-link block text-gray-700 hover:text-blue-600 hover:bg-blue-50 py-3 px-4 rounded-lg transition-colors">
                            <i class="fas fa-info-circle mr-2"></i> Về chúng tôi
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- Mobile Search -->
            <div class="mb-6 px-4">
                <form action="{{ route('search') }}" method="GET" class="relative">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Tìm sách mà bạn cần" 
                        class="w-full px-4 py-3 pl-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                    >
                    <button type="submit" class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class="fas fa-search text-gray-500"></i>
                    </button>
                </form>
            </div>
            
            <div class="border-t pt-4">
                @auth
                    <a href="{{ route('cart.index') }}" class="flex items-center py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 rounded-lg transition-colors">
                        <i class="fas fa-shopping-cart mr-2"></i> Giỏ hàng
                        <span class="ml-auto bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">
                            {{ \App\Models\Cart::where('user_id', auth()->id())->sum('quantity') }}
                        </span>
                    </a>
                    <a href="{{ route('orders.index') }}" class="flex items-center py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 rounded-lg transition-colors">
                        <i class="fas fa-shopping-bag mr-2"></i> Đơn hàng của tôi
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="flex items-center py-3 w-full text-left text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 rounded-lg transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 px-4 rounded-lg transition-colors">
                        <i class="fas fa-user mr-2"></i> Đăng nhập
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center mt-2 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-colors">
                        <i class="fas fa-user-plus mr-2"></i> Đăng ký
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Display notifications -->
    <script>
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
    
    <script>
        // Mobile menu functionality
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenuButton = document.getElementById('close-mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenuOverlay.classList.remove('hidden');
            setTimeout(() => {
                mobileMenu.classList.remove('-translate-x-full');
            }, 10);
        });

        function closeMobileMenu() {
            mobileMenu.classList.add('-translate-x-full');
            setTimeout(() => {
                mobileMenuOverlay.classList.add('hidden');
            }, 300);
        }

        closeMobileMenuButton.addEventListener('click', closeMobileMenu);
        mobileMenuOverlay.addEventListener('click', (e) => {
            if (e.target === mobileMenuOverlay) {
                closeMobileMenu();
            }
        });
        
        // Xử lý hiệu ứng active cho các mục trong thanh điều hướng
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy tất cả các liên kết trong thanh điều hướng
            const navLinks = document.querySelectorAll('.nav-link');
            const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
            const allNavLinks = [...navLinks, ...mobileNavLinks];
            
            // Kiểm tra URL hiện tại và thêm class active cho mục tương ứng
            const currentPath = window.location.pathname;
            const hash = window.location.hash;
            
            // Nếu URL có chứa hash, kích hoạt mục tương ứng
            if (hash) {
                allNavLinks.forEach(l => {
                    l.classList.remove('active');
                    if (l.classList.contains('mobile-nav-link')) {
                        l.classList.remove('text-blue-600', 'bg-blue-50', 'font-medium');
                    }
                });
                
                const desktopActiveLink = document.querySelector(`.nav-link[href="${hash}"]`);
                const mobileActiveLink = document.querySelector(`.mobile-nav-link[href="${hash}"]`);
                
                if (desktopActiveLink) desktopActiveLink.classList.add('active');
                if (mobileActiveLink) {
                    mobileActiveLink.classList.add('text-blue-600', 'bg-blue-50', 'font-medium');
                }
                
                // Cuộn đến vị trí của element
                setTimeout(() => {
                    const targetElement = document.querySelector(hash);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                }, 100);
            } else if (currentPath === '/' || currentPath.includes('/index')) {
                // Active trang chủ
                navLinks[0].classList.add('active');
                const mobileHomeLink = document.querySelector('.mobile-nav-link[href="#top"]');
                if (mobileHomeLink) {
                    mobileHomeLink.classList.add('text-blue-600', 'bg-blue-50', 'font-medium');
                }
            }
            
            // Xử lý sự kiện click cho các liên kết anchor desktop
            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    const href = this.getAttribute('href');
                    
                    // Nếu là liên kết anchor, xử lý đặc biệt
                    if (href.startsWith('#')) {
                        event.preventDefault(); // Ngăn chặn hành vi mặc định
                        
                        // Xóa active từ tất cả các liên kết
                        allNavLinks.forEach(l => {
                            l.classList.remove('active');
                            if (l.classList.contains('mobile-nav-link')) {
                                l.classList.remove('text-blue-600', 'bg-blue-50', 'font-medium');
                            }
                        });
                        
                        // Thêm active vào liên kết hiện tại
                        this.classList.add('active');
                        
                        // Thêm active vào liên kết mobile tương ứng
                        const mobileLink = document.querySelector(`.mobile-nav-link[href="${href}"]`);
                        if (mobileLink) {
                            mobileLink.classList.add('text-blue-600', 'bg-blue-50', 'font-medium');
                        }
                        
                        // Tìm element đích
                        const targetElement = document.querySelector(href);
                        if (targetElement) {
                            // Cuộn đến vị trí của element
                            window.scrollTo({
                                top: targetElement.offsetTop - 80,
                                behavior: 'smooth'
                            });
                            
                            // Cập nhật URL nhưng không reload trang
                            history.pushState(null, null, href);
                        }
                    }
                });
            });
            
            // Xử lý sự kiện click cho các liên kết anchor mobile
            mobileNavLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    const href = this.getAttribute('href');
                    
                    // Nếu là liên kết anchor, xử lý đặc biệt
                    if (href.startsWith('#')) {
                        event.preventDefault(); // Ngăn chặn hành vi mặc định
                        
                        // Xóa active từ tất cả các liên kết
                        allNavLinks.forEach(l => {
                            l.classList.remove('active');
                            if (l.classList.contains('mobile-nav-link')) {
                                l.classList.remove('text-blue-600', 'bg-blue-50', 'font-medium');
                            }
                        });
                        
                        // Thêm active vào liên kết hiện tại
                        this.classList.add('text-blue-600', 'bg-blue-50', 'font-medium');
                        
                        // Thêm active vào liên kết desktop tương ứng
                        const desktopLink = document.querySelector(`.nav-link[href="${href}"]`);
                        if (desktopLink) {
                            desktopLink.classList.add('active');
                        }
                        
                        // Đóng menu mobile
                        closeMobileMenu();
                        
                        // Tìm element đích
                        const targetElement = document.querySelector(href);
                        if (targetElement) {
                            // Delay để menu đóng trước khi cuộn
                            setTimeout(() => {
                                // Cuộn đến vị trí của element
                                window.scrollTo({
                                    top: targetElement.offsetTop - 80,
                                    behavior: 'smooth'
                                });
                                
                                // Cập nhật URL nhưng không reload trang
                                history.pushState(null, null, href);
                            }, 300);
                        }
                    }
                });
            });
            
            // Xử lý sự kiện cuộn để thêm hiệu ứng active khi đến section tương ứng
            window.addEventListener('scroll', function() {
                const scrollPosition = window.scrollY;
                
                // Lấy vị trí của các section
                const productSection = document.querySelector('#product');
                const aboutSection = document.querySelector('#about');
                
                // Thêm một khoảng đệm để tính toán vị trí tốt hơn
                const offset = 150;
                
                if (aboutSection && scrollPosition + window.innerHeight >= aboutSection.offsetTop) {
                    // Nếu đã cuộn đến gần cuối trang (khu vực about)
                    allNavLinks.forEach(l => {
                        l.classList.remove('active');
                        if (l.classList.contains('mobile-nav-link')) {
                            l.classList.remove('text-blue-600', 'bg-blue-50', 'font-medium');
                        }
                    });
                    
                    const aboutDesktopLink = document.querySelector('a.nav-link[href="#about"]');
                    const aboutMobileLink = document.querySelector('a.mobile-nav-link[href="#about"]');
                    
                    if (aboutDesktopLink) aboutDesktopLink.classList.add('active');
                    if (aboutMobileLink) aboutMobileLink.classList.add('text-blue-600', 'bg-blue-50', 'font-medium');
                    
                } else if (productSection && scrollPosition >= productSection.offsetTop - offset) {
                    // Nếu đã cuộn đến khu vực product
                    allNavLinks.forEach(l => {
                        l.classList.remove('active');
                        if (l.classList.contains('mobile-nav-link')) {
                            l.classList.remove('text-blue-600', 'bg-blue-50', 'font-medium');
                        }
                    });
                    
                    const productDesktopLink = document.querySelector('a.nav-link[href="#product"]');
                    const productMobileLink = document.querySelector('a.mobile-nav-link[href="#product"]');
                    
                    if (productDesktopLink) productDesktopLink.classList.add('active');
                    if (productMobileLink) productMobileLink.classList.add('text-blue-600', 'bg-blue-50', 'font-medium');
                    
                } else {
                    // Mặc định ở khu vực trang chủ
                    allNavLinks.forEach(l => {
                        l.classList.remove('active');
                        if (l.classList.contains('mobile-nav-link')) {
                            l.classList.remove('text-blue-600', 'bg-blue-50', 'font-medium');
                        }
                    });
                    
                    const homeDesktopLink = document.querySelector('a.nav-link[href="#top"]');
                    const homeMobileLink = document.querySelector('a.mobile-nav-link[href="#top"]');
                    
                    if (homeDesktopLink) homeDesktopLink.classList.add('active');
                    if (homeMobileLink) homeMobileLink.classList.add('text-blue-600', 'bg-blue-50', 'font-medium');
                }
            });
        });

        // Xử lý dropdown menu
        const userDropdownButton = document.querySelector('.dropdown-container button');
        const userDropdownMenu = document.querySelector('.dropdown-menu');
        
        if (userDropdownButton && userDropdownMenu) {
            // Biến để kiểm soát trạng thái dropdown
            let isDropdownOpen = false;
            let dropdownTimeout;
            
            // Xử lý sự kiện click trên button dropdown
            userDropdownButton.addEventListener('click', function(e) {
                e.stopPropagation();
                isDropdownOpen = !isDropdownOpen;
                
                if (isDropdownOpen) {
                    userDropdownMenu.style.visibility = 'visible';
                    userDropdownMenu.style.opacity = '1';
                    userDropdownMenu.style.transform = 'translateY(0)';
                    userDropdownMenu.style.pointerEvents = 'auto';
                } else {
                    userDropdownMenu.style.visibility = 'hidden';
                    userDropdownMenu.style.opacity = '0';
                    userDropdownMenu.style.transform = 'translateY(10px)';
                    userDropdownMenu.style.pointerEvents = 'none';
                }
            });
            
            // Xử lý sự kiện click bên ngoài để đóng dropdown
            document.addEventListener('click', function(e) {
                const isClickInside = userDropdownButton.contains(e.target) || userDropdownMenu.contains(e.target);
                
                if (!isClickInside && isDropdownOpen) {
                    isDropdownOpen = false;
                    userDropdownMenu.style.visibility = 'hidden';
                    userDropdownMenu.style.opacity = '0';
                    userDropdownMenu.style.transform = 'translateY(10px)';
                    userDropdownMenu.style.pointerEvents = 'none';
                }
            });
            
            // Xử lý hover vào dropdown container
            document.querySelector('.dropdown-container').addEventListener('mouseenter', function() {
                clearTimeout(dropdownTimeout);
                userDropdownMenu.style.visibility = 'visible';
                userDropdownMenu.style.opacity = '1';
                userDropdownMenu.style.transform = 'translateY(0)';
                userDropdownMenu.style.pointerEvents = 'auto';
                isDropdownOpen = true;
            });
            
            // Xử lý rời chuột khỏi dropdown container
            document.querySelector('.dropdown-container').addEventListener('mouseleave', function() {
                dropdownTimeout = setTimeout(() => {
                    // Không đóng dropdown nếu vừa click vào nó
                    if (!isDropdownOpen) {
                        userDropdownMenu.style.visibility = 'hidden';
                        userDropdownMenu.style.opacity = '0';
                        userDropdownMenu.style.transform = 'translateY(10px)';
                        userDropdownMenu.style.pointerEvents = 'none';
                    }
                }, 300); // Thêm độ trễ 300ms trước khi đóng
            });
        }
    </script>
</body>
</html> 