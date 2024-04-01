<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Quests\Models\AgeLimit;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages\CreateAgeLimit;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages\EditAgeLimit;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages\ListAgeLimits;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AgeLimitResource extends Resource
{
    protected static ?string $model = AgeLimit::class;

    protected static ?string $modelLabel = 'Возрастное ограничение';

    protected static ?string $pluralModelLabel = 'Возрастные ограничения';

    protected static ?string $navigationLabel = 'Возрастные ограничения';

    protected static ?string $navigationGroup = 'Компоненты квестов';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('limit')
                    ->autofocus()
                    ->label('Возрастное ограничение')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLengthWithHint(5)
                    ->dehydrateStateUsing(fn ($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'unique' => 'Поле ":attribute" должно быть уникальным.'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Возрастные ограничения не обнаружены')
            ->columns([
                TextColumn::make('limit')
                    ->label('Возрастное ограничение'),
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
                DeleteAction::make()->modalHeading('Удаление ограничения'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAgeLimits::route('/'),
            'create' => CreateAgeLimit::route('/create'),
            'edit' => EditAgeLimit::route('/{record}/edit'),
        ];
    }
}
