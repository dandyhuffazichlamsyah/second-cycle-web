<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'product_id',
        'payment_type',
        'product_price',
        'dp_amount',
        'remaining_amount',
        'credit_months',
        'monthly_payment',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'customer_ktp',
        'status',
        'notes',
        'admin_notes',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'SC';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        return "{$prefix}{$date}{$random}";
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Status helpers
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'processing' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'rejected' => 'danger',
            'processing' => 'primary',
            'completed' => 'success',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    public function getPaymentTypeLabelAttribute(): string
    {
        return match($this->payment_type) {
            'cash' => 'Tunai (Cash)',
            'dp' => 'DP (Down Payment)',
            'credit' => 'Kredit',
            default => ucfirst($this->payment_type),
        };
    }

    /**
     * Calculate credit details
     */
    public static function calculateCredit(int $price, int $dpAmount, int $months): array
    {
        $remaining = $price - $dpAmount;
        $interest = 0.05; // 5% flat interest per year
        $totalInterest = $remaining * $interest * ($months / 12);
        $totalWithInterest = $remaining + $totalInterest;
        $monthlyPayment = ceil($totalWithInterest / $months);

        return [
            'remaining' => $remaining,
            'total_interest' => $totalInterest,
            'total_with_interest' => $totalWithInterest,
            'monthly_payment' => $monthlyPayment,
        ];
    }
}
