<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use App\Models\Car;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;

class ChangeCarImage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = CarResource::class;
    protected static string $view = 'filament.resources.car-resource.pages.change-car-image';

    public ?array $data = [];
    public Car $record;

    public function mount(int $record): void
    {
        $this->record = Car::findOrFail($record);
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('new_image')
                    ->label('Новое изображение')
                    ->image()
                    ->required()
                    ->disk('cars')
                    ->directory('images/images')
                    ->preserveFilenames(false)
                    ->imageEditor(),
            ])
            ->statePath('data');
    }

    public function getTitle(): string
    {
        return 'Смена изображения для ' . $this->record->car;
    }

    public function submit()
    {
        $data = $this->form->getState();
        $newImagePath = $data['new_image'] ?? null;

        if (! $newImagePath) {
            Notification::make()->title('Нет загруженного файла')->danger()->send();
            return redirect(CarResource::getUrl('edit', ['record' => $this->record]));
        }

        $disk = Storage::disk('cars');

        if ($this->record->image) {
            if ($disk->exists($this->record->image)) {
                $disk->delete($this->record->image);
            } else {
                $maybe = 'images/images/' . basename($this->record->image);
                if ($disk->exists($maybe)) {
                    $disk->delete($maybe);
                }
            }
        }

        $this->record->update(['image' => $newImagePath]);

        Notification::make()
            ->title('Изображение успешно обновлено')
            ->success()
            ->send();

        return redirect(CarResource::getUrl('edit', ['record' => $this->record]));
    }
}
