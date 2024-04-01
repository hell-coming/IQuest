<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages\CreateCity;
use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages\EditCity;
use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages\ListCities;
use App\Http\ApiV1\AdminApi\Filament\Rules\CyrillicRule;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $modelLabel = 'Город';

    protected static ?string $pluralModelLabel = 'Города';

    protected static ?string $navigationGroup = NavigationGroup::LOCATIONS->value;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->label('Название')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->rules([new CyrillicRule])
                    ->maxLengthWithHint(30)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'unique' => 'Поле ":attribute" должно быть уникальным.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.',
                    ]),
                TextInput::make('timezone')
                    ->label('Тайм-зона')
                    ->prefix('UTC')
                    ->hint('В формате UTC+3, UTC-2 и т.д.')
                    ->required()
                    ->rules([
                        'regex: /^[+-][0-9]{1,2}?$/'
                    ])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'regex' => 'Поле ":attribute" должно быть в формате UTC (+7, +2 и т.д.)',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Города не обнаружены')
            ->columns([
                TextColumn::make('name')
                    ->label('Название'),
                TextColumn::make('timezone')
                    ->label('Тайм-зона')
                    ->prefix('UTC'),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление города'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCities::route('/'),
            'create' => CreateCity::route('/create'),
            'edit' => EditCity::route('/{record}/edit'),
        ];
    }
}
