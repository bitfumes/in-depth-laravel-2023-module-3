<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasmany(Campaign::class, 'list_id');
    }

    public function subscribers(): HasMany
    {
        return $this->hasmany(Subscriber::class, 'list_id');
    }

    public function getSubscribeLinkAttribute()
    {
        return route('subscriber.store', $this);
        // return Attribute::make(
        //     get: fn () => route('subscriber.store', $this),
        // );
    }
}
