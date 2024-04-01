<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Models\BookingScheduleQuest;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource\Pages\ListBookingScheduleQuests;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class BookingScheduleQuestResource extends Resource
{
    protected static ?string $model = BookingScheduleQuest::class;

    protected static ?string $modelLabel = 'Заявка на квест';

    protected static ?string $pluralLabel = 'Заявки на квесты';

    protected static ?string $navigationLabel = 'Заявки на квесты';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Заявок на квесты не обнаружены')
            ->columns([
                TextColumn::make('booking.id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('timeslot.scheduleQuest.quest.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('timeslot.scheduleQuest.quest.filial.address')
                    ->label('Филиал')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('booking.name')
                    ->label('Имя')
                    ->numeric(),
                TextColumn::make('booking.phone')
                    ->label('Телефон')
                    ->numeric()
                    ->searchable(),
                TextColumn::make('timeslot.scheduleQuest.quest.name')
                    ->label('Квест')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('timeslot.scheduleQuest.date')
                    ->label('Дата')
                    ->date()
                    ->sortable(),
                TextColumn::make('timeslot.time')
                    ->label('Время')
                    ->numeric(),
                SelectColumn::make('booking.status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
                    ->selectablePlaceholder(false),
                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->defaultSort('id', 'desc')
            ->filters([
                BaseTrashedFilter::make()
                    ->native(false),
                SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('booking.city', 'name')
                    ->native(false),
                Filter::make('date')
                    ->form([DatePicker::make('date')->label('Дата')])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['date'], function ($query, $date) {
                            $query->whereHas('timeslot.scheduleQuest', function (Builder $query) use ($date) {
                                $query->whereDate('date', Carbon::parse($date));
                            });
                        });
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        $data['date'] && $indicators[] = 'Дата: ' . Carbon::parse($data['date'])->translatedFormat('M j, Y');
                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContentCollapsible);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingScheduleQuests::route('/'),
        ];
    }
}