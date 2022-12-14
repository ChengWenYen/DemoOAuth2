<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OAuthController extends Controller
{
    public function show()
    {
        if(Auth::check()) {
            return redirect(route('home'));
        } else {
            return view('login');
        }
    }

    public function googleLoginCallback(Request $request)
    {
        $code = $request['code'];
        $state = $request['state'];
        $client = new Client(['base_uri' => 'https://oauth2.googleapis.com']);
        $response = $client->request('POST',
            '/token',
            [
                'form_params' => [
                    'client_id' => env('GOOGLE_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => env('APP_HTTPS_URL')."/oauth/member/v2/google/login/callback"
                ]
            ]);
        
        $responseData = json_decode($response->getBody());
        $accessToken = $responseData->access_token;
        $tokenType = $responseData->token_type;
        $expiresIn = $responseData->expires_in;
        $scope = $responseData->scope;
        $idToken = $responseData->id_token;

        $userData = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $idToken)[1]))));

        $user = User::where('guid', '=', $userData->sub)
                ->where('channel', '=', 'google')
                ->first();
        
        if(is_null($user)) {
            $user = User::create([
                'guid' => $userData->sub,
                'channel' => 'google',
                'name' => $userData->name,
                'picture' => $userData->picture,
                'email' => $userData->email,
                'raw_id_token' => $idToken,
                'access_token' => $accessToken,
                'token_type' => $tokenType,
                'expires_in' => $expiresIn,
                'scope' => $scope,
                'password' => bcrypt('empty')
            ]);
            Log::info($user);
        } else {
            $user->update([
                'name' => $userData->name,
                'picture' => $userData->picture,
                'email' => $userData->email,
                'access_token' => $accessToken,
                'token_type' => $tokenType,
                'expires_in' => $expiresIn,
                'scope' => $scope,
                'raw_id_token' => $idToken,
            ]);
        }

        Auth::attempt(['guid' => $userData->sub, 'channel' => 'google', 'password' => 'empty']);
        return redirect(route('home'));
    }

    public function lineLoginCallback(Request $request)
    {
        $code = $request['code'];
        $state = $request['state'];
        
        $client = new Client(['base_uri' => 'https://api.line.me']);
        $response = $client->request('POST',
            '/oauth2/v2.1/token',
            [
                'form_params' => [
                    'client_id' => env('LINE_CLIENT_ID'),
                    'client_secret' => env('LINE_CLIENT_SECRET'),
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => env('APP_URL')."/oauth/member/v2/line/login/callback"
                ]
            ]);

        $responseData = json_decode($response->getBody());
        $accessToken = $responseData->access_token;
        $tokenType = $responseData->token_type;
        $refreshToken = $responseData->refresh_token;
        $expiresIn = $responseData->expires_in;
        $scope = $responseData->scope;
        $idToken = $responseData->id_token;

        $userData = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $idToken)[1]))));
        
        $user = User::where('guid', '=', $userData->sub)
                ->where('channel', '=', 'line')
                ->first();

        if(is_null($user)) {
            User::create([
                'guid' => $userData->sub,
                'channel' => 'line',
                'name' => $userData->name,
                'picture' => $userData->picture,
                'email' => $userData->email,
                'raw_id_token' => $idToken,
                'access_token' => $accessToken,
                'token_type' => $tokenType,
                'refresh_token' => $refreshToken,
                'expires_in' => $expiresIn,
                'scope' => $scope,
                'password' => bcrypt('empty')
            ]);
        } else {
            $user->update([
                'name' => $userData->name,
                'picture' => $userData->picture,
                'email' => $userData->email,
                'access_token' => $accessToken,
                'token_type' => $tokenType,
                'refresh_token' => $refreshToken,
                'expires_in' => $expiresIn,
                'scope' => $scope,
                'raw_id_token' => $idToken,
            ]);
        }

        Auth::attempt(['guid' => $userData->sub, 'channel' => 'line', 'password' => 'empty']);
        return redirect(route('home'));
    }

    public function lineNotifyLoginCallback(Request $request)
    {
        $code = $request['code'];
        $state = $request['state'];

        $client = new Client(['base_uri' => 'https://notify-bot.line.me']);
        $response = $client->request('POST',
            '/oauth/token',
            [
                'form_params' => [
                    'client_id' => env('LINE_NOTIFY_CLIENT_ID'),
                    'client_secret' => env('LINE_NOTIFY_CLIENT_SECRET'),
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => env('APP_URL')."/oauth/member/v2/line/notify/login/callback"
                ]
            ]);
        
        $responseData = json_decode($response->getBody());
        $accessToken = $responseData->access_token;
        
        $user = Auth::user();
        $user->update([
            'notify_access_token' => $accessToken
        ]);

        return redirect(route('home'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
