<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\BookingCertificate;
use App\Domain\Certificates\Models\CertificateType;
use App\Domain\Locations\Models\City;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseResource;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages\CreateBookingCertificate;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages\EditBookingCertificate;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages\ListBookingCertificates;
use App\Http\ApiV1\AdminApi\Filament\Rules\NameRule;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use App\Rules\PhoneRule;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingCertificateResource extends BaseResource
{
    protected static ?string $model = BookingCertificate::class;

    protected static ?string $modelLabel = 'Заявка на сертификат';

    protected static ?string $pluralModelLabel = 'Заявки на сертификаты';

    protected static ?string $navigationLabel = 'Заявки на сертификаты';

    protected static ?string $navigationGroup = NavigationGroup::BOOKING->value;

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Repeater::make('booking')
                            ->label('Заявка')
                            ->schema([
                                Select::make('city_id')
                                    ->label('Город')
                                    ->placeholder('Выберите город')
                                    ->required()
                                    ->relationship('booking.city', 'name')
                                    ->validationMessages([
                                        'required' => 'Поле ":attribute" обязательно.',
                                    ])
                                    ->helperText(function () {
                                        return City::exists() ? '' : 'Города не обнаружены. Сначала создайте города.';
                                    })
                                    ->native(false),
                                TextInput::make('name')
                                    ->label('Имя')
                                    ->required()
                                    ->rules([new NameRule])
                                    ->maxLengthWithHint(40)
                                    ->dehydrateStateUsing(fn($state) => trim($state))
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
                                TextInput::make('type')
                                    ->label('Тип')
                                    ->default(BookingType::CERTIFICATE->getLabel())
                                    ->placeholder('Выберите тип')
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Поле ":attribute" обязательно.',
                                    ])
                                    ->readOnly(),
                                Select::make('status')
                                    ->label('Статус заявки')
                                    ->options(BookingStatus::class)
                                    ->default(BookingStatus::NEW->getLabel())
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Поле ":attribute" обязательно.',
                                    ])
                                    ->native(false),
                            ])
                            ->columns(3)
                            ->disableItemDeletion()
                            ->disableItemCreation()
                            ->disableItemMovement(),
                        Repeater::make('certificateType')
                            ->label('Тип сертификата')
                            ->schema([
                                Select::make('certificate_type_id')
                                    ->label('Тип')
                                    ->placeholder('Выберите тип')
                                    ->relationship('certificateType', 'name', fn($query) => $query->withoutTrashed())
                                    ->required()
                                    ->validationMessages([
                                        'required' => 'Поле ":attribute" обязательное.',
                                    ])
                                    ->helperText(function () {
                                        return CertificateType::exists() ? '' : 'Типы не обнаружены. Сначала создайте тип.';
                                    })
                                    ->native(false),
                            ])
                            ->disableItemDeletion()
                            ->disableItemCreation()
                            ->disableItemMovement(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Заявок на сертификаты не обнаружено')
            ->columns([
                TextColumn::make('booking.id')
                    ->label('ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('booking.city.name')
                    ->label('Город')
                    ->sortable(),
                TextColumn::make('booking.name')
                    ->label('Имя'),
                TextColumn::make('booking.phone')
                    ->label('Телефон'),
                TextColumn::make('certificateType.name')
                    ->label('Типа сертификата'),
                TextColumn::make('created_at')
                    ->label('Дата заявки')
                    ->date(),
                SelectColumn::make('booking.status')
                    ->label('Статус')
                    ->options(BookingStatus::class)
                    ->selectablePlaceholder(false),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                BaseTrashedFilter::make()
                    ->native(false),
                SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('booking.city', 'name')
                    ->native(false),
                SelectFilter::make('type')
                    ->label('Тип сертификата')
                    ->relationship('certificateType', 'name')
                    ->native(false),
                Filter::make('date')
                    ->form([DatePicker::make('date')->label('Дата')])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['date'], fn($query, $date) => $query
                            ->whereDate('created_at', $date));
                    })
                    ->indicateUsing(function (array $data) {
                        $indicators = [];
                        $data['date'] && $indicators[] = 'Дата: ' . Carbon::parse($data['date'])->translatedFormat('M j, y');
                        return $indicators;
                    })
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookingCertificates::route('/'),
            'create' => CreateBookingCertificate::route('/create'),
            'edit' => EditBookingCertificate::route('/{record}/edit'),
        ];
    }
}
