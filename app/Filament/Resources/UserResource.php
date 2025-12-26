<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'المستخدمين';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\FileUpload::make('avatar')->avatar()->label('الصورة'), //
                Forms\Components\TextInput::make('name')->required()->label('الاسم'),
                Forms\Components\TextInput::make('username')->required()->label('اسم المستخدم'), //
                Forms\Components\TextInput::make('email')->email()->required()->label('البريد'), //
                Forms\Components\Toggle::make('is_admin')->label('أدمن'), //
            ])->columns(2),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make('avatar')->circular(),
            Tables\Columns\TextColumn::make('username')->badge(), //
            Tables\Columns\IconColumn::make('is_admin')->boolean(), //
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
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