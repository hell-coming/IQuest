<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Locations\Models\City;
use App\Domain\Sales\Models\Sale;
use App\Domain\Users\Enums\Role;
use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages\CreateSale;
use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages\EditSale;
use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages\ListSales;
use App\Services\CompressImageService;
use Auth;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $modelLabel = 'Акция';

    protected static ?string $pluralModelLabel = 'Акции';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('city_id')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ])
                    ->helperText(function () {
                        return City::exists() ? '' : 'Города не обнаружены. Сначала создайте города.';
                    })
                    ->native(false),
                TextInput::make('header')
                    ->label('Заголовок')
                    ->required()
                    ->maxLengthWithHint(32)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                TextInput::make('description')
                    ->label('Описание')
                    ->required()
                    ->maxLengthWithHint(75)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'max' => 'Поле ":attribute" должно содержать не более :max символов.',
                    ]),
                FileUpload::make('front_image')
                    ->directory('sales')
                    ->label('Переднее изображение')
                    ->columnSpanFull()
                    ->image()
                    ->orientImagesFromExif(false)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением.',
                    ])
                    ->saveUploadedFileUsing(function ($record, $file) {
                        return (new CompressImageService($file, 'sales'))->compress();
                    }),
                FileUpload::make('back_image')
                    ->directory('sales')
                    ->label('Заднее изображение')
                    ->columnSpanFull()
                    ->image()
                    ->orientImagesFromExif(false)
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением.',
                    ])
                    ->saveUploadedFileUsing(function ($record, $file) {
                        return (new CompressImageService($file, 'sales'))->compress();
                    }),
                Toggle::make('is_active')
                    ->label('Отображение на сайте'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Акции не обнаружены')
            ->columns([
                TextColumn::make('city.name')
                    ->label('Город')
                    ->sortable(),
                TextColumn::make('header')
                    ->label('Заголовок'),
                TextColumn::make('description')
                    ->label('Описание'),
                ToggleColumn::make('is_active')
                    ->label('Отображение на сайте')
                    ->disabled(Auth::user()->role !== Role::ADMIN),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('city_id')
            ->filters([
                SelectFilter::make('city_id')
                    ->label('Город')
                    ->relationship('city', 'name')
                    ->native(false),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                DeleteAction::make()->modalHeading('Удаление акции'),
                ViewAction::make()->modalHeading('Просмотр акции'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSales::route('/'),
            'create' => CreateSale::route('/create'),
            'edit' => EditSale::route('/{record}/edit'),
        ];
    }
}
