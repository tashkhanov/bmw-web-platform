<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Auth\CompleteProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'homePage'])->name('home.page');

Route::get('/models', [CarsController::class, 'index'])->name('models');
Route::get('/models/{category?}', [CarsController::class, 'index'])->name('models');

Route::get('/car-info{id}', [PageController::class, 'carInfo'])->name('car-info');


Route::get('/wallpapers', [PageController::class, 'wallpapers'])->name('wallpapers');

// ajax
Route::get('/api/search-models', [CarsController::class, 'search'])->name('search.models');
Route::get('/api/models/{id}', [CarsController::class, 'getModelJson'])->name('models.get');

// middleware
Route::middleware(['auth'])->group(function () {

    Route::get('/store', [OrderController::class, 'index'])->name('store');
    Route::post('/store/checkout', [OrderController::class, 'checkout'])->name('store.checkout');

    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/wallpapers/download/{id}', [PageController::class, 'downloadWallpaper'])
        ->name('wallpapers.download');
});


Route::get('auth/{provider}', [SocialController::class, 'redirectToProvider'])->name('auth.provider');
Route::get('auth/{provider}/callback', [SocialController::class, 'handleProviderCallback'])->name('auth.provider.callback');

Route::middleware(['auth'])->group(function () {
    Route::get('complete-profile', [CompleteProfileController::class, 'show'])->name('profile.complete');
    Route::post('complete-profile', [CompleteProfileController::class, 'store'])->name('profile.complete.store');
});


Route::post('/admin/upload-image', function (Illuminate\Http\Request $request) {
    $request->validate([
        'image' => 'required|image',
        'record_id' => 'required|integer',
        'model' => 'required|in:car,car_image'
    ]);

    $file = $request->file('image');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = 'images/images/' . $filename;

    $file->move(public_path('images/images'), $filename);

    if ($request->model === 'car') {
        $record = \App\Models\Car::find($request->record_id);
        $field = 'image';
    } else {
        $record = \App\Models\CarImage::find($request->record_id);
        $field = 'image_path';
    }

    if ($record->$field && file_exists(public_path($record->$field))) {
        unlink(public_path($record->$field));
    }

    $record->update([$field => $path]);

    return response()->json(['success' => true, 'image_path' => asset($path)]);
})->name('admin.upload.image');

Route::prefix('admin')->group(function () {
    Route::post('/cars/{id}/update-image', [App\Http\Controllers\Admin\ImageUploadController::class, 'updateCarImage'])->name('admin.cars.update-image');
    Route::post('/car-images/{id}/update-image', [App\Http\Controllers\Admin\ImageUploadController::class, 'updateCarImageImage'])->name('admin.car-images.update-image');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
