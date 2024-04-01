<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Quests\Models\Genre;
use App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource\Pages\CreateGenre;
use App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource\Pages\EditGenre;
use App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource\Pages\ListGenres;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;

    protected static ?string $modelLabel = 'Жанр';

    protected static ?string $pluralModelLabel = 'Жанры';

    protected static ?string $navigationGroup = NavigationGroup::QUEST_COMPONENTS->value;

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->label('Название')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLengthWithHint(30)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'unique' => 'Поле ":attribute" должно быть уникальным.'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Жанры не обнаружены')
            ->columns([
                TextColumn::make('name')
                    ->label('Название'),
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
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление жанра'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGenres::route('/'),
            'create' => CreateGenre::route('/create'),
            'edit' => EditGenre::route('/{record}/edit'),
        ];
    }
}
