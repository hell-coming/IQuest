<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages\CreateFilial;
use App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages\EditFilial;
use App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages\ListFilials;
use App\Http\ApiV1\AdminApi\Filament\Rules\CyrillicNumberRule;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FilialResource extends Resource
{
    protected static ?string $model = Filial::class;

    protected static ?string $modelLabel = 'Филиал';

    protected static ?string $pluralModelLabel = 'Филиалы';

    protected static ?string $navigationGroup = NavigationGroup::LOCATIONS->value;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city_id')
                    ->label('Город')
                    ->placeholder('Выберите город')
                    ->relationship('city', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->helperText(function () {
                        return City::exists() ? '' : 'Города не обнаружены. Сначала создайте города.';
                    })
                    ->native(false),
                TextInput::make('address')
                    ->label('Адрес')
                    ->required()
                    ->rules([new CyrillicNumberRule])
                    ->maxLengthWithHint(40)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('latitude')
                    ->label('Широта')
                    ->hint('Координата по широте')
                    ->numeric()
                    ->required()
                    ->rules([
                        'regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/'
                    ])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'regex' => 'Поле ":attribute" должно быть в формате широты.',
                    ]),
                TextInput::make('longitude')
                    ->label('Долгота')
                    ->hint('Координата по долготе')
                    ->numeric()
                    ->required()
                    ->rules([
                        'regex:/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/',
                    ])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'regex' => 'Поле ":attribute" должно быть в формате долготы.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Филиалы не обнаружены')
            ->columns([
                TextColumn::make('city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Филиал'),
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
            ->defaultSort('city.name')
            ->filters([
                SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->native(false),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление филиала'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFilials::route('/'),
            'create' => CreateFilial::route('/create'),
            'edit' => EditFilial::route('/{record}/edit'),
        ];
    }
}
