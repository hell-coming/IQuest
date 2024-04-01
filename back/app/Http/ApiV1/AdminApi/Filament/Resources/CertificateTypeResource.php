<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources;

use App\Domain\Certificates\Models\CertificateType;
use App\Domain\Users\Enums\Role;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseResource;
use App\Http\ApiV1\AdminApi\Filament\Filters\BaseTrashedFilter;
use App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource\Pages\CreateCertificateType;
use App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource\Pages\EditCertificateType;
use App\Http\ApiV1\AdminApi\Filament\Resources\CertificateTypeResource\Pages\ListCertificateTypes;
use App\Services\CompressImageService;
use Auth;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CertificateTypeResource extends BaseResource
{
    protected static ?string $model = CertificateType::class;

    protected static ?string $modelLabel = 'Сертификат';

    protected static ?string $pluralModelLabel = 'Сертификаты';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->autofocus()
                    ->label('Название')
                    ->required()
                    ->maxLengthWithHint(30)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                TextInput::make('price')
                    ->label('Стоимость упаковки')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->rules([
                        'regex:/^\d{1,6}(\.\d{1,2})?$/'
                    ])
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'numeric' => 'Поле ":attribute" должно быть числом.',
                        'min' => 'Поле ":attribute" должно быть больше или равно :min.',
                        'regex' => 'Поле ":attribute" должно иметь вид от 1 до 6 цифр до запятой и две цифры после.',
                    ]),
                RichEditor::make('description')
                    ->label('Описание')
                    ->columnSpanFull()
                    ->required()
                    ->maxLengthWithHint(255)
                    ->dehydrateStateUsing(fn($state) => trim($state))
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                    ]),
                FileUpload::make('cover')
                    ->directory('certificate_images')
                    ->label('Изображение')
                    ->columnSpanFull()
                    ->image()
                    ->required()
                    ->validationMessages([
                        'required' => 'Поле ":attribute" обязательное.',
                        'image' => 'Поле ":attribute" должно быть изображением.',
                    ])
                    ->saveUploadedFileUsing(function ($record, $file) {
                        return (new CompressImageService($file, 'certificate_images'))->compress();
                    }),
            ]);
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()->role === Role::ADMIN && !$record->trashed();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Сертификаты не обнаружены')
            ->columns([
                TextColumn::make('name')
                    ->label('Название'),
                TextColumn::make('price')
                    ->label('Стоимость упаковки')
                    ->sortable(),
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
            ->defaultSort('price')
            ->filters([
                BaseTrashedFilter::make()
                    ->native(false),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                EditAction::make(),
                ViewAction::make()->modalHeading('Просмотр сертификата'),
                DeleteAction::make()->modalHeading('Удаление сертификата'),
                RestoreAction::make()->modalHeading('Восстановление сертификата'),
                ForceDeleteAction::make()->modalHeading('Полное удаление сертификата'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCertificateTypes::route('/'),
            'create' => CreateCertificateType::route('/create'),
            'edit' => EditCertificateType::route('/{record}/edit'),
        ];
    }
}
