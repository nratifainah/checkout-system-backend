<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductOffer
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $customer_id
 * @property int $product_id
 * @property int $minimum_quantity
 * @property string $type
 * @property int $value
 * @property int|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereMinimumQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductOffer whereValue($value)
 */
class ProductOffer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'minimum_quantity', 'type', 'value',
    ];

}
