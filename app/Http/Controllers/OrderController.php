<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show order form for a product
     */
    public function create(Product $product)
    {
        $user = Auth::user();
        return view('orders.create', compact('product', 'user'));
    }

    /**
     * Calculate credit simulation
     */
    public function calculateCredit(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'dp_amount' => 'required|numeric|min:0',
            'months' => 'required|integer|in:6,12,18,24,36',
        ]);

        $calculation = Order::calculateCredit(
            (int) $request->price,
            (int) $request->dp_amount,
            (int) $request->months
        );

        return response()->json([
            'success' => true,
            'data' => $calculation,
        ]);
    }

    /**
     * Store a new order
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'payment_type' => 'required|in:cash,dp,credit',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'customer_address' => 'required|string|max:1000',
            'dp_amount' => 'required_if:payment_type,dp,credit|nullable|numeric|min:0',
            'credit_months' => 'required_if:payment_type,credit|nullable|integer|in:6,12,18,24,36',
            'customer_ktp' => 'required_if:payment_type,credit|nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $orderData = [
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'payment_type' => $request->payment_type,
            'product_price' => $product->price,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
            'notes' => $request->notes,
            'status' => 'pending',
        ];

        // Handle different payment types
        if ($request->payment_type === 'dp') {
            $orderData['dp_amount'] = $request->dp_amount;
            $orderData['remaining_amount'] = $product->price - $request->dp_amount;
        } elseif ($request->payment_type === 'credit') {
            $orderData['dp_amount'] = $request->dp_amount;
            $orderData['customer_ktp'] = $request->customer_ktp;
            $orderData['credit_months'] = $request->credit_months;
            
            $calculation = Order::calculateCredit(
                $product->price,
                (int) $request->dp_amount,
                (int) $request->credit_months
            );
            
            $orderData['remaining_amount'] = $calculation['remaining'];
            $orderData['monthly_payment'] = $calculation['monthly_payment'];
        }

        $order = Order::create($orderData);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pengajuan pembelian berhasil dikirim! Kami akan segera menghubungi Anda.');
    }

    /**
     * Show order details
     */
    public function show(Request $request, Order $order)
    {
        // Ensure user can only see their own orders
        if ($order->user_id !== Auth::id() && !Auth::user()->canManageProducts()) {
            abort(403);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $order->status,
                'status_label' => $order->status_label,
                'status_color' => $order->status_color,
                'created_at' => $order->created_at->format('d M Y, H:i'),
                'approved_at' => $order->approved_at ? $order->approved_at->format('d M Y, H:i') : null,
                'completed_at' => $order->completed_at ? $order->completed_at->format('d M Y, H:i') : null,
                'admin_notes' => $order->admin_notes,
            ]);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * List user's orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Cancel an order (only if pending)
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pesanan dengan status pending yang dapat dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
