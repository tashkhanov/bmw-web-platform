<?php

namespace App\Filament\Resources\CarImageResource\Pages;

use App\Filament\Resources\CarImageResource;
use App\Models\CarImage;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCarImage extends CreateRecord
{
    protected static string $resource = CarImageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['upload'])) {
            $data['image_path'] = $data['upload'];
            unset($data['upload']);
        }

        $data['is_main'] = !empty($data['is_main']);

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var CarImage $record */
        $record = $this->record;

        if ($record->is_main) {
            CarImage::where('car_id', $record->car_id)
                ->where('id', '<>', $record->id)
                ->update(['is_main' => false]);
        }

        Notification::make()->title('Изображение создано')->success()->send();
    }
}
