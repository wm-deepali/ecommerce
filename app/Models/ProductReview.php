<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'customer_id',
        'order_id',
        'order_item_id',
        'rating',
        'title',
        'review',
        'verified_purchase',
        'featured',
        'status',
    ];

    protected $casts = [
        'verified_purchase' => 'boolean',
        'featured'          => 'boolean',
        'rating'            => 'integer',
    ];

    /* ── Relationships ────────────────────────────────────── */

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductReviewImage::class);
    }

    /* ── Scopes ───────────────────────────────────────────── */

    public function scopeApproved($q)  { return $q->where('status', 'approved'); }
    public function scopePending($q)   { return $q->where('status', 'pending'); }
    public function scopeRejected($q)  { return $q->where('status', 'rejected'); }
    public function scopeFeatured($q)  { return $q->where('featured', true); }

    /* ── Accessors ────────────────────────────────────────── */

    /** CSS pill class for Blade: pill-approved / pill-pending / pill-rejected */
    public function getPillClassAttribute(): string
    {
        return 'pill-' . $this->status;
    }

    /** Label capitalised */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}