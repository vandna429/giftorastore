<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;


class ProductController extends Controller
{
private function productData()
{
return [
[
'slug' => 'luxury-chocolate-box',
'name' => 'Luxury Chocolate Box',
'price' => 2500,
'short' => 'Assorted premium chocolates in an elegant box.',
'image' => 'luxury-chocolate-box.jpg',
'description' => 'A curated selection of handcrafted chocolates, perfect for birthdays, anniversaries, or saying thank you.'
],
[
'slug' => 'flower-bouquet-roses',
'name' => 'Rose Bouquet',
'price' => 3200,
'short' => 'Fresh red roses arranged beautifully.',
'image' => 'rose-bouquet.jpg',
'description' => 'A classic bouquet of fresh red roses — timeless and romantic.'
],
[
'slug' => 'personalized-mug',
'name' => 'Personalized Mug',
'price' => 900,
'short' => 'Custom text or photo printed on a ceramic mug.',
'image' => 'personalized-mug.jpg',
'description' => 'Upload your message or photo and make this mug uniquely theirs.'
],

[
    'id' => 6,
    'slug' => 'scented-candle',
    'name' => 'Scented Candle',
    'price' => 1200,
    'short' => 'Relaxing aromatic candle for cozy evenings.',
    'image' => 'scented-candle.jpg',
    'description' => 'Light up your space with our hand-poured scented candle. Made from natural soy wax, it fills your room with a soothing fragrance and warmth.'
],

// Add more products as needed
];
}public function index(Request $request)
{
$products = $this->productData();


// Simple search/filter support
if ($request->has('query') && !empty($request->query('query'))) {
$q = strtolower($request->query('query'));
$products = array_filter($products, function($p) use ($q) {
return str_contains(strtolower($p['name']), $q)
|| str_contains(strtolower($p['short']), $q)
|| str_contains(strtolower($p['description']), $q);
});
}


return view('pages.products', ['products' => $products]);
}


public function show($slug)
{
$product = collect($this->productData())->firstWhere('slug', $slug);
if (!$product) abort(404);
return view('pages.product_details', compact('product'));
}
}