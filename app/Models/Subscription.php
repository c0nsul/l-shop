<?php

namespace App\Models;

use App\Mail\SendSubscriptionMessage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable= ['email', 'product_id'];
    private const isFalse = 0;
    private const isTrue = 1;

    /**
     * @param $query
     * @param $productId
     * @return mixed
     */
    public function scopeActiveByProductId($query, $productId){
        return $query->where('status', self::isFalse)->where('product_id', $productId);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @param Product $product
     */
    public static function sendEmailsBySubscription(Product $product)
    {
        $subscriptions = self::activeByProductId($product->id)->get();

        foreach($subscriptions as $subscription) {
            Mail::to($subscription->email)->send(new SendSubscriptionMessage($product));
            $subscription->status = self::isTrue;
            $subscription->save();
        }
    }

}
