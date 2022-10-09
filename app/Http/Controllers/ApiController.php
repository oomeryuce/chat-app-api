<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function getRequest(\Illuminate\Http\Request $request, $language=null)
    {
        $header = $request->header('Accept-Language');

        app()->setLocale('en');

        if ($header == 'tr-TR') {
            app()->setLocale('tr');
        } elseif ($header == 'en-EN') {
            app()->setLocale('en');
        }

        if ($language != null && $language == 'tr-TR'){
            app()->setLocale('tr');
        } elseif ($language != null && $language == 'en-EN') {
            app()->setLocale('en');
        }

        return app()->getLocale();
    }

    public function ApiCreator($data, $error = false)
    {
        $header = app()->call('App\Http\Controllers\ApiController@getRequest');

        if ($error == true) {
            $veri = array(
                'hasError' => true,
                'errorMessage' => $data,
            );
            return response()->json($veri, 417);
        }

        $status_code = http_response_code();

        if ($status_code == 200) {
            $veri = array(
                'data' => $data,
                'hasError' => false
            );
            return response()->json($veri);
        } else {
            $veri = array(
                'hasError' => true,
                'errorCode' => $status_code,
                'errorMessage' => __('apiMessages.unknown')
            );
            return response()->json($veri, $status_code);
        }

    }
}
