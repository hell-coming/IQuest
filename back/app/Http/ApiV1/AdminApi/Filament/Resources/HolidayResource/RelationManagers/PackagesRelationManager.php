<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\RelationManagers;

use App\Domain\Users\Enums\Role;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use Auth;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class PackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'packages';

    protected static ?string $label = 'Пакет';

    protected static ?string $pluralModelLabel = 'Пакеты';

    protected static bool $isLazy = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLengthWithHint(30)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->rules([
                        'regex:/^\d{1,6}(\.\d{1,2})?$/'
                    ])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше или равно :min.',
                        'regex' => 'Поле ":attribute" должно иметь вид от 1 до 6 цифр до запятой и две цифры после.',
                    ]),
                TextInput::make('sequence_number')
                    ->label('Порядковый номер')
                    ->required()
                    ->numeric()
                    ->minValue('1')
                    ->maxValue('999')
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательно.',
                        'min' => 'Поле ":attribute" должно быть больше или равно :min.',
                        'max' => 'Поле ":attribute" должно быть меньше или равно :max.'
                    ]),
                RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull()
                    ->required()
                    ->maxLengthWithHint(1000)
                    ->helperText(new HtmlString('При заполнении описания обязательно используйте <b>нумерованные</b> или <b>маркированные</b> списки для корректного отображения компонентов праздника.'))
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                Toggle::make('is_active')
                    ->label('Отображение на сайте'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Пакеты')
            ->recordTitleAttribute('name')
            ->emptyStateHeading('Пакеты не обнаружены')
            ->columns([
                TextColumn::make('sequence_number')
                    ->label('Порядковый номер')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Название'),
                TextColumn::make('price')
                    ->label('Цена')
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Отображение на сайте')
                    ->disabled(Auth::user()->role !== Role::ADMIN)
                    ->sortable(),
            ])
            ->defaultSort('sequence_number')
            ->filters([
                BaseTrashedFilter::make()
                    ->native(false),
            ])
            ->headerActions([
                CreateAction::make()
                    ->createAnother(false),
            ])
            ->actions([
                EditAction::make()->modalHeading('Редактирование пакета'),
                ViewAction::make()->modalHeading('Просмотр пакета'),
                DeleteAction::make()->modalHeading('Удаление пакета'),
                RestoreAction::make()->modalHeading('Восстановление пакета'),
                ForceDeleteAction::make()->modalHeading('Удаление пакета'),
            ]);
    }
}
