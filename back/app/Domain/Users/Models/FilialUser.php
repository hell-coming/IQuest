<?php

namespace App\Domain\Users\Models;

use App\Domain\Locations\Models\Filial;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FilialUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'filial_id',
        'user_id',
    ];
    
    public function filial(): BelongsTo
    {
        return $this->belongsTo(Filial::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
