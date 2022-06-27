<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

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
        'status'
    ];

    protected $with = ['transaksi_detail', 'status_transaksi'];

    /**
     * Get all of the order_supply_detail for the SupplyOrder
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi_detail()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Get the status_supply_order that owns the Supply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status_transaksi()
    {
        return $this->belongsTo(StatusTransaction::class);
    }
}
