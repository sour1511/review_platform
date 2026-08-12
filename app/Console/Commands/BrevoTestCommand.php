<?php

namespace App\Console\Commands;

use App\Http\Controllers\FrontendController;
use Illuminate\Console\Command;

class BrevoTestCommand extends Command
{
    protected $signature = 'brevo:test {email : Recipient email address}';

    protected $description = 'Diagnose Brevo config and send a test email';

    public function handle()
    {
        $email = $this->argument('email');
        $key = trim((string) config('services.brevo.key'));
        $from = (string) config('services.brevo.from_address');
        $smtpUser = (string) config('services.brevo.smtp_user');

        $this->line('APP_ENV: ' . config('app.env'));
        $this->line('MAIL_FROM_ADDRESS: ' . ($from !== '' ? $from : '(empty)'));
        $this->line('BREVO_SMTP_USER: ' . ($smtpUser !== '' ? $smtpUser : '(empty)'));
        $this->line('BREVO_API_KEY set: ' . ($key !== '' ? 'yes' : 'NO'));
        $this->line('BREVO_API_KEY prefix: ' . ($key !== '' ? substr($key, 0, 10) . '...' : '(none)'));
        $this->line('curl extension: ' . (extension_loaded('curl') ? 'yes' : 'NO'));

        if ($key === '') {
            $this->error('BREVO_API_KEY is empty. Update server .env and run: php artisan config:clear');
            return 1;
        }

        if (!str_starts_with($key, 'xkeysib-') && !str_starts_with($key, 'xsmtpsib-')) {
            $this->error('BREVO_API_KEY must start with xkeysib- or xsmtpsib-');
            return 1;
        }

        // Account ping for API keys
        if (str_starts_with($key, 'xkeysib-')) {
            $ch = curl_init('https://api.brevo.com/v3/account');
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'accept: application/json',
                    'api-key: ' . $key,
                ],
                CURLOPT_TIMEOUT => 30,
            ]);
            $body = curl_exec($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            curl_close($ch);

            $this->line('Account API HTTP: ' . $code);
            if ($err) {
                $this->error('curl error: ' . $err);
            }
            if ($code !== 200) {
                $this->error('Account check failed: ' . substr((string) $body, 0, 300));
                $this->error('Fix the API key in .env, then: php artisan config:clear');
                return 1;
            }
            $this->info('API key is valid.');
        }

        /** @var FrontendController $controller */
        $controller = app(FrontendController::class);
        $ok = $controller->activationMailSend([
            'to' => [['email' => $email, 'name' => 'Brevo Test']],
            'templateId' => 3,
            'params' => [
                'name' => 'Brevo Test',
                'link' => url('/user/login'),
                'sub_msg1' => 'This is a Brevo connectivity test from the server.',
            ],
        ]);

        if ($ok) {
            $this->info('Test email sent to ' . $email . '. Check inbox and Brevo Transactional logs.');
            return 0;
        }

        $this->error('Send failed: ' . ($controller->getLastMailError() ?: 'unknown error'));
        $this->error('Also check storage/logs/laravel.log');
        return 1;
    }
}
