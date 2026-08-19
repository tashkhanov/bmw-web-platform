<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCar extends CreateRecord
{
    protected static string $resource = CarResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['new_image'])) {
            $data['image'] = $data['new_image'];
            unset($data['new_image']);
        }

        return $data;
    }
}
