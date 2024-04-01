<?php

namespace App\Domain\Users\Models;

use App\Domain\Locations\Models\Filial;
use App\Domain\Users\Enums\Role;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id Идентификатор пользователя
 * @property string $name Имя пользователя
 * @property string $surname Фамилия пользователя
 * @property string $login Логин пользователя
 * @property string $password Пароль пользователя
 * @property int $filial_id Идентификатор фил иала
 * @property Role $role Роль пользователя
 * @property string $vk_id Идентификатор пользователя во ВКонтакте
 *
 * @property-read Filial $filials Филиалы пользователя
 */
class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'login',
        'password',
        'role',
        'vk_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
        'role' => Role::class,
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return static::query()->where('login', $this->login)->exists();
    }

    public function filials(): BelongsToMany
    {
        return $this->belongsToMany(Filial::class, 'filial_users');
    }
}
