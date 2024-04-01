<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TimeslotResource\RelationManagers;

use App\Domain\Bookings\Actions\Bookings\SendMessageBookingAction;
use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Http\ApiV1\AdminApi\Filament\Rules\NameRule;
use App\Rules\PhoneRule;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use PhpParser\Node\Name;

class BookingRelationManager extends RelationManager
{
    protected static string $relationship = 'booking';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $label = 'заявку';

    protected static ?string $pluralLabel = 'Заявки на бронирование';

    protected static bool $isLazy = false;

    public function form(Form $form): Form
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
                    ->native(false),
                TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->rules([new NameRule])
                    ->maxLengthWithHint(40)
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->rules([new PhoneRule])
                    ->mask('+7 (999) 999-99-99')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ]),
                Select::make('type')
                    ->label('Тип заявки')
                    ->options(BookingType::class)
                    ->default(BookingType::QUEST->getLabel())
                    ->required()
                    ->disableOptionWhen(fn(string $value) => $value !== BookingType::QUEST->getLabel())
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false),
                Select::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class)
                    ->default(BookingStatus::NEW->getLabel())
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                    ])
                    ->native(false),
                TextInput::make('count_participants')
                    ->label('Количество участников')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше 0',
                    ]),
                TextInput::make('final_price')
                    ->label('Общая стоимость')
                    ->numeric()
                    ->minValue(0)
                    ->rules([
                        'regex:/^\d{1,6}(\.\d{1,2})?$/'
                    ])
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше или равно :min.',
                        'regex' => 'Поле ":attribute" должно иметь вид от 1 до 6 цифр до запятой и две цифры после.',
                    ]),
                TextInput::make('comment')
                    ->label('Комментарий')
                    ->maxLengthWithHint(125)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'max' => 'Поле ":attribute" не должно превышать :max символов.',
                    ]),
            ]);
    }

    protected function canCreate(): bool
    {
        return !($this->getAllTableRecordsCount());
    }

    protected function canAttach(): bool
    {
        return !($this->getAllTableRecordsCount());
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Заявка')
            ->emptyStateHeading('Нет заявки')
            ->emptyStateDescription('Создать или прикрепить заявку')
            ->paginated(false)
            ->columns([
                TextColumn::make('id')
                    ->label('ID'),
                TextColumn::make('name')
                    ->label('Имя'),
                TextColumn::make('phone')
                    ->label('Телефон'),
                TextColumn::make('count_participants')
                    ->label('Кол-во человек'),
                TextColumn::make('final_price')
                    ->label('Общая стоимость'),
                TextColumn::make('comment')
                    ->label('Комментарий'),
                SelectColumn::make('status')
                    ->label('Статус заявки')
                    ->options(BookingStatus::class)
                    ->selectablePlaceholder(false),
            ])
            ->headerActions([
                AttachAction::make()
                    ->modalHeading('Прикрепить заявку')
                    ->form(fn(AttachAction $action) => [
                        $action->getRecordSelect()->placeholder('Введите ID заявки'),
                        TextInput::make('count_participants')
                            ->label('Количество участников')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->validationMessages([
                                'required' => 'Поле ":attribute" обязательно.',
                                'min' => 'Поле ":attribute" должно быть больше 0',
                            ]),
                        TextInput::make('final_price')
                            ->label('Общая стоимость')
                            ->numeric()
                            ->minValue(0)
                            ->rules([
                                'regex:/^\d{1,6}(\.\d{1,2})?$/'
                            ])
                            ->required()
                            ->validationMessages([
                                'required' => 'Поле ":attribute" обязательно.',
                                'min' => 'Поле ":attribute" должно быть больше или равно :min.',
                                'regex' => 'Поле ":attribute" должно иметь вид от 1 до 6 цифр до запятой и две цифры после.',
                            ]),
                        TextInput::make('comment')
                            ->label('Комментарий')
                            ->maxLengthWithHint(125)
                            ->dehydrateStateUsing(fn($state) => trim($state))
                            ->validationMessages([
                                'max' => 'Поле ":attribute" не должно превышать :max символов.',
                            ]),
                    ])
                    ->recordSelectOptionsQuery(fn(Builder $query) => $query
                        ->where('type', BookingType::QUEST->value)
                        ->whereDoesntHave('timeslots')
                        ->withoutTrashed())
                    ->recordSelectSearchColumns(['id'])
                    ->after(function (RelationManager $livewire, Booking $booking) {
                        $livewire->ownerRecord->update(['is_active' => false]);
                        resolve(SendMessageBookingAction::class)->execute($booking);
                    })
                    ->attachAnother(false),
                CreateAction::make()
                    ->modalHeading('Создание заявки')
                    ->after(function (RelationManager $livewire, Booking $booking) {
                        $livewire->ownerRecord->update(['is_active' => false]);
                        resolve(SendMessageBookingAction::class)->execute($booking);
                    })
                    ->createAnother(false),
            ])
            ->actions(actions: [
                EditAction::make()->modalHeading('Редактирование заявки'),
            ]);
    }
}
