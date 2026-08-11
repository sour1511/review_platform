<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class ReCaptcha implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        $secret = config('services.recaptcha.secret');

        // Fail closed outside local when secret is missing
        if (empty($secret)) {
            return app()->environment('local');
        }

        if (empty($value)) {
            return false;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $value,
        ]);

        return (bool) data_get($response->json(), 'success', false);
    }

    public function message()
    {
        return 'The google recaptcha is required.';
    }
}
