<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriber extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => 'array',
    ];

    public function list() : BelongsTo
    {
        return $this->belongsTo(EmailList::class);
    }
}
