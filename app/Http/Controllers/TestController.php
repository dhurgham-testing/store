<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->header('token');
        $redirect = $request->input('redirect');
        $mr_id = $request->header('mr_id');
        Log::info('Request Data', [
            'mr_id' => $mr_id,
            'redirect' => $redirect,
            'token' => $token,
        ]);

        return redirect($redirect);
    }
}
