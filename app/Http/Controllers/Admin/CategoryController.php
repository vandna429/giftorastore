<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // List all categories
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Show form to create new category
    public function create()
    {
        return view('admin.categories.create');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Ensure uploads/categories directory exists
            $uploadPath = public_path('uploads/categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move($uploadPath, $imageName);
            $imagePath = 'uploads/categories/' . $imageName;
        }

        Category::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'image' => $imagePath,
        ]);

        $message = 'Category created successfully!';
        if ($imagePath) {
            $message .= ' Image saved: ' . $imagePath;
        }
        return redirect()->route('admin.categories.index')->with('success', $message);
    }

    // Show form to edit category
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $category->image; // keep existing image by default
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            // Ensure uploads/categories directory exists
            $uploadPath = public_path('uploads/categories');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $imageName = time() . '.' . $request->image->extension();
            $moved = $request->image->move($uploadPath, $imageName);
            
            if ($moved) {
                $imagePath = 'uploads/categories/' . $imageName;
            } else {
                return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
            }
        } else {
            // Only validate existing image path if no new file is being uploaded
            // Don't clear it - just keep what's there (might be valid but temporarily inaccessible)
            if ($imagePath && !str_contains($imagePath, '/')) {
                $imagePath = null; // Only clear if format is clearly wrong
            }
        }

        $category->update([
            'name' => $request->name,
            'slug' => \Str::slug($request->name),
            'image' => $imagePath,
        ]);

        $message = 'Category updated successfully!';
        if ($request->hasFile('image') && $imagePath) {
            $message .= ' Image saved: ' . $imagePath;
        }
        return redirect()->route('admin.categories.index')->with('success', $message);
    }

    // Delete category
    public function destroy(Category $category)
    {
        // Delete category image if exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}
