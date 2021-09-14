<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    private const setTrue = 1;
    private const setFalse = 0;
    protected $fillable = ['name', 'code', 'price', 'category_id', 'description', 'image', 'new', 'hit', 'recommend'];


    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return float|int|mixed
     */
    public function getPriceCalculation() {
        if (!is_null($this->pivot)) {
            return $this->pivot->count * $this->price;
        }
        return $this->price;
    }

    /*

    /**
     * @param $value
     */
    public function setNewAttribute($value)
    {
        $this->attributes['new'] = $value === 'on' ? self::setTrue : self::setFalse;
    }

    /**
     * @param $value
     */
    public function setHitAttribute($value)
    {
        $this->attributes['hit'] = $value === 'on' ? self::setTrue : self::setFalse;
    }

    /**
     * @param $value
     */
    public function setRecommendAttribute($value)
    {
        $this->attributes['recommend'] = $value === 'on' ? self::setTrue : self::setFalse;
    }

    /**
     * @return bool
     */
    public function isHit(): bool
    {
        return $this->hit === self::setTrue;

    }

    /**
     * @return bool
     */
    public function isNew(): bool
    {
        return $this->new === self::setTrue;
    }

    /**
     * @return bool
     */
    public function isRecommend(): bool
    {
        return $this->recommend === self::setTrue;
    }
}
