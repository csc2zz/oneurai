<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DatasetResource\Pages;
use App\Models\Dataset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class DatasetResource extends Resource
{
    protected static ?string $model = Dataset::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack'; // أيقونة قواعد البيانات
    protected static ?string $navigationLabel = 'مجموعات البيانات';
    protected static ?string $modelLabel = 'مجموعة بيانات';
    protected static ?string $pluralModelLabel = 'مجموعات البيانات';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('المعلومات الأساسية')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($set, $state) => $set('slug', Str::slug($state)))
                    ->label('عنوان المجموعة'), //
                
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label('الرابط (Slug)'), //

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->label('صاحب البيانات'), //

                Forms\Components\Select::make('visibility')
                    ->options([
                        'public' => 'عام',
                        'private' => 'خاص',
                    ])
                    ->required()
                    ->label('الظهور'), //
            ])->columns(2),

            Forms\Components\Section::make('التفاصيل التقنية')->schema([
                Forms\Components\TextInput::make('task_type')
                    ->placeholder('مثال: Image Classification')
                    ->label('نوع المهمة'), //

                Forms\Components\TextInput::make('license')
                    ->placeholder('مثال: MIT أو CC BY 4.0')
                    ->label('الترخيص'), //

                Forms\Components\Textarea::make('description')
                    ->columnSpanFull()
                    ->label('وصف البيانات'), //
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->label('العنوان'), //

            Tables\Columns\TextColumn::make('user.name')
                ->label('المالك'), //

            Tables\Columns\TextColumn::make('task_type')
                ->badge()
                ->label('المهمة'), //

            Tables\Columns\TextColumn::make('formatted_size')
                ->label('الحجم'), // استخدام الـ Accessor المبرمج في الموديل

            Tables\Columns\TextColumn::make('files_count')
                ->label('الملفات')
                ->numeric(), //

            Tables\Columns\TextColumn::make('formatted_downloads')
                ->label('التحميلات'), // استخدام الـ Accessor المبرمج في الموديل

            Tables\Columns\SelectColumn::make('visibility')
                ->options([
                    'public' => 'عام',
                    'private' => 'خاص',
                ])
                ->label('الحالة'), //
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDatasets::route('/'),
            'create' => Pages\CreateDataset::route('/create'),
            'edit' => Pages\EditDataset::route('/{record}/edit'),
        ];
    }
}