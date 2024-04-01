<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Lounges\Models\Lounge;
use App\Domain\Schedules\Models\ScheduleLounge;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages\CreateScheduleLounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages\EditScheduleLounge;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages\ListScheduleLounges;
use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\RelationManagers\BookingRelationManager;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ScheduleLoungeResource extends Resource
{
    protected static ?string $model = ScheduleLounge::class;

    protected static ?string $modelLabel = 'Слот расписания лаунжа';

    protected static ?string $pluralModelLabel = 'Расписание лаунжей';

    protected static ?string $navigationLabel = 'Расписание лаунжей';

    protected static ?string $navigationGroup = NavigationGroup::SCHEDULE->value;

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city')
                    ->label('Город')
                    ->live()
                    ->relationship('lounge.filial.city', 'name')
                    ->hiddenOn('')
                    ->helperText(function () {
                        return City::exists() ? '' : 'Города не обнаружены. Сначала создайте города.';
                    })
                    ->native(false),
                Select::make('filial')
                    ->label('Филиал')
                    ->live()
                    ->options(fn(Get $get): Collection => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->hiddenOn('')
                    ->helperText(function () {
                        return Filial::exists() ? '' : 'Филиалы не обнаружены. Сначала создайте филиалы.';
                    })
                    ->native(false),
                Select::make('lounge_id')
                    ->label('Лаунж')
                    ->options(fn(Get $get): Collection => Lounge::query()
                        ->where('filial_id', $get('filial'))
                        ->pluck('name', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->helperText(function () {
                        return Lounge::exists() ? '' : 'Лаунжи не обнаружены. Сначала создайте лаунжи.';
                    })
                    ->native(false),
                DatePicker::make('date')
                    ->label('Дата')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('time_from')
                    ->label('Время начала')
                    ->mask('99:99')
                    ->placeholder('00:00')
                    ->rules(['date_format:H:i'])
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'date_format' => 'Поле ":attribute" должно быть в формате 00:00.',
                    ]),
                TextInput::make('time_to')
                    ->label('Время окончания')
                    ->mask('99:99')
                    ->placeholder('00:00')
                    ->after('time_from')
                    ->rules(['date_format:H:i'])
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'date_format' => 'Поле ":attribute" должно быть в формате 00:00.',
                        'after' => 'Поле ":attribute" должно быть позже "времени начала".',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Слоты не обнаружены')
            ->columns([
                TextColumn::make('lounge.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lounge.filial.address')
                    ->label('Филиал')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lounge.name')
                    ->label('Лаунж')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Дата')
                    ->date()
                    ->sortable(),
                TextColumn::make('time_from')
                    ->label('Время начала'),
                TextColumn::make('time_to')
                    ->label('Время окончания'),
            ])
            ->filters([
                BaseTrashedFilter::make()
                    ->native(false),
                Filter::make('location')
                    ->form([
                        Select::make('city_id')
                            ->label('Город')
                            ->placeholder('Выберите город')
                            ->live()
                            ->relationship('lounge.filial.city', 'name')
                            ->afterStateUpdated(function ($state, Select $component) {
                                $component->getContainer()
                                    ->getComponent('filial')
                                    ->state(null)
                                    ->options(fn() => Filial::where('city_id', $state)->pluck('address', 'id'));
                            })
                            ->native(false),
                        Select::make('filial_id')
                            ->key('filial')
                            ->label('Филиал')
                            ->placeholder('Выберите филиал')
                            ->live()
                            ->options(fn(Get $get) => Filial::where('city_id', $get('city_id'))
                                ->pluck('address', 'id'))
                            ->afterStateUpdated(function ($state, Select $component) {
                                $component->getContainer()
                                    ->getComponent('lounge')
                                    ->state(null)
                                    ->options(fn() => Lounge::where('filial_id', $state)->pluck('name', 'id'));
                            })
                            ->native(false),
                        Select::make('lounge_id')
                            ->key('lounge')
                            ->label('Лаунж')
                            ->placeholder('Выберите лаунж')
                            ->options(fn(Get $get) => Lounge::where('filial_id', $get('filial_id'))
                                ->pluck('name', 'id'))
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['city_id'],
                                fn(Builder $query, $city_id): Builder => $query
                                    ->whereHas('lounge.filial', fn(Builder $query): Builder => $query->where('city_id', $city_id)),
                            )
                            ->when(
                                $data['filial_id'],
                                fn(Builder $query, $filial_id): Builder => $query
                                    ->whereHas('lounge.filial', fn(Builder $query): Builder => $query->where('id', $filial_id)),
                            )
                            ->when(
                                $data['lounge_id'],
                                fn(Builder $query, $lounge_id): Builder => $query
                                    ->where('lounge_id', $lounge_id),
                            );
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];
                        $data['city_id'] && $indicators[] = 'Город: ' . City::find($data['city_id'])->name;
                        $data['filial_id'] && $indicators[] = 'Филиал: ' . Filial::find($data['filial_id'])->address;
                        $data['lounge_id'] && $indicators[] = 'Лаунж: ' . Lounge::find($data['lounge_id'])->name;
                        return $indicators;
                    })
                    ->columnSpan(3)->columns(3),
                Filter::make('date')
                    ->form([DatePicker::make('date')->label('Дата')])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['date'],
                            fn(Builder $query, $date): Builder => $query->whereDate('date', '=', $date)
                        );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        $data['date'] && $indicators[] = 'Дата: ' . Carbon::parse($data['date'])->translatedFormat('M j, Y');
                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление слота'),
                ForceDeleteAction::make()->modalHeading('Удаление слота'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BookingRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListScheduleLounges::route('/'),
            'create' => CreateScheduleLounge::route('/create'),
            'edit' => EditScheduleLounge::route('/{record}/edit'),
        ];
    }
}
