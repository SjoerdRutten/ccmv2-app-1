<?php

namespace Sellvation\CCMV2\Stripo\Facades;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Stripo
{
    public function getToken()
    {
        if (Cache::has('stripo_token')) {
            return Cache::get('stripo_token');
        }

        $response = Http::asJson()
            ->post('https://plugins.stripo.email/api/v1/auth', [
                'pluginId' => config('stripo.plugin_id'),
                'secretKey' => config('stripo.secret_key'),
            ]);

        if ($response->ok()) {
            Cache::add('stripo_token', $response->json('token'), now()->addMinutes(10));

            return $response->json('token');
        }
        throw new \Exception('Unable to retrieve token');
    }

    public function compileTemplate(string $html, string $css)
    {
        $token = $this->getToken();

        $response = Http::asJson()
            ->withHeader('ES-PLUGIN-AUTH', 'Bearer '.$token)
            ->post('https://plugins.stripo.email/api/v1/cleaner/v1/compress', [
                'html' => $html,
                'css' => $css,
                'minimize' => 1,
            ]);

        return $response->json('html');

    }
}
