<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarImageResource\Pages;
use App\Models\CarImage;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class CarImageResource extends Resource
{
    protected static ?string $model = CarImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Фотографии';
    protected static ?string $pluralModelLabel = 'Фотографии';
    protected static ?string $modelLabel = 'Фотография';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('car_id')
                ->label('Автомобиль')
                ->required()
                ->searchable()
                ->options(Car::pluck('car', 'id'))
                ->preload(),

            Placeholder::make('current_image')
                ->label('Текущее изображение')
                ->content(fn ($record) =>
                    $record && $record->image_path
                        ? new HtmlString('<img src="' . self::resolveAssetPath($record->image_path) . '?t=' . time() . '"
                            style="max-width:240px;height:auto;border-radius:6px" />')
                        : 'Нет изображения'
                )
                ->columnSpanFull(),

            Toggle::make('is_main')
                ->label('Главное фото'),

            FileUpload::make('upload')
                ->label('Изображение')
                ->image()
                ->disk('cars')
                ->directory('images/images')
                ->visibility('public')
                ->getUploadedFileNameForStorageUsing(fn ($file) => (string) Str::uuid() . '.' . $file->getClientOriginalExtension())
                ->required(fn ($record) => $record === null)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('car.car')
                ->label('Автомобиль')
                ->sortable()
                ->searchable(),

            Tables\Columns\ImageColumn::make('image_path')
                ->label('Фото')
                ->getStateUsing(fn ($record) => $record->image_path ? self::resolveAssetPath($record->image_path) : null)
                ->size(120),

            Tables\Columns\IconColumn::make('is_main')
                ->label('Главное')
                ->boolean(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarImages::route('/'),
            'create' => Pages\CreateCarImage::route('/create'),
            'edit' => Pages\EditCarImage::route('/{record}/edit'),
        ];
    }

    public static function resolveAssetPath(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }
        return asset('images/images/' . basename($path));
    }
}
