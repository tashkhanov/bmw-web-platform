<?php

namespace App\Filament\Resources\WallpaperResource\Pages;

use App\Filament\Resources\WallpaperResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWallpaper extends CreateRecord
{
    protected static string $resource = WallpaperResource::class;
}





// namespace App\Filament\Resources\WallpaperResource\Pages;

// use App\Filament\Resources\WallpaperResource;
// use Filament\Actions;
// use Filament\Resources\Pages\CreateRecord;

// class CreateWallpaper extends CreateRecord
// {
//     protected static string $resource = WallpaperResource::class;

//     protected function mutateFormDataBeforeCreate(array $data): array
// {
//     if (isset($data['new_image'])) {
//         $data['image_path'] = (new Wallpaper())->handleImageUpload($data['new_image']);
//     }
    
//     unset($data['new_image']);
//     return $data;
// }
// }
