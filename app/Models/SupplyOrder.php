<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyOrder extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supply_orders';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total',
        'price',
        'status'
    ];

    protected $with = ['order_supply_detail'];

    /**
     * Get all of the order_supply_detail for the SupplyOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_supply_detail()
    {
        return $this->hasMany(SupplyOrderDetail::class);
    }
}
