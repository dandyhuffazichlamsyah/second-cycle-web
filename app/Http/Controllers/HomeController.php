<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()
            ->take(6)
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get();
            
        $reviews = Review::with(['user', 'product'])
            ->where('rating', '>=', 4)
            ->latest()
            ->take(6)
            ->get();

        $ratingStats = [
            'average' => round(Review::avg('rating') ?? 0, 1),
            'count' => Review::count(),
            'satisfied_customers' => Review::where('rating', '>=', 4)->count()
        ];

        return view('home', compact('products', 'reviews', 'ratingStats'));
    }
}
