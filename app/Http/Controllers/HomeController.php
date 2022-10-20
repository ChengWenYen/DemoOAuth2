<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isSubscribe = $this->checkNotifyToken($user->notify_access_token);

        return view('home', [
            'user' => $user,
            'is_subscribe' => $isSubscribe
        ]);
    }

    private function checkNotifyToken($accessToken)
    {
        if(is_null($accessToken)) {
            return false;
        }
        $client = new Client(['base_uri' => 'https://notify-api.line.me']);
        try {
            $client->request('Get',
                'api/status',
                [
                    'headers' => [
                        'Authorization' => 'Bearer '.$accessToken
                    ]
                ]);
            return true;
        } catch (RequestException $e) {
            return false;
        }
    }
}
