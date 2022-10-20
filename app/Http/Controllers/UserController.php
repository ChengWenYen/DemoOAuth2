<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $isSubscribe = filter_var($request['subscribe'], FILTER_VALIDATE_BOOLEAN);
        if(!$isSubscribe) {
            $client = new Client(['base_uri' => 'https://notify-api.line.me']);
            $response = $client->request('POST',
                '/api/revoke',
                [
                    'headers' => [
                        'Authorization' => 'Bearer '.$user->notify_access_token
                    ]
                ]);
            $user->update([
                'notify_access_token' => null
            ]);
        }
        
        return redirect(route('home'))->with('message', 'success');
    }
}
