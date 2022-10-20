<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\LineNotification;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = LineNotification::orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admins.notifications.index', [
            'notifications' => $notifications
        ]);
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();
        if(!$currentUser->is_admin) {
            abort(404);
        }

        $message = $request["message"];

        $notification = LineNotification::create([
            'message' => $message,
            'sender_id' => $currentUser->id
        ]);

        $users = User::whereNotNull('notify_access_token')->get();
        foreach($users as $user) {
            if($this->sendNotify($user->notify_access_token, $message)) {
                $notification->recipients()->create([
                    'recipient_id' => $user->id
                ]);
            }
        }

        return redirect(route('admin.notify.index'));
    }

    private function sendNotify($token, $message)
    {
        try {
            $client = new Client(['base_uri' => 'https://notify-api.line.me']);
            $response = $client->request('POST',
                '/api/notify',
                [
                    'headers' => [
                        'Authorization' => 'Bearer '.$token
                    ],
                    'form_params' => [
                        'message' => $message
                    ]
                ]);
            return true;
        } catch (RequestException $e) {
            return false;
        }
    }
}
