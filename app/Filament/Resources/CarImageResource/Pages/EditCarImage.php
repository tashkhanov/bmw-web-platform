<?php

namespace App\Filament\Resources\CarImageResource\Pages;

use App\Filament\Resources\CarImageResource;
use App\Models\CarImage;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditCarImage extends EditRecord
{
    protected static string $resource = CarImageResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var CarImage $record */
        $record = $this->record;

        if (!empty($data['upload'])) {
            $disk = Storage::disk('cars');
            if ($record->image_path) {
                if ($disk->exists($record->image_path)) {
                    $disk->delete($record->image_path);
                } else {
                    $maybe = 'images/images/' . basename($record->image_path);
                    if ($disk->exists($maybe)) {
                        $disk->delete($maybe);
                    }
                }
            }
            $data['image_path'] = $data['upload'];
            unset($data['upload']);
        } else {
            unset($data['image_path']);
            unset($data['upload']);
        }

        $data['is_main'] = !empty($data['is_main']);

        return $data;
    }

    protected function afterSave(): void
    {
        /** @var CarImage $record */
        $record = $this->record;

        if ($record->is_main) {
            CarImage::where('car_id', $record->car_id)
                ->where('id', '<>', $record->id)
                ->update(['is_main' => false]);
        }

        Notification::make()->title('Изображение обновлено')->success()->send();
    }
}
