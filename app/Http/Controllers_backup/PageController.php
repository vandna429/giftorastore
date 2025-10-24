<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    private $products = [
        1 => [
            'id' => 1,
            'name' => 'Personalized Mug',
            'price' => 12.99,
            'short' => 'Ceramic mug with custom text',
            'image' => '/images/mug.jpg', // or mug.svg
            'description' => 'A high-quality ceramic mug. Add a message to make it personal.',
        ],
        2 => [
            'id' => 2,
            'name' => 'Rose Bouquet',
            'price' => 29.50,
            'short' => 'Fresh roses arranged beautifully',
            'image' => '/images/roses.jpg',
            'description' => 'A bouquet of fresh roses perfect for any occasion.',
        ],
        3 => [
            'id' => 3,
            'name' => 'Chocolate Box',
            'price' => 18.00,
            'short' => 'Assorted handmade chocolates',
            'image' => '/images/chocolates.jpg',
            'description' => 'Delicious assorted chocolates, handmade and packaged elegantly.',
        ],
    ];

    public function home()
    {
        $featured = array_slice($this->products, 0, 3);
        return view('home', ['featured' => $featured]);
    }

    public function products()
    {
        return view('products.index', ['products' => $this->products]);
    }

    public function productShow($id)
    {
        if (!isset($this->products[$id])) {
            abort(404);
        }
        return view('products.show', ['product' => $this->products[$id]]);
    }

    public function contact()
    {
        return view('contact');
    }


}
