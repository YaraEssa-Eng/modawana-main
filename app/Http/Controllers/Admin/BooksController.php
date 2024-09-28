<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Admin\Books;
use Exception;
use Illuminate\Http\Request;

class BooksController extends Controller
{

    public function index()
    {
        $books = Books::all();
        // return $books;
        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(BlogRequest $request)
    public function store(BookRequest $request)
    {

        try {

            Books::create([
                'title' => $request->title,
                'name' => $request->name,
                'amount' => $request->amount,
                'price' => $request->price,
                'image' => $request->image,
            ]);

            return back()->with('success', 'The Blog has inserted successfully');
        } catch (Exception $e) {

            return back()->withErrors(['error' => 'something happend']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Books::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id)
    {
        try {
            $book = Books::findOrFail($id);
            $book->update([
                'title' => $request->title,
                'name' => $request->name,
                'amount' => $request->amount,
                'price' => $request->price,
                'image' => $request->image,
            ]);

            return redirect()->route('books.index')->with('success', 'The Book has been updated successfully');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Something happened']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)  
    {  
        try {  
            $book = Books::findOrFail($id);  
            $book->delete();  
    
            return redirect()->route('books.index')->with('success', 'The Book has been deleted successfully');  
        } catch (Exception $e) {  
            return back()->withErrors(['error' => 'Something happened']);  
        }  
    }  
}
