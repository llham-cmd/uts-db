<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function index(Request $request)
  {
    $search = $request->get('search');

    $categories = Category::when($search, function ($query) use ($search) {
      $query->where('name', 'LIKE', '%' . $search . '%');
    })
      ->latest()
      ->paginate(10)
      ->withQueryString();

    return view('admin.categories.index', compact('categories', 'search'));
  }

  public function store(Request $request)
  {
    $request->validate(['name' => 'required|string|max:255|unique:categories,name']);
    Category::create([
      'name' => $request->name,
      'slug' => Str::slug($request->name),
    ]);
    return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
  }

  public function update(Request $request, Category $category)
  {
    $request->validate(['name' => 'required|string|max:255|unique:categories,name,' . $category->id]);
    $category->update(['name' => $request->name, 'slug' => Str::slug($request->name)]);
    return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
  }

  public function destroy(Category $category)
  {
    $category->delete();
    return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
  }
}
