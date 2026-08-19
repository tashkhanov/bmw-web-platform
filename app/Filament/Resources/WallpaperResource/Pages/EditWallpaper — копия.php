<?php

namespace App\Filament\Resources\WallpaperResource\Pages;

use App\Filament\Resources\WallpaperResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditWallpaper extends EditRecord
{
    protected static string $resource = WallpaperResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Filament положит путь новой загруженной картинки в image_path автоматически.
        // Мы хотим: если пришла новая картинка и есть старый - удалить старый файл.
        $original = $this->record->getOriginal('image_path');

        if (isset($data['image_path']) && $data['image_path'] !== $original) {
            if ($original && Storage::disk('public_html')->exists($original)) {
                Storage::disk('public_html')->delete($original);
            }
        } else {
            // если поле не изменилось — вернуть старое значение (профилактика)
            $data['image_path'] = $original;
        }

        return $data;
    }
}





// namespace App\Filament\Resources\WallpaperResource\Pages;

// use App\Filament\Resources\WallpaperResource;
// use Filament\Actions;
// use Filament\Resources\Pages\EditRecord;

// class EditWallpaper extends EditRecord
// {
//     protected static string $resource = WallpaperResource::class;

//     protected function getHeaderActions(): array
//     {
//         return [
//             Actions\DeleteAction::make(),
//         ];
//     }

//     protected function mutateFormDataBeforeSave(array $data): array
//     {
//         if (isset($data['new_image'])) {
//             $data['image_path'] = $this->record->handleImageUpload($data['new_image']);
//         }
        
//         unset($data['new_image']);
//         return $data;
//     }
// }
