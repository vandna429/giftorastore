<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;


class PageController extends Controller
{
    public function home()
    {
        // Pass categories to the view so they can be displayed dynamically
        $categories = Category::all();
        return view('pages.home', compact('categories'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // For now, just redirect back with success message
        // You can add email sending functionality later
        return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}