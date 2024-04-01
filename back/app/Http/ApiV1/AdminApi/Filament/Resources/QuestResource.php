<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Locations\Models\Filial;
use App\Domain\Quests\Enums\LevelEnum;
use App\Domain\Quests\Models\AgeLimit;
use App\Domain\Quests\Models\Genre;
use App\Domain\Quests\Models\Quest;
use App\Domain\Quests\Models\Type;
use App\Domain\Users\Enums\Role;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\CreateQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\EditQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\ListQuests;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages\ViewQuest;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestImagesRelationManager;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestWeekdaysSlotsRelationManager;
use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\RelationManagers\QuestWeekendSlotsRelationManager;
use App\Http\ApiV1\AdminApi\Filament\Rules\LatinRule;
use App\Services\CompressImageService;
use Auth;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuestResource extends Resource
{
    protected static ?string $model = Quest::class;

    protected static ?string $modelLabel = 'Квест';

    protected static ?string $pluralModelLabel = 'Квесты';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city')
                    ->label('Город')
                    ->live()
                    ->relationship('filial.city', 'name')
                    ->afterStateUpdated(function ($state, Select $component) {
                        $component->getContainer()
                            ->getComponent('filial_id')
                            ->state(null)
                            ->relationship(
                                'filial',
                                'address',
                            );
                    })
                    ->hiddenOn('')
                    ->helperText(function () {
                        return City::exists() ? '' : 'Города не обнаружены. Сначала создайте города.';
                    })
                    ->native(false),
                Select::make('filial_id')
                    ->key('filial_id')
                    ->label('Филиал')
                    ->options(fn($get) => Filial::where('city_id', $get('city'))->pluck('address', 'id'))
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->helperText(function () {
                        return Filial::exists() ? '' : 'Филиалы не обнаружены. Сначала создайте филиалы.';
                    })
                    ->native(false),
                Select::make('type_id')
                    ->label('Тип')
                    ->relationship('type', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->helperText(function () {
                        return Type::exists() ? '' : 'Типы не обнаружены. Сначала создайте типы.';
                    })
                    ->native(false),
                Select::make('genre_id')
                    ->label('Жанр')
                    ->relationship('genre', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->helperText(function () {
                        return Genre::exists() ? '' : 'Жанры не обнаружены. Сначала создайте жанры.';
                    })
                    ->native(false),
                Select::make('age_limit_id')
                    ->label('Ограничение')
                    ->relationship('age_limit', 'limit')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->helperText(function () {
                        return AgeLimit::exists() ? '' : 'Ограничения не обнаружены. Сначала создайте ограничения.';
                    })
                    ->native(false),
                Select::make('level')
                    ->label('Уровень сложности')
                    ->options(LevelEnum::class)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.'
                    ])
                    ->native(false),
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLengthWithHint(30)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.'
                    ]),
                TextInput::make('slug')
                    ->label('Сокращ. название')
                    ->required()
                    ->maxLengthWithHint(10)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->rules([new LatinRule])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.'
                    ]),
                RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull()
                    ->required()
                    ->maxLengthWithHint(1000)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.'
                    ]),
                RichEditor::make('short_description')
                    ->label('Краткое описание')
                    ->columnSpanFull()
                    ->required()
                    ->maxLengthWithHint(125)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" не должно превышать :max символов.'
                    ]),
                TextInput::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->live()
                    ->required()
                    ->numeric()
                    ->minValue('1')
                    ->maxValue('99')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше или равно :min.',
                        'max' => 'Поле ":attribute" должно быть меньше или равно :max.'
                    ]),
                TextInput::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->required()
                    ->numeric()
                    ->minValue(fn(Get $get) => $get('min_people'))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше или равно полю "мин. кол-во человек".'
                    ]),
                TextInput::make('duration')
                    ->label('Продолжительность (в мин)')
                    ->required()
                    ->numeric()
                    ->minValue('1')
                    ->maxValue('720')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше или равно :min.',
                        'max' => 'Поле ":attribute" должно быть меньше или равно :max.'
                    ]),
                TextInput::make('sequence_number')
                    ->label('Порядковый номер')
                    ->required()
                    ->numeric()
                    ->minValue('1')
                    ->maxValue('999')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'min' => 'Поле ":attribute" должно быть больше или равно :min.',
                        'max' => 'Поле ":attribute" должно быть меньше или равно :max.'
                    ]),
                FileUpload::make('cover')
                    ->directory('quest_covers')
                    ->label('Обложка')
                    ->columnSpanFull()
                    ->image()
                    ->orientImagesFromExif(false)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением.',
                    ])
                    ->saveUploadedFileUsing(function ($record, $file) {
                        return (new CompressImageService($file, 'quest_covers'))->compress();
                    }),
                Toggle::make('is_active')
                    ->label('Отображение на сайте'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Квесты не обнаружены')
            ->columns([
                TextColumn::make('filial.city.name')
                    ->label('Город')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('filial.address')
                    ->label('Филиал')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('Сокращ. название')
                    ->searchable(),
                TextColumn::make('type.name')
                    ->label('Тип')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('genre.name')
                    ->label('Жанр')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('age_limit.limit')
                    ->label('Возрастное ограничение')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('level')
                    ->label('Уровень сложности')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('min_people')
                    ->label('Мин. кол-во человек')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('max_people')
                    ->label('Макс. кол-во человек')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('duration')
                    ->label('Продолжительность')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                TextColumn::make('sequence_number')
                    ->label('Порядковый номер')
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Отображение на сайте')
                    ->disabled(Auth::user()->role !== Role::ADMIN),
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
            ->filters([
                BaseTrashedFilter::make()
                    ->native(false),
                Filter::make('location')
                    ->form([
                        Select::make('city_id')
                            ->label('Город')
                            ->placeholder('Выберите город')
                            ->live()
                            ->relationship('filial.city', 'name')
                            ->afterStateUpdated(function ($state, Select $component) {
                                $component->getContainer()
                                    ->getComponent('filial')
                                    ->state(null)
                                    ->options(fn(Get $get) => Filial::where('city_id', $state)->pluck('address', 'id'));
                            })
                            ->native(false),
                        Select::make('filial_id')
                            ->key('filial')
                            ->label('Филиал')
                            ->placeholder('Выберите филиал')
                            ->options(fn(Get $get) => Filial::where('city_id', $get('city_id'))
                                ->pluck('address', 'id'))
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['city_id'],
                                fn(Builder $query, $city_id): Builder => $query
                                    ->whereHas('filial', fn(Builder $query): Builder => $query->where('city_id', $city_id)),
                            )
                            ->when(
                                $data['filial_id'],
                                fn(Builder $query, $filial_id): Builder => $query
                                    ->where('filial_id', $filial_id),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        $data['city_id'] && $indicators[] = 'Город: ' . City::where('id', $data['city_id'])
                                ->first()->name;
                        $data['filial_id'] && $indicators[] = 'Филиал: ' . Filial::where('id', $data['filial_id'])
                                ->first()->address;
                        return $indicators;
                    })
                    ->columnSpan(2)->columns(2),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление квеста'),
                RestoreAction::make()->modalHeading('Восстановление квеста'),
                ForceDeleteAction::make()->modalHeading('Удаление квеста'),
                ViewAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make('Расписание', [
                QuestWeekdaysSlotsRelationManager::class,
                QuestWeekendSlotsRelationManager::class,
            ]),
            RelationGroup::make('Изображения', [
                QuestImagesRelationManager::class,
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuests::route('/'),
            'create' => CreateQuest::route('/create'),
            'edit' => EditQuest::route('/{record}/edit'),
            'view' => ViewQuest::route('/{record}'),
        ];
    }
}
