<?php

namespace App\Models;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;

class Order extends Model
{
    use HasFactory;

    public const ORDER_STATUS_0 = 0;
    public const ORDER_STATUS_1 = 1;

    protected $fillable = ['user_id'];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::ORDER_STATUS_1);
    }

    /**
     * @return int
     */
    public function calculateFullSum(): int
    {
        $sum = 0;
        foreach ($this->products()->withTrashed()->get() as $product) {
            $sum += $product->getPriceForCount();
        }
        return $sum;
    }

    /**
     *
     */
    public static function eraseOrderSum()
    {
        session()->forget('full_order_sum');
    }

    /**
     * @param $changeSum
     */
    public static function changeFullSum($changeSum)
    {
        $sum = self::getFullSum() + $changeSum;
        session(['full_order_sum' => $sum]);
    }

    /**
     * @return Application|SessionManager|Store|mixed
     */
    public static function getFullSum()
    {
        return session('full_order_sum', self::ORDER_STATUS_0);
    }

    /**
     * @param $name
     * @param $phone
     * @return bool
     */
    public function saveOrder($name, $phone)
    {
        if ($this->status == self::ORDER_STATUS_0) {
            $this->name = $name;
            $this->phone = $phone;
            $this->status = self::ORDER_STATUS_1;
            $this->save();
            session()->forget('orderId');
            return true;
        } else {
            return false;
        }
    }
}
