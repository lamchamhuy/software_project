<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'shipper_id',
        'order_number',
        'order_date',
        'total_amount',
        'notes',
        'shipped_at',
        'delivered_at',
        'status',
        'payment_method',
        'payment_status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_district',
        'shipping_ward',
        'subtotal',
        'shipping_fee',
        'tax_amount',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipper()
    {
        return $this->belongsTo(User::class, 'shipper_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'completed' => 'Hoàn thành',
            'delivery_failed' => 'Giao không thành công',
            'cancelled' => 'Đã hủy',
        ];

        return $labels[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Chờ thanh toán',
            'confirmed' => 'Đã xác nhận',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'refunded' => 'Đã hoàn tiền',
        ];

        return $labels[$this->payment_status] ?? ucfirst((string) $this->payment_status);
    }

    public function getPaymentMethodLabelAttribute()
    {
        $labels = [
            'cod' => 'Thanh toán khi nhận hàng',
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'momo' => 'Ví MoMo',
            'qr_payment' => 'Thanh toan bang ma QR',
            'vnpay' => 'VNPay',
            'stripe' => 'Stripe',
        ];

        return $labels[$this->payment_method] ?? ucfirst((string) $this->payment_method);
    }
}
