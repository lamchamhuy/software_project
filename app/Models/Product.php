<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'category_id',
        'image_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function getImageSrcAttribute()
    {
        $imagePath = trim((string) $this->image_url);

        if ($imagePath === '') {
            return asset('placeholder.svg');
        }

        if (preg_match('#^https?://#i', $imagePath) || str_starts_with($imagePath, '/')) {
            return $imagePath;
        }

        if (! Storage::disk('public')->exists($imagePath)) {
            return asset('placeholder.svg');
        }

        return asset('storage/' . ltrim($imagePath, '/'));
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Get the variants for the product.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id', 'product_id');
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }
}
