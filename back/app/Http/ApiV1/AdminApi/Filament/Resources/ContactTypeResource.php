<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Contacts\Models\ContactType;
use App\Http\ApiV1\AdminApi\Filament\Resources\ContactTypeResource\Pages\ListContactTypes;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactTypeResource extends Resource
{
    protected static ?string $model = ContactType::class;

    protected static ?string $modelLabel = 'Тип контакта';

    protected static ?string $pluralModelLabel = 'Типы контактов';

    protected static ?string $navigationLabel = 'Типы контактов';

    protected static ?string $navigationGroup = NavigationGroup::CONTACTS->value;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Toggle::make('is_social')
                    ->label('Соц. сеть')
                    ->columnSpan(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Типы контактов не обнаружены')
            ->columns([
                TextColumn::make('name')
                    ->label('Название'),
                IconColumn::make('is_social')
                    ->label('Соц. сеть')
                    ->sortable(),

            ])
            ->defaultSort('is_social', 'desc')
            ->actions([
                EditAction::make()->modalHeading('Редактирование типа контакта'),
                DeleteAction::make()->modalHeading('Удаление типа контакта'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactTypes::route('/'),
        ];
    }
}
