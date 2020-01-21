<?php

namespace App\Http\Controllers;

use App\Service\TokenService;
use App\Http\Controllers\Controller;
use App\Mail\RegistrationInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
{
    public function sendMessage(Request $request)
    {
        $tokenService = new TokenService();

        $token = $tokenService->generateToken($request->data);

        Mail::to($request->email)->send(new RegistrationInvite($token, $request->data['email'], $request->data['password']));
    }

    public function parse(Request $request)
    {
        $tokenService = new TokenService();
        
        $data = $tokenService->parseToken($request->token);

        return $data;
    }

    //in dev
    // public function ship(Request $request)
    // {
    //     $tokenService = new TokenService();

    //     $token = $tokenService->generateToken($request->data);

    //     Mail::to($request->email)->send(new RegistrationInvite($token));
    // }

    // public function getData(Request $request)
    // {
    //     $tokenService = new TokenService();

    //     $token = $tokenService.parseToken($request->data);

    //     $data = [$token->email, $token->inn, $token->kpp];

    //     return $data;
    // }
}
