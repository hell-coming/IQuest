<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Contacts\Models\Contact;
use App\Domain\Contacts\Models\ContactType;
use App\Domain\Locations\Models\City;
use App\Http\ApiV1\AdminApi\Filament\Resources\ContactResource\Pages\ListContacts;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $modelLabel = 'Контакт';

    protected static ?string $pluralModelLabel = 'Контакты';

    protected static ?string $navigationGroup = NavigationGroup::CONTACTS->value;

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
                Select::make('contact_type_id')
                    ->label('Тип')
                    ->placeholder('Выберите тип контакта')
                    ->relationship('contactType', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->helperText(function () {
                        return ContactType::exists() ? '' : 'Типы не обнаружены. Сначала создайте типы.';
                    })
                    ->native(false),
                TextInput::make('value')
                    ->label('Значение')
                    ->required()
                    ->maxLengthWithHint(255)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Контакты не обнаружены')
            ->columns([
                TextColumn::make('city.name')
                    ->label('Город')
                    ->sortable(),
                TextColumn::make('contactType.name')
                    ->label('Тип'),
            ])
            ->filters([
                SelectFilter::make('city')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->native(false),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make()->modalHeading('Редактирование контакта'),
                ViewAction::make()->modalHeading('Просмотр контакта'),
                DeleteAction::make()->modalHeading('Удаление контакта'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContacts::route('/'),
        ];
    }
}
