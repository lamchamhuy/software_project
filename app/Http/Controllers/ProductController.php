<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check() && auth()->user()->isShipper()) {
            return redirect()->route('shipper.dashboard');
        }

        $query = Product::with(['category', 'variants']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(12);
        $categories = Category::all();
        $currentCategory = $request->filled('category')
            ? $categories->firstWhere('category_id', (int) $request->category)
            : null;

        return view('products.index', compact('products', 'categories', 'currentCategory'));
    }

    public function show(Product $product)
    {
        if (auth()->check() && auth()->user()->isShipper()) {
            return redirect()->route('shipper.dashboard');
        }

        $product->load(['category', 'variants']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('product_id', '!=', $product->product_id)
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
    public function category(Category $category)
    {
        if (auth()->check() && auth()->user()->isShipper()) {
            return redirect()->route('shipper.dashboard');
        }

        $products = Product::with(['category', 'variants'])
            ->where('category_id', $category->category_id)
            ->paginate(12);

        $categories = Category::all();
        $currentCategory = $category;

        return view('products.index', compact('products', 'categories', 'currentCategory'));
    }
}
