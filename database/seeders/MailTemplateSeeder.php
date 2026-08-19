<?php

namespace Database\Seeders;

use App\Models\MailTemplate;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'code' => 'password_reset',
                'name' => 'Şifre Sıfırlama E-postası',
                'subject' => 'DVT Bank CRM — Şifre Sıfırlama Talebi',
                'body' => '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8fafc; border-radius: 12px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h2 style="color: #4f46e5; margin: 0;">DVT Bank CRM</h2>
                    </div>
                    <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h3 style="color: #1e293b; margin-top: 0;">Merhaba {user_name},</h3>
                        <p style="color: #475569; font-size: 14px; line-height: 1.6;">DVT Bank CRM hesabınız için şifre sıfırlama talebi aldık. Şifrenizi yenilemek için aşağıdaki butona tıklayabilirsiniz:</p>
                        <div style="text-align: center; margin: 30px 0;">
                            <a href="{reset_url}" style="background-color: #4f46e5; color: #ffffff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">Şifrenizi Sıfırlayın</a>
                        </div>
                        <p style="color: #64748b; font-size: 12px; line-height: 1.5;">Bu bağlantı 60 dakika süreyle geçerlidir. Eğer şifre sıfırlama talebinde bulunmadıysanız bu e-postayı dikkate almayabilirsiniz. Hesabınız güvendedir.</p>
                    </div>
                    <div style="text-align: center; margin-top: 20px; color: #94a3b8; font-size: 11px;">
                        &copy; ' . date('Y') . ' DVT Bank CRM. Tüm hakları saklıdır.
                    </div>
                </div>',
                'is_active' => true,
            ],
            [
                'code' => 'welcome_email',
                'name' => 'Hoş Geldin E-postası',
                'subject' => 'DVT Bank CRM’e Hoş Geldiniz!',
                'body' => '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8fafc; border-radius: 12px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h2 style="color: #4f46e5; margin: 0;">DVT Bank CRM</h2>
                    </div>
                    <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h3 style="color: #1e293b; margin-top: 0;">Aramıza Hoş Geldiniz, {user_name}!</h3>
                        <p style="color: #475569; font-size: 14px; line-height: 1.6;">DVT Bank CRM ailesine katıldığınız için teşekkür ederiz. Borçlarınızı kontrol altına almak, ödeme planlarınızı ve AI finansal koçunuzu kullanmak için hemen giriş yapabilirsiniz.</p>
                        <div style="text-align: center; margin: 30px 0;">
                            <a href="{login_url}" style="background-color: #4f46e5; color: #ffffff; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">Hemen Panele Giriş Yapın</a>
                        </div>
                    </div>
                </div>',
                'is_active' => true,
            ],
            [
                'code' => 'test_mail',
                'name' => 'Sistem Test E-postası',
                'subject' => 'DVT Bank CRM — Sistem Test E-postası',
                'body' => '<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f8fafc; border-radius: 12px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h2 style="color: #4f46e5; margin: 0;">DVT Bank CRM</h2>
                    </div>
                    <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h3 style="color: #16a34a; margin-top: 0;">✅ SMTP Mail Testi Başarılı!</h3>
                        <p style="color: #475569; font-size: 14px; line-height: 1.6;">Bu e-posta DVT Bank CRM Yönetim Paneli üzerinden <strong>{user_email}</strong> adresine gönderilen canlı test mesajıdır.</p>
                        <p style="color: #64748b; font-size: 12px;">Gönderim Tarihi: {test_time}</p>
                    </div>
                </div>',
                'is_active' => true,
            ],
        ];

        foreach ($templates as $tmpl) {
            MailTemplate::updateOrCreate(['code' => $tmpl['code']], $tmpl);
        }
    }
}
