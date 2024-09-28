<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // عرض نموذج التسجيل  
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'gender' => 'required|string|in:male,female', // إضافة حقل الجنس
        ]);

      

        // إنشاء المستخدم  
        $user = User::factory()->create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(60),
            'gender' => $request->gender, // إضافة الجنس إلى بيانات المستخدم
        ]);

        $user->profile()->create([
            'name' => $request->username,
            'email' => $request->email, 
        ]);

        // تجديد الجلسة  
        session()->regenerate();

        // تعيين المستخدم كمستخدم مسجل دخول  
        Auth::login($user);

        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    // تسجيل الدخول  
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // محاولة تسجيل الدخول  
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            // التحقق من حالة المستخدم  
            if ($user->status == 1) {
                return redirect()->route('index.admin'); // توجيه إلى لوحة التحكم  
            } elseif ($user->status == 0) {
                return redirect()->route('index.user'); // توجيه إلى واجهة المستخدم  
            }
        }

        return back()->withErrors(['email' => 'البريد الإلكتروني أو كلمة المرور خاطئة.']);
    }

    // تسجيل الخروج  
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}