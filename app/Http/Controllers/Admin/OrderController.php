<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display all orders
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'product'])->latest();

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_phone', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment type
        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        $orders = $query->paginate(10);

        // Stats
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'approved' => Order::where('status', 'approved')->count(),
            'completed' => Order::where('status', 'completed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load(['user', 'product']);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'order' => $order,
            ]);
        }

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,processing,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $updateData = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ];

        if ($request->status === 'approved' && !$order->approved_at) {
            $updateData['approved_at'] = now();
        }

        if ($request->status === 'completed' && !$order->completed_at) {
            $updateData['completed_at'] = now();
        }

        $order->update($updateData);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui.',
            ]);
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Delete order
     */
    public function destroy(Order $order)
    {
        $order->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dihapus.',
            ]);
        }

        return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Export orders
     */
    public function export(Request $request)
    {
        $orders = Order::with(['user', 'product'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        $filename = 'orders_' . now()->format('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'No. Order', 'Tanggal', 'Pelanggan', 'Email', 'Telepon',
                'Produk', 'Harga', 'Tipe Pembayaran', 'DP', 'Cicilan/Bulan',
                'Status', 'Catatan Admin'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->customer_name,
                    $order->customer_email,
                    $order->customer_phone,
                    $order->product->name ?? 'N/A',
                    $order->product_price,
                    $order->payment_type_label,
                    $order->dp_amount ?? '-',
                    $order->monthly_payment ?? '-',
                    $order->status_label,
                    $order->admin_notes ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
