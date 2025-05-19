<?php

namespace App\Http\Controllers\Api;

use App\Database\BD;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use DataManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class AuthControler extends Controller
{

    public function verificar()
    {

    }


    // public function firstUser(Request $request)
    // {
    //     return Controller::ControlerException($request, function () {
    //         $user = BD::$Users->firstOrNull();
    //         return Controller::responseMessage(true, 'Success', ["user", $user], 200);
    //     });
    // }




    private function getValidator(Request $request, string $action)
    {
        $messages = [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'passwordConfirm.required' => 'La confirmación de la contraseña es obligatoria.',
            'passwordConfirm.same' => 'La confirmación de la contraseña no coincide con la contraseña.',
            'terms.required' => 'Debe aceptar los términos y condiciones.',
            'terms.accepted' => 'Debe aceptar los términos y condiciones.',
            'terms.boolean' => 'El valor de los términos debe ser verdadero o falso.',
        ];

        $rules = [];
        if ($action === 'register') {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) {
                        if (User::getByEmail($value)) {
                            $fail('El correo electrónico ya está registrado.');
                        }
                    }
                ],
                'password' => 'required|string|min:6',
                'passwordConfirm' => 'required|same:password',
                'terms' => 'required|accepted|boolean'
            ];
        } elseif ($action === 'login') {
            $rules = [
                'email' => 'required|email',
                'password' => 'required|string|min:6'
            ];
        }

        return Validator::make($request->all(), $rules, $messages);
    }

    public function register(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $validator = $this->getValidator($request, 'register');
            if ($validator->fails()) {
                $errorMessages = $this->errorMessages($validator);
                return Controller::responseMessage(false, "Error en validar los datos", $errorMessages, 422);
            }
            $data = [
                'name' => $request->input("name"),
                'email' => $request->input("email"),
                'password' => $request->input("password")
            ];
            User::createNewUser($data);

            return Controller::responseMessage(true, 'Registro exitoso');
        });
    }

    public function login(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $validator = $this->getValidator($request, 'login');
            if ($validator->fails()) {
                $errorMessages = $this->errorMessages($validator);
                return Controller::responseMessage(false, "Error en validar los datos", $errorMessages, 422);
            }
            $user = User::loginUser($request->input("email"), $request->input("password"));
            if ($user == null) {
                return Controller::responseMessage(false, 'Login fallido', ["email" => "No existe un usuario con esos credenciales."], 200);
            }

            $device = new Device(user_id: $user->id, device_name: Controller::getNameDevice($request));
            Device::createNewDevice($device);
            DataManager::setSessionData("device", $device->getToken());

            if ($request->input("remember") == "true") {
                DataManager::addCookie("device", $device->getToken());
            }

            return Controller::responseMessage(true, 'Login exitoso', DataManager::getSessionData("device"));
        });
    }

    public function validateSession(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            DataManager::initialize($request);

            $token = DataManager::getData("device");
            if ($token == null)
                return Controller::responseMessage(false, 'No hay dispositivo asociado a la sesión');
            $userId = Device::getUser($token);
            $exist = User::ExistsUserId($userId);
            return Controller::responseMessage($exist, 'Validacion', $token);
        });
    }


    private function errorMessages($validator)
    {
        $errors = $validator->errors()->toArray();
        $errorMessages = [];
        foreach ($errors as $field => $messages) {
            $errorMessages[$field] = implode(' ', $messages);
        }
        return $errorMessages;
    }


}
