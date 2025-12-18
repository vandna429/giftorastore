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
}