<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'المشاريع';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title') //
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state)))
                ->label('عنوان المشروع'),
            Forms\Components\TextInput::make('slug')->required()->label('الرابط (Slug)'), //
            Forms\Components\Select::make('user_id') //
                ->relationship('user', 'name')
                ->searchable()
                ->required()
                ->label('صاحب المشروع'),
            Forms\Components\Toggle::make('is_public')->label('عام'), //
            Forms\Components\Toggle::make('is_pinned')->label('تثبيت'), //
            Forms\Components\TagsInput::make('tags')->label('الوسوم'), //
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->label('المشروع'), //
            Tables\Columns\TextColumn::make('user.name')->label('المالك'), //
            Tables\Columns\IconColumn::make('is_public')->boolean()->label('عام'), //
            Tables\Columns\TextColumn::make('stars_count')->counts('stars')->label('النجوم'), //
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}