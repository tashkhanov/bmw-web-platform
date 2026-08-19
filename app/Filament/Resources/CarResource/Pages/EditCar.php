<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditCar extends EditRecord
{
    protected static string $resource = CarResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['new_image'])) {
            $old = $this->record->image;
            $disk = Storage::disk('cars');

            if ($old) {
                if ($disk->exists($old)) {
                    $disk->delete($old);
                } else {
                    $maybe = 'images/images/' . basename($old);
                    if ($disk->exists($maybe)) {
                        $disk->delete($maybe);
                    }
                }
            }

            $data['image'] = $data['new_image'];
            unset($data['new_image']);
        } else {
            unset($data['image']);
            unset($data['new_image']);
        }

        return $data;
    }
}
