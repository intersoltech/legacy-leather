<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create(): \Illuminate\View\View
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();

        // slug auto generate
        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $i = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                // save in storage/app/public/uploads/products
                $imagePath = $request->file('image')->store('uploads/products', 'public');
            }

            Product::create([
                'name'        => $data['name'],
                'slug'        => $slug,
                'price'       => $data['price'],
                'description' => $data['description'] ?? null,
                'image'       => $imagePath,
                'category'    => $data['category'] ?? null,
                'is_active'   => $data['is_active'] ?? true,
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            Log::error('Product store error: ' . $e->getMessage());
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            return back()->withInput()->with('error', 'Failed to create product. Please try again.');
        }
    }

    public function edit(Product $product): \Illuminate\View\View
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();

        // If name changed -> update slug safely
        if ($product->name !== $data['name']) {
            $baseSlug = Str::slug($data['name']);
            $slug = $baseSlug;
            $i = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $baseSlug . '-' . $i++;
            }
            $product->slug = $slug;
        }

        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'] ?? null;
        $product->category = $data['category'] ?? $product->category;
        $product->is_active = $data['is_active'] ?? $product->is_active;

        try {
            // remove image
            if ($request->boolean('remove_image') && $product->image) {
                Storage::disk('public')->delete($product->image);
                $product->image = null;
            }

            // upload new image
            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->image = $request->file('image')->store('uploads/products', 'public');
            }

            $product->name = $data['name'];
            $product->price = $data['price'];
            $product->description = $data['description'] ?? null;
            $product->category = $data['category'] ?? $product->category;
            $product->is_active = $data['is_active'] ?? $product->is_active;
            $product->save();

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            Log::error('Product update error: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update product. Please try again.');
        }
    }

    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            Log::error('Product delete error: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete product. Please try again.');
        }
    }
}
