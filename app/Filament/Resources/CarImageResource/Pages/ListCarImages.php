<?php

namespace App\Filament\Resources\CarImageResource\Pages;

use App\Filament\Resources\CarImageResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListCarImages extends ListRecords
{
    protected static string $resource = CarImageResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Добавить фото')
                ->icon('heroicon-o-plus')
                ->modalHeading('Новое фото')
                ->modalSubmitActionLabel('Сохранить')
                ->slideOver(),
        ];
    }
}
