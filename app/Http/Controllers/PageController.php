<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;


class PageController extends Controller
{
public function home()
{
// If you want dynamic content, pass data here
return view('pages.home');
}
}