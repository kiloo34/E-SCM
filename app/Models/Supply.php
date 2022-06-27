<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'supplies';

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
        'name',
        'stock',
        'price',
        'status',
        'supply_id'
    ];

    /**
     * Get the supply_order_detail associated with the Supply
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supply_order_detail()
    {
        return $this->hasOne(SupplyOrderDetail::class);
    }

    /**
     * Get the status_supply that owns the Supply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status_supply()
    {
        return $this->belongsTo(StatusSupply::class);
    }

    /**
     * Get the menu_detail associated with the Supply
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function menu_detail()
    {
        return $this->hasOne(MenuDetail::class);
    }
}
