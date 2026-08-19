<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        Forms\Components\TextInput::make('name')
            ->label('Имя')
            ->required()
            ->maxLength(255)
            ->validationMessages([
                'required' => 'Введите имя.',
                'max' => 'Имя не должно превышать 255 символов.',
            ]),

        Forms\Components\TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true) // чтобы при редактировании не ругалось на свой же email
            ->validationMessages([
                'required' => 'Введите email.',
                'email' => 'Укажите корректный email.',
                'unique' => 'Такой email уже используется.',
                'max' => 'Email не должен превышать 255 символов.',
            ]),

        Forms\Components\TextInput::make('phone')
            ->label('Телефон')
            ->tel()
            ->maxLength(32)
            ->nullable()
            ->rule('regex:/^[0-9+\-\s()]+$/')
            ->validationMessages([
                'regex' => 'Телефон может содержать только цифры, пробелы, скобки и +.',
                'max' => 'Телефон не должен превышать 32 символа.',
            ]),

        Forms\Components\TextInput::make('password')
            ->label('Пароль')
            ->password()
            ->dehydrated(fn ($state) => filled($state))
            ->dehydrateStateUsing(fn ($state) => $state ? Hash::make($state) : null)
            ->helperText('Оставьте пустым при редактировании, чтобы не менять пароль.')
            ->minLength(6)
            ->validationMessages([
                'min' => 'Пароль должен содержать минимум 6 символов.',
            ]),

        Forms\Components\Toggle::make('is_admin')
            ->label('Админ'),
    ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Телефон'),
                Tables\Columns\IconColumn::make('is_admin')->boolean()->label('Admin'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
