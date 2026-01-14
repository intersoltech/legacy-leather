<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        try {
            $categories = Category::orderBy('order')->orderBy('name')->paginate(15);
            return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Category index error: ' . $e->getMessage());
            return view('admin.categories.index', ['categories' => collect()])
                ->with('error', 'An error occurred while loading categories.');
        }
    }

    public function create(): \Illuminate\View\View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $i = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        try {
            Category::create([
                'name' => $data['name'],
                'slug' => $slug,
                'display_name' => $data['display_name'] ?? $data['name'],
                'order' => $data['order'] ?? 0,
                'is_active' => $data['is_active'] ?? true,
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            Log::error('Category store error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create category. Please try again.');
        }
    }

    public function edit(Category $category): \Illuminate\View\View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($category->name !== $data['name']) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $i = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }
            $category->slug = $slug;
        }

        try {
            $category->name = $data['name'];
            $category->display_name = $data['display_name'] ?? $data['name'];
            $category->order = $data['order'] ?? 0;
            $category->is_active = $data['is_active'] ?? true;
            $category->save();

            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            Log::error('Category update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update category. Please try again.');
        }
    }

    public function destroy(Category $category): \Illuminate\Http\RedirectResponse
    {
        try {
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            Log::error('Category delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete category. Please try again.');
        }
    }
}

