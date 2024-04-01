<?php

namespace App\Domain\Contacts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * class ContactType
 *
 * @property int $id Идентификатор типа контакта
 * @property string $name Название типа контакта
 */
class ContactType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_social',
    ];

    protected $casts = [
        'is_social' => 'boolean',
    ];
}
