<?php

use Illuminate\Support\Facades\App;

if (!function_exists('create_firebase_notif')) {
    function create_firebase_notif($fcm_token, $title, $text)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmKey = App::environment(['local', 'staging']) == true ? env('FCM_KEY_DEV') : env('FCM_KEY_PROD');
        $data = [
            "registration_ids" => [$fcm_token],
            "notification" => [
                "title" => $title,
                "body" => $text,
            ],
            "data" => [
                "msgId" => "msg_12342"
            ]
        ];

        $RESPONSE = json_encode($data);

        $headers = [
            'Authorization:key=' . $FcmKey,
            'Content-Type: application/json',
        ];

        // CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);

        $output = curl_exec($ch);
        if ($output === FALSE) {
            die('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
if (!function_exists('create_mass_firebase_notif')) {
    function create_mass_firebase_notif($fcm_tokens, $title, $text)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmKey = App::environment(['local', 'staging']) == true ? env('FCM_KEY_DEV') : env('FCM_KEY_PROD');
        $data = [
            "registration_ids" => $fcm_tokens,
            "notification" => [
                "title" => $title,
                "body" => $text,
            ],
            "data" => [
                "msgId" => "msg_12342"
            ]
        ];

        $RESPONSE = json_encode($data);

        $headers = [
            'Authorization:key=' . $FcmKey,
            'Content-Type: application/json',
        ];

        // CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);

        $output = curl_exec($ch);
        if ($output === FALSE) {
            die('Curl error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
if (!function_exists('get_all_admintokens')) {
    function get_all_admintokens()
    {
        $users = \App\Models\Admin::where('fcm_token', '!=', null)
            ->get();
        $i = 0;
        $tokens = [];
        foreach ($users as $user) {
            $tokens[$i] = $user->fcm_token;
            $i++;
        }
        return $tokens;
    }
}

if (!function_exists('create_short_link')) {
    function create_short_link($link)
    {

        $API_KEY = App::environment(['local', 'staging']) == true ? env('FCM_API_TEST') : env('FCM_API_PROD');;
        $app_package = App::environment(['local', 'staging']) == true ? config('__constant.FCM_PKG_TEST') : config('__constant.FCM_PKG_PROD');
        $intended_link = App::environment(['local', 'staging']) == true ? config('__constant.FCM_URL_TEST') : config('__constant.FCM_URL_PROD');

        $url = 'https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=' . $API_KEY;
        $data = [
            "dynamicLinkInfo" => [
                "domainUriPrefix" => $intended_link,
                "link" => $link,
                "androidInfo" => [
                    "androidPackageName" => $app_package
                ]
            ]
        ];

        $RESPONSE = json_encode($data);

        $headers = [
            'Content-Type: application/json',
        ];

        // CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);

        $output = curl_exec($ch);
        curl_close($ch);
        if ($output === FALSE) {
            die('Curl error: ' . curl_error($ch));
        } else {
            $decoded_out = json_decode($output);
            return $decoded_out->shortLink;
        }
    }
}

if (!function_exists('create_notification_data')) {
    function create_notification_data($user, $jenis, $title, $text)
    {
        return $notification = \App\Models\Notification::create([
            'user_id' => $user,
            'title' => $title,
            'content' => $text,
            'jenis' => $jenis
        ]);
    }
}
