<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Models\BookingScheduleLounge;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource\Pages\ListBookingScheduleLounges;
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

class BookingScheduleLoungeResource extends Resource
{
    protected static ?string $model = BookingScheduleLounge::class;

    protected static ?string $modelLabel = 'Заявка на лаунж';

    protected static ?string $pluralModelLabel = 'Заявки на лаунжи';

    protected static ?string $navigationLabel = 'Заявки на лаунжи';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Заявок на лаунжи не обнаружено')
            ->columns([
                TextColumn::make('booking.id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('scheduleLounge.lounge.filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleLounge.lounge.filial.address')
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
                TextColumn::make('scheduleLounge.lounge.name')
                    ->label('Лаунж')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('scheduleLounge.date')
                    ->label('Дата')
                    ->date()
                    ->sortable(),
                TextColumn::make('scheduleLounge.time_from')
                    ->label('Время начала')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('scheduleLounge.time_to')
                    ->label('Время окончания')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                SelectColumn::make('booking.status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
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
                            $query->whereHas('scheduleLounge', function (Builder $query) use ($date) {
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
            'index' => ListBookingScheduleLounges::route('/'),
        ];
    }
}
