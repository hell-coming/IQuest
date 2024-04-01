<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages;

use App\Domain\Users\Models\User;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\UserResource;
use App\Http\ApiV1\AdminApi\Filament\Rules\LatinNumberRule;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class EditUser extends BaseEditRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Редактирование пользователя';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::query()->findOrFail($data['id']);
        $city = $user->filials->first()?->city->id;

        $data['city'] = $city;
        $data['filials'] = $user->filials->pluck('id')->toArray();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('change-password')
                ->label('Сменить пароль')
                ->modalHeading('Смена пароля')
                ->form([
                    TextInput::make('password')
                        ->label('Пароль')
                        ->password()
                        ->revealable()
                        ->required()
                        ->hiddenOn('edit')
                        ->minLength(8)
                        ->maxLengthWithHint(32)
                        ->rules([new LatinNumberRule()])
                        ->validationMessages([
                            'required' => 'Поле ":attribute" обязательное.',
                            'min' => 'Поле ":attribute" должно содержать не менее :min символов.',
                            'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                        ]),
                    TextInput::make('password_confirmation')
                        ->label('Подтверждение пароля')
                        ->password()
                        ->same('password')
                        ->revealable()
                        ->required()
                        ->hiddenOn('edit')
                        ->validationMessages([
                            'required' => 'Поле ":attribute" обязательное.',
                            'same' => 'Поле ":attribute" должно совпадать с полем "пароль".',
                        ]),
                ])
                ->action(function ($record, array $data) {
                    $record->update([
                        'password' => Hash::make($data['password']),
                    ]);
                    Notification::make()
                        ->title('Пароль успешно изменен')
                        ->success()
                        ->send();
                }),
            DeleteAction::make()->modalHeading('Удаление пользователя'),
        ];
    }
}
