<?php

namespace App\Filament\Resources\WallpaperResource\Pages;

use App\Filament\Resources\WallpaperResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListWallpapers extends ListRecords
{
    protected static string $resource = WallpaperResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Добавить обои'),
        ];
    }
}





// namespace App\Filament\Resources\WallpaperResource\Pages;

// use App\Filament\Resources\WallpaperResource;
// use Filament\Actions;
// use Filament\Resources\Pages\ListRecords;

// class ListWallpapers extends ListRecords
// {
//     protected static string $resource = WallpaperResource::class;

//     protected function getHeaderActions(): array
//     {
//         return [
//             Actions\CreateAction::make(),
//         ];
//     }
// }
