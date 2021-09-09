<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    public const ORDER_STATUS_0 = 0;
    public const ORDER_STATUS_1 = 1;

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

    /**
     * @return int
     */
    public function getFullPrice(): int
    {
        $sum = 0;
        foreach ($this->products as $product) {
            $sum += $product->getPriceCalculation();
        }
        return $sum;
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
