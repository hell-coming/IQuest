<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Locations\Models\City;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseResource;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages\CreateBooking;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages\EditBooking;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages\ListBookings;
use App\Http\ApiV1\AdminApi\Filament\Rules\NameRule;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use App\Rules\PhoneRule;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingResource extends BaseResource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationLabel = 'Все заявки';

    protected static ?string $modelLabel = 'Заявка';

    protected static ?string $pluralModelLabel = 'Заявки';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city_id')
                    ->label('Город')
                    ->placeholder('Выберите город')
                    ->required()
                    ->relationship('city', 'name')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->helperText(function () {
                        return City::exists() ? '' : 'Лаунжи не обнаружены. Сначала создайте лаунж.';
                    })
                    ->native(false),
                TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->rules([new NameRule])
                    ->maxLengthWithHint(40)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ]),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->required()
                    ->rules([new PhoneRule])
                    ->mask('+7 (999) 999-99-99')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ]),
                Select::make('type')
                    ->label('Тип')
                    ->placeholder('Выберите тип')
                    ->options(BookingType::class)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false)
                    ->disabledOn('edit'),
                Select::make('status')
                    ->label('Статус')
                    ->placeholder('Выберите статус')
                    ->options(BookingStatus::class)
                    ->default(BookingStatus::NEW->getLabel())
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Заявки не обнаружены')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('city.name')
                    ->label('Город')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Имя'),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Тип'),
                SelectColumn::make('status')
                    ->options(BookingStatus::class)
                    ->label('Статус')
                    ->selectablePlaceholder(false),
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
                TextColumn::make('deleted_at')
                    ->label('Дата удаления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                BaseTrashedFilter::make()
                    ->native(false),
                SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->native(false),
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(BookingType::class)
                    ->native(false),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
                    ->native(false),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                RestoreAction::make()->modalHeading('Восстановление заявки'),
                ForceDeleteAction::make()->modalHeading('Полное удаление заявки'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }
}
