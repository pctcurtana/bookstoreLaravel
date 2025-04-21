<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách người dùng
     */
    public function index()
    {
        $users = User::where('is_admin', 0)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Khóa người dùng
     */
    public function block($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Chỉ cho phép khóa người dùng không phải admin
            if ($user->is_admin) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Không thể khóa tài khoản admin');
            }
            
            // Sử dụng cập nhật trực tiếp qua DB
            $affected = DB::table('users')
                        ->where('id', $id)
                        ->update(['is_active' => 0]);
            
            if ($affected) {
                return redirect()->route('admin.users.index')
                        ->with('success', 'Đã khóa người dùng thành công');
            } else {
                return redirect()->route('admin.users.index')
                        ->with('error', 'Không thể cập nhật trạng thái người dùng');
            }
                    
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    
    /**
     * Mở khóa người dùng
     */
    public function unblock($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Chỉ cho phép mở khóa người dùng không phải admin
            if ($user->is_admin) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Không cần mở khóa tài khoản admin');
            }
            
            // Sử dụng cập nhật trực tiếp qua DB
            $affected = DB::table('users')
                        ->where('id', $id)
                        ->update(['is_active' => 1]);
            
            if ($affected) {
                return redirect()->route('admin.users.index')
                        ->with('success', 'Đã mở khóa người dùng thành công');
            } else {
                return redirect()->route('admin.users.index')
                        ->with('error', 'Không thể cập nhật trạng thái người dùng');
            }
                    
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 