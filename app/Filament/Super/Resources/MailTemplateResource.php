<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\MailTemplateResource\Pages;
use App\Models\MailTemplate;
use App\Services\MailTemplateService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MailTemplateResource extends Resource
{
    protected static ?string $model = MailTemplate::class;
    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';
    protected static ?string $navigationLabel = 'E-posta Şablonları';
    protected static ?string $modelLabel = 'E-posta Şablonu';
    protected static ?string $pluralModelLabel = 'E-posta Şablonları';
    protected static ?string $navigationGroup = 'Sistem Yönetimi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Şablon Kodu')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->disabled(fn ($record) => $record !== null)
                    ->helperText('Örn: password_reset, welcome_email, test_mail'),
                Forms\Components\TextInput::make('name')
                    ->label('Şablon Adı')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subject')
                    ->label('E-posta Konusu')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->helperText('Dinamik değişkenler: {user_name}, {reset_url}, {user_email}'),
                Forms\Components\RichEditor::make('body')
                    ->label('HTML E-posta Şablon Gövdesi')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Desteklenen Değişkenler: {user_name}, {reset_url}, {login_url}, {user_email}, {test_time}'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Şablon Aktif mi?')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Kod')
                    ->fontFamily('mono')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Şablon Adı')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Konu')
                    ->limit(40),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Durum')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Son Güncelleme')
                    ->dateTime('d.m.Y H:i'),
            ])
            ->actions([
                Tables\Actions\Action::make('sendTestMail')
                    ->label('Test Maili Gönder')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('recipient_email')
                            ->label('Gönderilecek E-posta Adresi')
                            ->email()
                            ->required()
                            ->default(fn () => auth()->user()?->email ?? 'davutakbulut@gmail.com'),
                    ])
                    ->action(function (MailTemplate $record, array $data): void {
                        try {
                            $service = new MailTemplateService();
                            $rendered = $service->render($record->code, [
                                'user_name' => auth()->user()?->name ?? 'Ahmet Yılmaz',
                                'user_email' => $data['recipient_email'],
                                'reset_url' => url('/reset-password/sample-test-token'),
                                'login_url' => url('/login'),
                                'test_time' => now()->format('d.m.Y H:i:s'),
                            ]);

                            $subject = $rendered['subject'] ?? $record->subject;
                            $body = $rendered['body'] ?? $record->body;

                            \Illuminate\Support\Facades\Mail::html($body, function ($message) use ($data, $subject) {
                                $message->to($data['recipient_email'])
                                        ->subject($subject);
                            });

                            Notification::make()
                                ->title('Test E-postası Başarıyla Gönderildi')
                                ->body($data['recipient_email'] . ' adresine test e-postası iletildi. (Spam/Junk klasörünü de kontrol ediniz).')
                                ->success()
                                ->send();
                        } catch (\Throwable $e) {
                            Notification::make()
                                ->title('E-posta Gönderim Hatası')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMailTemplates::route('/'),
            'create' => Pages\CreateMailTemplate::route('/create'),
            'edit' => Pages\EditMailTemplate::route('/{record}/edit'),
        ];
    }
}
