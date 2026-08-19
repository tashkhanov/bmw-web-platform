<?php

namespace App\Filament\Resources;

use App\Models\Wallpaper;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;

class WallpaperResource extends Resource
{
    protected static ?string $model = Wallpaper::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Контент';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Placeholder::make('current_image')
                ->label('')
                ->content(fn ($record) => $record && $record->image_path
                    ? new HtmlString('<div style="text-align:center;"><img src="'.asset($record->image_path).'" style="max-width:100%;height:auto;border-radius:6px;margin-bottom:8px" /><p>'.basename($record->image_path).'</p></div>')
                    : '<p>Нет файла</p>'
                ),

            FileUpload::make('image_path')
                ->label('Файл обоев')
                ->image()
                ->disk('public_html')                                  // public root
                ->directory('images/images/wallpapers')                // сохранится в public/images/images/wallpapers
                ->preserveFilenames()                                  // если хочешь оригинальные имена
                ->imagePreviewHeight('250')
                ->required(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image_path')
                    ->label('Файл')
                    ->getStateUsing(fn ($record) => $record?->image_path ? basename($record->image_path) : 'Нет файла'),

                ImageColumn::make('image_path')
                    ->label('Превью')
                    ->getStateUsing(function ($record) {
                        if (! $record?->image_path) {
                            return null;
                        }

                        $path = $record->image_path;

                        // если в БД полный URL, возвращаем как есть
                        if (filter_var($path, FILTER_VALIDATE_URL)) {
                            return $path;
                        }

                        // если файл реально существует в public — возвращаем asset()
                        if (file_exists(public_path($path))) {
                            return asset($path);
                        }

                        // пробуем убрать ведущий слэш, если есть
                        $alt = ltrim($path, '/');
                        if (file_exists(public_path($alt))) {
                            return asset($alt);
                        }

                        return null;
                    })
                    ->size(80)
                    ->square(),

                TextColumn::make('created_at')->label('Создано')->dateTime(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()->label('Удалить'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => \App\Filament\Resources\WallpaperResource\Pages\ListWallpapers::route('/'),
            'create' => \App\Filament\Resources\WallpaperResource\Pages\CreateWallpaper::route('/create'),
            // 'edit'   => \App\Filament\Resources\WallpaperResource\Pages\EditWallpaper::route('/{record}/edit'),
        ];
    }
}
