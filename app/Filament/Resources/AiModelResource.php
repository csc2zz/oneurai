<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiModelResource\Pages;
use App\Models\AiModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AiModelResource extends Resource
{
    protected static ?string $model = AiModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationLabel = 'نماذج AI';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required()->label('اسم النموذج'), //
            Forms\Components\TextInput::make('task')->label('المهمة (Task)'), //
            Forms\Components\TextInput::make('framework')->label('الإطار (Framework)'), //
            Forms\Components\TextInput::make('language')->label('اللغة'), //
            Forms\Components\TextInput::make('version')->label('الإصدار'), //
            Forms\Components\Toggle::make('is_public')->label('علني'), //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('النموذج'), //
            Tables\Columns\TextColumn::make('framework')->badge()->label('الإطار'), //
            Tables\Columns\TextColumn::make('downloads_count')->label('التحميلات')->sortable(), //
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiModels::route('/'),
            'create' => Pages\CreateAiModel::route('/create'),
            'edit' => Pages\EditAiModel::route('/{record}/edit'),
        ];
    }
}