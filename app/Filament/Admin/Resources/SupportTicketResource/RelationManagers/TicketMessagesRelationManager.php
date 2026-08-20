<?php

namespace App\Filament\Admin\Resources\SupportTicketResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TicketMessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages'; // Assuming 'messages', could be 'ticketMessages'

    protected static ?string $title = 'Mesajlar';
    protected static ?string $modelLabel = 'Mesaj';
    protected static ?string $pluralModelLabel = 'Mesajlar';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('message')
                    ->label('Mesaj')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_staff_reply')
                    ->label('Ekip Yanıtı')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Yazan'),
                Tables\Columns\TextColumn::make('message')
                    ->label('Mesaj')
                    ->limit(100),
                Tables\Columns\IconColumn::make('is_staff_reply')
                    ->label('Ekip Yanıtı')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = Auth::id();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
