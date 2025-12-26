<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Toggle;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'المقالات';
    protected static ?string $modelLabel = 'مقال';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('محتوى المقال')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('عنوان المقال')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->label('رابط المقال (Slug)')
                            ->required()
                            ->unique(Post::class, 'slug', ignoreRecord: true),

                        Forms\Components\Select::make('category')
                            ->label('التصنيف')
                            ->options([
                                'أخبار' => 'أخبار التقنية',
                                'برمجة' => 'دروس برمجية',
                                'ذكاء اصطناعي' => 'ذكاء اصطناعي',
                            ])->required(),

                        Forms\Components\FileUpload::make('image')
                            ->label('صورة الغلاف')
                            ->image()
                            ->directory('blog-images'),

                        Forms\Components\RichEditor::make('content')
                            ->label('المحتوى البرمجي')
                            ->required()
                            ->columnSpanFull(),
                            
                            Toggle::make('show_signature')
                ->label('إظهار التوقيع الرقمي (NOS & MTMA)')
                ->helperText('تفعيل هذا الخيار سيظهر توقيع المؤسسين في نهاية المقال')
                ->onColor('success')
                ->default(false),
                            
                        Forms\Components\Toggle::make('is_published')
                            ->label('حالة النشر')
                            ->default(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('الصورة'),
                Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category')->label('التصنيف')->badge(),
                Tables\Columns\IconColumn::make('is_published')->label('منشور')->boolean(),
                Tables\Columns\TextColumn::make('views')->label('المشاهدات')->badge()->color('success'),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ النشر')->dateTime('Y-m-d'),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
{
    return [
        'index' => Pages\ListPosts::route('/'),
        'create' => Pages\CreatePost::route('/create'),
        'edit' => Pages\EditPost::route('/{record}/edit'),
    ];
}
}