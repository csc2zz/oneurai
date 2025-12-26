<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class OnlineUsersTable extends BaseWidget
{
    // عرض الجدول في صف كامل أسفل الإحصائيات
    protected int | string | array $columnSpan = 'full';

    // تسمية الجدول
    protected static ?string $heading = 'المستخدمون المتصلون الآن';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // جلب المستخدمين الذين لديهم نشاط في آخر 5 دقائق بناءً على منطق موديل User
                User::query()
                    ->whereIn('id', function ($query) {
                        $query->select('user_id')
                            ->from('sessions')
                            ->where('last_activity', '>', now()->subMinutes(5)->getTimestamp())
                            ->whereNotNull('user_id');
                    })
            )
            ->columns([
                // صورة المستخدم (Avatar)
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('الصورة')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF'),

                // اسم المستخدم وبريده
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->description(fn (User $record): string => $record->email),

                // اسم المستخدم (Username)
                Tables\Columns\TextColumn::make('username')
                    ->label('اسم المستخدم')
                    ->badge()
                    ->color('gray'),

                // حالة الاتصال (دائماً متصل هنا لأننا نفلترهم)
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->default('متصل الآن')
                    ->badge()
                    ->color('success'),

                // آخر ظهور باستخدام الخاصية الموجودة في الموديل
                Tables\Columns\TextColumn::make('last_seen')
                    ->label('آخر نشاط')
                    ->dateTime('H:i:s')
                    ->description('توقيت السيرفر'),
            ])
            ->actions([
                // زر سريع للانتقال لملف المستخدم في لوحة التحكم
                Tables\Actions\Action::make('view')
                    ->label('عرض الملف')
                    ->icon('heroicon-m-eye')
                    ->url(fn (User $record): string => "/admin/users/{$record->id}/edit"),
            ]);
    }
}