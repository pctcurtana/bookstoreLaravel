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
            height: 200px;
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
        
        .colored-toast {
            border-radius: 10px !important;
            color: #fff !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2) !important;
        }
        .colored-toast.swal2-icon-success {
            background-color: #4ade80 !important;
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
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center py-2">
            @yield('content')
        </main>
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
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInRight'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutRight'
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
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInRight'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutRight'
                    }
                });
            @endif
        });
    </script>
</body>
</html> 