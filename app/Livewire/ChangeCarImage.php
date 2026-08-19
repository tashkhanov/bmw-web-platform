<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\CarImage;
use Filament\Notifications\Notification;

class ChangeCarImage extends Component
{
    use WithFileUploads;

    public $recordId;
    public $newImage;

    public function mount($recordId)
    {
        $this->recordId = $recordId;
    }

    public function save()
    {
        $this->validate([
            'newImage' => 'required|image|max:5120',
        ]);

        $record = CarImage::findOrFail($this->recordId);

        if ($record->image_path && file_exists(public_path($record->image_path))) {
            unlink(public_path($record->image_path));
        }

        $filename = time() . '_' . $this->newImage->getClientOriginalName();
        $this->newImage->move(public_path('images/images'), $filename);
        $path = 'images/images/' . $filename;

        $record->update(['image_path' => $path]);

        Notification::make()
            ->title('✅ Изображение успешно обновлено!')
            ->success()
            ->send();

        return redirect()->back();
    }

    public function render()
    {
        $record = CarImage::find($this->recordId);
        return view('livewire.change-car-image', compact('record'));
    }
}
