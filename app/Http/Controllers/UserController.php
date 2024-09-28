<?php

namespace App\Http\Controllers;

use App\Models\Admin\Books;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $books = Books::all(); // جلب جميع الكتب  
        return view('site.layouts.index', compact('books')); // تمرير الكتب إلى العرض  
    }


}
