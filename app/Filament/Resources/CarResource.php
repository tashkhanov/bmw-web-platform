<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\TagsInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Placeholder::make('car_id')
                ->label('ID')
                ->content(fn ($record) => $record?->id ?? '—')
                ->columnSpanFull(),

            Forms\Components\TextInput::make('car')
                ->label('Модель')
                ->required()
                ->maxLength(255)
                ->validationMessages([
                    'required' => 'Введите название модели.',
                    'max' => 'Название модели не может превышать 255 символов.',
                ]),

            Forms\Components\TextInput::make('category')
                ->label('Категория')
                ->required()
                ->validationMessages([
                    'required' => 'Категория обязательна.',
                ]),

            Forms\Components\TextInput::make('fuel')
                ->label('Топливо')
                ->required()
                ->maxLength(255)
                ->rule('regex:/^[\p{L}\s\-]+$/u')
                ->validationMessages([
                    'required' => 'Укажите тип топлива.',
                    'regex' => 'Поле "Топливо" может содержать только буквы.',
                    'max' => 'Тип топлива не может превышать 255 символов.',
                ]),

            Forms\Components\Textarea::make('description')
                ->label('Описание')
                ->required()
                ->columnSpanFull()
                ->validationMessages([
                    'required' => 'Введите описание модели.',
                ]),

            Forms\Components\Textarea::make('short_description')
                ->label('Краткое описание')
                ->columnSpanFull()
                ->maxLength(500)
                ->validationMessages([
                    'max' => 'Краткое описание не должно быть длиннее 500 символов.',
                ]),

            TagsInput::make('colors')
                ->label('Цвета')
                ->placeholder('Добавь цвет и Enter')
                ->columnSpan(2)
                ->required()
                ->validationMessages([
                    'required' => 'Укажите хотя бы один цвет.',
                ]),

            TagsInput::make('complectation')
                ->label('Комплектация')
                ->placeholder('Добавь комплектацию и Enter')
                ->columnSpan(2)
                ->required()
                ->validationMessages([
                    'required' => 'Добавьте хотя бы одну комплектацию.',
                ]),

            TagsInput::make('interior')
                ->label('Интерьер')
                ->placeholder('Добавь интерьер и Enter')
                ->columnSpan(2)
                ->required()
                ->validationMessages([
                    'required' => 'Укажите интерьер.',
                ]),

            Forms\Components\TextInput::make('price')
                ->label('Цена')
                ->required()
                ->numeric()
                ->minValue(1)
                ->prefix('$')
                ->validationMessages([
                    'required' => 'Введите цену.',
                    'numeric' => 'Цена должна быть числом.',
                    'min' => 'Цена должна быть больше 0.',
                ]),


            Forms\Components\Placeholder::make('current_image')
                ->label('Текущее главное изображение')
                ->content(fn ($record) => $record && $record->image
                    ? new HtmlString('<img src="' . self::resolveAssetPath($record->image) . '?t=' . time() . '" style="max-width:240px;height:auto;border-radius:6px" />')
                    : 'Нет изображения')
                ->columnSpanFull(),

            Forms\Components\FileUpload::make('new_image')
                ->label('Новое главное изображение (PNG/JPG)')
                ->image()
                ->disk('cars')
                ->directory('images/images')
                ->visibility('public')
                ->preserveFilenames(false)
                ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                    $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $ext  = $file->getClientOriginalExtension();
                    return now()->format('Ymd_His') . '_' . Str::slug($name) . '.' . $ext;
                })
                ->required(fn ($operation) => $operation === 'create')
                ->columnSpanFull()
                ->helperText('При редактировании поле пустое — загрузите новый файл, чтобы заменить старый.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('id')->sortable()->toggleable(),

            Tables\Columns\TextColumn::make('car')->label('Модель')->searchable(),

            Tables\Columns\TextColumn::make('category')->label('Категория')->toggleable(),

            Tables\Columns\TextColumn::make('fuel')->label('Топливо')->searchable()->toggleable(),

            Tables\Columns\TextColumn::make('colors')->label('Цвета')->searchable()->toggleable(),

            Tables\Columns\TextColumn::make('complectation')->label('Комплектация')->searchable()->toggleable(),

            Tables\Columns\TextColumn::make('interior')->label('Интерьер')->searchable()->toggleable(),

            Tables\Columns\TextColumn::make('price')->label('Цена')->money()->sortable(),

            ImageColumn::make('main')
                ->label('Главное фото')
                ->getStateUsing(function (Car $record) {
                    $path = $record->mainImage?->image_path ?? $record->image;
                    if (! $path) {
                        return null;
                    }
                    return self::resolveAssetPath($path) . '?t=' . time();
                })
                ->square(),

            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),

            Tables\Actions\Action::make('change_image')
                ->label('Сменить главное изображение')
                ->form([
                    Forms\Components\FileUpload::make('new_image_action')
                        ->label('Новое изображение')
                        ->image()
                        ->disk('cars')
                        ->directory('images/images')
                        ->visibility('public')
                        ->preserveFilenames(false)
                        ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $ext  = $file->getClientOriginalExtension();
                            return now()->format('Ymd_His') . '_' . Str::slug($name) . '.' . $ext;
                        })
                        ->required()
                ])
                ->action(function (Car $record, array $data) {
                    if (!empty($data['new_image_action'])) {
                        $newPath = $data['new_image_action'];
                        $disk = \Illuminate\Support\Facades\Storage::disk('cars');
                        if ($record->image && $disk->exists($record->image)) {
                            $disk->delete($record->image);
                        } else {
                            $maybe = 'images/images/' . basename($record->image ?? '');
                            if ($record->image && $disk->exists($maybe)) {
                                $disk->delete($maybe);
                            }
                        }
                        $record->update(['image' => $newPath]);
                    }

                    Notification::make()->title('Главное изображение обновлено')->success()->send();
                }),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit'   => Pages\EditCar::route('/{record}/edit'),
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
