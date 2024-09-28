<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function showUpdatePassword(Request $request)
    {
        return view('admin.update-password');
    }
    public function updatePassword(Request $request)
    {
        // Validate the new password
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
        ]);
        if (!Hash::check($request->old_password, request()->user()->password)) {
            return back()->withErrors(['old_password' => 'كلمة المرور المُدخلة غير صحيحة.']);
        }


        $user = request()->user();

        // Update the user's password
        $user->password = Hash::make($request->input('password'));
        $user->save();


        // logout
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Password updated successfully! Now login');
    }
}
