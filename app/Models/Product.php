<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use App\Services\CurrencyConversion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable;

    private const setTrue = 1;
    private const setFalse = 0;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'code',
        'price',
        'category_id',
        'description',
        'image',
        'new',
        'hit',
        'recommend',
        'count',
        'name_en',
        'description_en'
    ];


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
    public function getPriceForCount()
    {
        if (!is_null($this->pivot)) {
            return $this->pivot->count * $this->price;
        }
        return $this->price;
    }

    /**
     * @param $query
     * @param $code
     * @return mixed
     */
    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeHit($query)
    {
        return $query->where('hit', self::setTrue);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeNew($query)
    {
        return $query->where('new', self::setTrue);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecommend($query)
    {
        return $query->where('recommend', self::setTrue);
    }


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

    public function isAvailable(){
        return !$this->trashed() && $this->count > self::setFalse;
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

    /**
     * @param $value
     * @return float
     */
    public function getPriceAttribute($value): float
    {
        return round(CurrencyConversion::convert($value), 2);
    }
}
