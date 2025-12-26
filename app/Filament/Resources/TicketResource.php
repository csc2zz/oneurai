<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages; 
use App\Models\Ticket;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'تذاكر الدعم';
    protected static ?string $modelLabel = 'تذكرة';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')->label('اسم المرسل')->disabled(),
                    Forms\Components\TextInput::make('email')->label('البريد')->disabled(),
                    Forms\Components\TextInput::make('subject')->label('الموضوع')->columnSpanFull(),
                    Forms\Components\Textarea::make('message')->label('نص الرسالة')->disabled()->columnSpanFull(),
                    Forms\Components\Select::make('status')
                        ->label('حالة التذكرة')
                        ->options([
                            'open' => 'مفتوحة',
                            'closed' => 'مغلقة',
                        ])->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('المرسل')->searchable(),
                Tables\Columns\TextColumn::make('subject')->label('الموضوع')->limit(30),
                Tables\Columns\SelectColumn::make('status')
                    ->label('الحالة')
                    ->options([
                        'open' => 'مفتوحة',
                        'closed' => 'مغلقة',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإرسال')->since(),
            ]);
    }
        public static function getPages(): array
{
    return [
        'index' => Pages\ListTickets::route('/'),
        'create' => Pages\CreateTicket::route('/create'),
        'edit' => Pages\EditTicket::route('/{record}/edit'),
    ];
}
}