<?php

namespace App\Models;

use App\Events\Fund\FundCreated;
use App\Events\Fund\FundUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = [
        'manager_id',
        'name',
        'start_year',
        'aliases',
    ];

    protected $casts = [
        'aliases' => 'array',
    ];

    protected $dispatchesEvents = [
        'created' => FundCreated::class,
        'updated' => FundUpdated::class,
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
}
