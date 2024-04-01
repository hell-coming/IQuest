<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Quests\Models\Quest;
use App\Domain\Schedules\Models\Timeslot;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\Pages\CreateTimeslot;
use App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\Pages\EditTimeslot;
use App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\Pages\ListTimeslots;
use App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\RelationManagers\BookingRelationManager;
use App\Domain\Users\Enums\Role;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Tables\Actions\ForceDeleteAction;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class TimeslotResource extends Resource
{
    protected static ?string $model = Timeslot::class;

    protected static ?string $modelLabel = 'Слот расписания квеста';

    protected static ?string $pluralModelLabel = 'Расписание квестов';

    protected static ?string $navigationLabel = 'Расписание квестов';

    protected static ?string $navigationGroup = NavigationGroup::SCHEDULE->value;

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city')
                    ->label('Город')
                    ->options(fn(): Collection => City::all()->pluck('name', 'id'))
                    ->hiddenOn('')
                    ->disabledOn('edit'),
                Select::make('filial')
                    ->label('Филиал')
                    ->options(fn(Get $get): Collection => Filial::query()
                        ->where('city_id', $get('city'))
                        ->pluck('address', 'id'))
                    ->hiddenOn('')
                    ->disabledOn('edit'),
                Select::make('quest')
                    ->label('Квест')
                    ->placeholder('Выберите квест')
                    ->options(fn(Get $get) => Quest::query()
                        ->where('filial_id', $get('filial'))
                        ->pluck('name', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->disabledOn('edit'),
                DatePicker::make('date')
                    ->label('Дата')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->disabledOn('edit'),
                TextInput::make('time')
                    ->label('Время')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->disabledOn('edit'),
                Toggle::make('is_active')
                    ->label('Активность слота')
                    ->columnSpanFull()
                    ->disabled(Auth::user()->role !== Role::ADMIN)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Слоты не обнаружены')
            ->columns([
                TextColumn::make('scheduleQuest.quest.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleQuest.quest.filial.address')
                    ->label('Филиал')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleQuest.quest.slug')
                    ->label('Квест')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleQuest.date')
                    ->label('Дата')
                    ->date()
                    ->sortable(),
                TextColumn::make('time')
                    ->label('Время'),
                TextColumn::make('price')
                    ->label('Цена'),
                ToggleColumn::make('is_active')
                    ->label('Активность слота')
                    ->disabled(Auth::user()->role !== Role::ADMIN),
            ])
            ->defaultSort('scheduleQuest.date')
            ->filters([
                BaseTrashedFilter::make()
                    ->native(false),
                Filter::make('location')
                    ->form([
                        Select::make('city_id')
                            ->label('Город')
                            ->placeholder('Выберите город')
                            ->live()
                            ->relationship('scheduleQuest.quest.filial.city', 'name')
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
                                    ->getComponent('quest')
                                    ->state(null)
                                    ->options(fn() => Quest::where('filial_id', $state)->pluck('slug', 'id'));
                            })
                            ->native(false),
                        Select::make('quest_id')
                            ->key('quest')
                            ->label('Квест')
                            ->placeholder('Выберите квест')
                            ->options(fn(Get $get) => Quest::where('filial_id', $get('filial_id'))
                                ->pluck('slug', 'id'))
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['city_id'],
                                fn(Builder $query, $city_id): Builder => $query
                                    ->whereHas('scheduleQuest.quest.filial', fn(Builder $query): Builder => $query->where('city_id', $city_id)),
                            )
                            ->when(
                                $data['filial_id'],
                                fn(Builder $query, $filial_id): Builder => $query
                                    ->whereHas('scheduleQuest.quest.filial', fn(Builder $query): Builder => $query->where('filial_id', $filial_id)),
                            )
                            ->when(
                                $data['quest_id'],
                                fn(Builder $query, $quest_id): Builder => $query
                                    ->whereHas('scheduleQuest', fn(Builder $query): Builder => $query->where('quest_id', $quest_id)),
                            );
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];
                        $data['city_id'] && $indicators[] = 'Город: ' . City::find($data['city_id'])->name;
                        $data['filial_id'] && $indicators[] = 'Филиал: ' . Filial::find($data['filial_id'])->address;
                        $data['quest_id'] && $indicators[] = 'Филиал: ' . Quest::find($data['quest_id'])->slug;
                        return $indicators;
                    })
                    ->columnSpan(3)->columns(3),
                Filter::make('date')
                    ->form([DatePicker::make('date')->label('Дата')])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['date'],
                            fn(Builder $query, $date): Builder => $query
                                ->whereHas('scheduleQuest', fn(Builder $query): Builder => $query
                                    ->whereDate('date', '=', $date))
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
                ForceDeleteAction::make()->modalHeading('Удаление слота'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BookingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTimeslots::route('/'),
            'create' => CreateTimeslot::route('/create'),
            'edit' => EditTimeslot::route('/{record}/edit'),
        ];
    }
}
