@extends('layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Quản lý đơn hàng</h1>
</div>

<!-- Alert Message -->
<div id="alertMessage" class="mb-4"></div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                        {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th> --}}
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đặt</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->username }}</td>
                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->email }}</td> --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($order->total_amount) }}đ</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <select class="form-select form-select-sm status-select border rounded px-2 py-1 text-sm" 
                                        data-order-id="{{ $order->id }}">
                                    <option value="Chờ xử lý" {{ $order->status == 'Chờ xử lý' ? 'selected' : '' }}>
                                        Chờ xử lý
                                    </option>
                                    <option value="Đang giao" {{ $order->status == 'Đang giao' ? 'selected' : '' }}>
                                        Đang giao
                                    </option>
                                    <option value="Đã giao" {{ $order->status == 'Đã giao' ? 'selected' : '' }}>
                                        Đã giao
                                    </option>
                                    <option value="Đã hủy" {{ $order->status == 'Đã hủy' ? 'selected' : '' }}>
                                        Đã hủy
                                    </option>
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i> Xem
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Không có đơn hàng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $orders->links() }}
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Xử lý cập nhật trạng thái đơn hàng
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const status = this.value;
            
            fetch('{{ route('admin.orders.update-status') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    order_id: orderId,
                    status: status
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Thành công!',
                        text: data.message,
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
                } else {
                    Swal.fire({
                        title: 'Lỗi!',
                        text: data.message || 'Có lỗi xảy ra',
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
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Có lỗi xảy ra khi cập nhật trạng thái',
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
            });
        });
    });
});
</script>
@endpush 