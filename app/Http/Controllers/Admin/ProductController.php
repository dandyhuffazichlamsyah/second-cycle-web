<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display all products with filtering and pagination
     */
    public function index(Request $request)
    {
        $query = Product::latest();

        // Search by name, brand, or type
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('type', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by brand
        if ($request->brand) {
            $query->where('brand', $request->brand);
        }

        // Sort products
        switch ($request->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(10);
        $locations = Location::all();
        
        return view('admin.products', compact('products', 'locations'));
    }

    /**
     * Store a new product
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'model' => 'nullable|string|max:100', // Made nullable as it might be redundant with name
            'year' => 'nullable|integer|min:2000|max:' . date('Y'), // Kept for backward compatibility if needed, or map to year_manufacture
            'cc' => 'nullable|integer|min:50|max:2000',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'location' => 'nullable|string|max:100',
            // New Fields Validation
            'year_manufacture' => 'nullable|integer|min:1900|max:'.(date('Y')+1),
            'year_assembly' => 'nullable|integer|min:1900|max:'.(date('Y')+1),
            'color' => 'nullable|string|max:50',
            'tax_expiry' => 'nullable|date',
            'odometer' => 'nullable|integer|min:0',
            // Booleans
            'routine_service' => 'nullable|boolean',
            'service_book' => 'nullable|boolean',
            'modifications_legal' => 'nullable|boolean',
            'accident_history' => 'nullable|boolean',
            'flood_history' => 'nullable|boolean',
            'frame_damage' => 'nullable|boolean',
            'repainted' => 'nullable|boolean',
            'engine_overhaul' => 'nullable|boolean',
            'spare_key' => 'nullable|boolean',
            'toolkit' => 'nullable|boolean',
            'manual_book' => 'nullable|boolean',
            'bonus_helmet' => 'nullable|boolean',
        ]);

        $productData = $request->except('image');
        // If 'year' is passed but 'year_manufacture' is not, use 'year'
        if ($request->filled('year') && !$request->filled('year_manufacture')) {
            $productData['year_manufacture'] = $request->year;
        }
        
        // Generate slug
        $productData['slug'] = Str::slug($request->name . '-' . ($request->year_manufacture ?? date('Y')) . '-' . Str::random(5));

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('products', $imageName, 'public');
            $productData['image'] = 'products/' . $imageName;
        }

        $product = new Product($productData);
        $product->grade = $product->calculateGrade();
        $product->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan!',
                'product' => $product
            ]);
        }

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show product details
     */
    public function show(Request $request, Product $product)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        }

        return view('admin.products.show', compact('product'));
    }

    /**
     * Update product
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'cc' => 'nullable|integer|min:50|max:2000',
            'price' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'location' => 'nullable|string|max:100',
            // New Fields Validation
            'year_manufacture' => 'nullable|integer|min:1900|max:'.(date('Y')+1),
            'year_assembly' => 'nullable|integer|min:1900|max:'.(date('Y')+1),
            'color' => 'nullable|string|max:50',
            'tax_expiry' => 'nullable|date',
            'odometer' => 'nullable|integer|min:0',
        ]);

        $productData = $request->except('image');
        // Update slug if name changed
        if ($request->name !== $product->name) {
            $productData['slug'] = Str::slug($request->name . '-' . ($request->year_manufacture ?? date('Y')) . '-' . Str::random(5));
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('products', $imageName, 'public');
            $productData['image'] = 'products/' . $imageName;
        }

        $product->fill($productData);
        $product->grade = $product->calculateGrade();
        $product->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui!',
                'product' => $product
            ]);
        }

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Delete product
     */
    public function destroy(Request $request, Product $product)
    {
        try {
            // Delete product image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.products')
                ->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus produk: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.products')
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Duplicate product
     */
    public function duplicate(Request $request, Product $product)
    {
        try {
            $newProduct = $product->replicate();
            $newProduct->name = $product->name . ' (Copy)';
            $newProduct->slug = Str::slug($newProduct->name . '-' . $newProduct->model . '-' . $newProduct->year);
            $newProduct->status = 'available';
            $newProduct->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil diduplikasi!',
                    'product' => $newProduct
                ]);
            }

            return redirect()->route('admin.products')
                ->with('success', 'Produk berhasil diduplikasi!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menduplikasi produk: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.products')
                ->with('error', 'Gagal menduplikasi produk: ' . $e->getMessage());
        }
    }

    /**
     * Get product statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total' => Product::count(),
            'available' => Product::where('status', 'available')->count(),
            'sold' => Product::where('status', 'sold')->count(),
            'maintenance' => Product::where('status', 'maintenance')->count(),
            'total_value' => Product::sum('price'),
            'recent' => Product::latest()->take(5)->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Export products to CSV
     */
    public function export(Request $request)
    {
        $products = Product::latest();

        // Apply filters
        if ($request->status) {
            $products->where('status', $request->status);
        }

        $products = $products->get();

        $filename = 'products_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'ID', 'Nama', 'Merek', 'Model', 'Tahun', 'CC', 'Harga', 
                'Stok', 'Status', 'Deskripsi', 'Ditambahkan'
            ]);

            // CSV Data
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->brand,
                    $product->model,
                    $product->year,
                    $product->cc,
                    $product->price,
                    $product->stock,
                    $product->status,
                    strip_tags($product->description),
                    $product->created_at->format('d M Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
