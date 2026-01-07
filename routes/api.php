<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API for product quick view
Route::get('/products/{slug}', function ($slug) {
    $product = Product::where('slug', $slug)->first();
    
    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found'], 404);
    }
    
    return response()->json([
        'success' => true,
        'product' => $product
    ]);
});
