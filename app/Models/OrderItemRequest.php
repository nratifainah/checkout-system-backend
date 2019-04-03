<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderItemRequest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItemRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItemRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderItemRequest query()
 * @mixin \Eloquent
 */
class OrderItemRequest extends Model
{
    //

    protected $fillable = [
        'product_id', 'quantity',
    ];
}
