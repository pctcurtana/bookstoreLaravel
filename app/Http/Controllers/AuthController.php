<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Kiểm tra xem có phải là admin không
        $admin = Admin::where('username', $username)->first();
        if ($admin && md5($password) == $admin->password) {
            // Đăng nhập thành công cho admin
            Auth::guard('admin')->loginUsingId($admin->id, $remember);
            
            if ($remember) {
                $token = md5(uniqid(rand(), true));
                $admin->remember_token = $token;
                $admin->save();
                
                cookie()->queue('remember_user', $admin->id, 43200); // 30 ngày
                cookie()->queue('remember_token', $token, 43200);
            }
            
            return redirect()->route('admin.dashboard');
        }

        // Kiểm tra xem có phải là người dùng không
        $user = User::where('username', $username)->first();
        if ($user && md5($password) == $user->password) {
            // Kiểm tra tài khoản có bị khóa không
            if (!$user->is_active) {
                return redirect()->back()->with('error', 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.');
            }
            
            // Đăng nhập thành công cho người dùng
            Auth::loginUsingId($user->id, $remember);
            
            if ($remember) {
                $token = md5(uniqid(rand(), true));
                $user->remember_token = $token;
                $user->save();
                
                cookie()->queue('remember_user', $user->id, 43200); // 30 ngày
                cookie()->queue('remember_token', $token, 43200);
            }
            
            return redirect()->route('home');
        }

        // Đăng nhập thất bại
        return redirect()->back()->withErrors(['login' => 'Tên đăng nhập hoặc mật khẩu không chính xác']);
    }

    // Hiển thị form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => md5($request->password),
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        cookie()->queue(cookie()->forget('remember_user'));
        cookie()->queue(cookie()->forget('remember_token'));

        return redirect()->route('login');
    }
}
