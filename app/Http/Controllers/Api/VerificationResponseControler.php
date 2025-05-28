<?php

namespace App\Http\Controllers\Api;

use App\Database\BD;
use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use Request;

class VerificationResponseControler extends Controller
{

    public function verifyEmail(Request $request, string $token)
    {
        $verification = BD::getFirstRow("email_verifications", "*", ["token" => $token]);

        if (!$verification) {
            return Controller::responseMessage(false, "Token de verificación inválido.", [], 400);
        }

        $email = $verification['email'];
        $expires_at = new DateTime($verification['expires_at']);

        if ($expires_at < new DateTime()) {
            BD::DeleteFromTable("email_verifications", "token", $token);
            return Controller::responseMessage(false, "El token de verificación ha expirado.", [], 410);
        }

        $name = $verification['name'];
        $password = $verification['password'];

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];

        User::createNewUser($userData, false);

        BD::DeleteFromTable("email_verifications", "token", $token);

        return view('email_verified');
    }
}
