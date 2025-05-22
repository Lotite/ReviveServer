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
            'currentPassword.required' => 'La contraseña actual es obligatoria.',
            'newPassword.required' => 'La nueva contraseña es obligatoria.',
            'newPassword.min' => 'La nueva contraseña debe tener al menos 6 caracteres.',
            'confirmPassword.required' => 'La confirmación de la nueva contraseña es obligatoria.',
            'confirmPassword.same' => 'La confirmación de la nueva contraseña no coincide.',
            'currentPassword.incorrect' => 'La contraseña actual es incorrecta.',
        ];

        $rules = [];
        switch ($action) {
            case 'register':
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
                break;
            case 'login':
                $rules = [
                    'email' => 'required|email',
                    'password' => 'required|string|min:6'
                ];
                break;
            case 'updateUser':
                $rules = [
                    'name' => 'sometimes|string|max:255',
                    'email' => [
                        'sometimes',
                        'email',
                        function ($attribute, $value, $fail) {
                            if ($value != "" && User::getByEmail($value)) {
                                $fail('El correo electrónico ya está registrado.');
                            }
                        }
                    ],
                ];
                break;
            case 'changePassword':
                $rules = [
                    'currentPassword' => 'required|string',
                    'newPassword' => 'required|string|min:6',
                    'confirmPassword' => 'required|string|same:newPassword',
                ];
                break;
            default:
                $rules = [];
                break;
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
                return Controller::responseMessage(false, 'Sesion denegada');
            $userId = Device::getUser($token);
            $user = User::getUser($userId);
            $message = 'No se encuenta el dispositivo en la sesion';
            if ($user) {
                $message = 'Sesion aceptada';
                $session = [
                    "name" => $user->getName(),
                    "email" => $user->getEmail(),
                    "device" => Device::getByToken($token)->getId(),
                ];
            }
            return Controller::responseMessage($user != null, $message, session: $session);
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

    public function updateUser(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $validator = $this->getValidator($request, 'updateUser');


            if (!$request->has('name') && !$request->has('email')) {
                return Controller::responseMessage(false, "Error en validar los datos", ['name' => 'No pueden estar los dos campos vacios', 'email' => ''], 422);
            }

            if ($validator->fails()) {
                $errorMessages = $this->errorMessages($validator);
                return Controller::responseMessage(false, "Error en validar los datos", $errorMessages, 422);
            }

            $deviceToken = DataManager::getData("device");
            $userId = Device::getUser($deviceToken);
            $user = User::getUser($userId);

            if (!$user) {
                return Controller::responseMessage(false, "Usuario no encontrado", [], 404);
            }


            if ($request->has('name')) {
                $user->setName($request->input('name'));
            }
            if ($request->has('email')) {
                $user->setEmail($request->input('email'));
            }

            return Controller::responseMessage(true, "Usuario actualizado correctamente");
        });
    }

    public function changePassword(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $validator = $this->getValidator($request, 'changePassword');

            if ($validator->fails()) {
                $errorMessages = $this->errorMessages($validator);
                return Controller::responseMessage(false, "Error en validar los datos", $errorMessages, 422);
            }

            $deviceToken = DataManager::getData("device");
            $userId = Device::getUser($deviceToken);
            $user = User::getUser($userId);

            if (!$user) {
                return Controller::responseMessage(false, "Usuario no encontrado", [], 404);
            }

            if (!password_verify($request->input('currentPassword'), $user->getPassword())) {
                $errorMessages = ["currentPassword" => "La contraseña actual es incorrecta", "newPassword" => "", "confirmPassword" => ""];
                return Controller::responseMessage(false, "La contraseña actual es incorrecta", $errorMessages, 403);
            }

            $user->setPassword($request->input('newPassword'));


            $currentToken = DataManager::getData("device");
            if ($request->input('keepSessions') == false) {
                $data = Device::deleteAllExcept($userId, $currentToken);
            }

            return Controller::responseMessage(true, "Contraseña actualizada correctamente", ["data" => $currentToken]);
        });
    }


    public function getUserDevices(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $deviceToken = DataManager::getData("device");
            $userId = Device::getUser($deviceToken);
            if ($userId === null) {
                return Controller::responseMessage(false, "Usuario no autenticado", [], 401);
            }

            $devices = Device::getDevicesByUserId($userId);
            $devicesArray = array_map(function ($device) {
                return [
                    'device_name' => $device->getDeviceType(),
                    'last_active_timestamp' => $device->getLastActiveTimestamp(),
                    'id' => $device->getId(),
                    'register_at' => $device->getRegisterAt(),
                ];
            }, $devices);

            return Controller::responseMessage(true, "Dispositivos obtenidos correctamente", $devicesArray);
        });
    }

    public function deleteDevice(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $deviceToken = DataManager::getData("device");
            $userId = Device::getUser($deviceToken);
            if ($userId === null) {
                return Controller::responseMessage(false, "Usuario no autenticado", [], 401);
            }

            $deviceId = $request->input('id');
            if (Device::deleteDevice($userId, $deviceId)) {
                return Controller::responseMessage(true, "Dispositivo eliminado correctamente");
            } else {
                return Controller::responseMessage(false, "Error al eliminar el dispositivo", [], 500);
            }
        });
    }

    public function deleteOtherDevices(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $deviceToken = DataManager::getData("device");
            $userId = Device::getUser($deviceToken);
            if ($userId === null) {
                return Controller::responseMessage(false, "Usuario no autenticado", [], 401);
            }

            $result = Device::deleteAllExcept($userId, $deviceToken);
            if ($result) {
                return Controller::responseMessage(true, "Dispositivos eliminados excepto el actual");
            } else {
                return Controller::responseMessage(false, "Error al eliminar dispositivos", [], 500);
            }
        });
    }

    public function deleteUser(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $deviceToken = DataManager::getData("device");
            $userId = Device::getUser($deviceToken);
            if ($userId === null) {
                return Controller::responseMessage(false, "Usuario no autenticado", [], 401);
            }


            $user = User::getUser($userId);
            if (!$user) {
                return Controller::responseMessage(false, "Usuario no encontrado", [], 404);
            }
            Device::deleteAllExcept($userId, '');
            $deleteUserResult = User::deleteUserById($userId);
            if ($deleteUserResult !== true) {
                return Controller::responseMessage(false, "Error al eliminar la cuenta de usuario", [$deleteUserResult], 500);
            }


           

            return Controller::responseMessage(true, "Cuenta de usuario y dispositivos asociados eliminados correctamente");
        });
    }

    public function logout(Request $request)
    {
        return Controller::ControlerException($request, function () use ($request) {
            $deviceToken = DataManager::getData("device");
            $userId = Device::getUser($deviceToken);
            if ($userId === null) {
                return Controller::responseMessage(false, "Usuario no autenticado", [], 401);
            }

            $device = Device::getByToken($deviceToken);
            if (!$device) {
                return Controller::responseMessage(false, "Dispositivo no encontrado", [], 404);
            }

            $deleted = Device::deleteDevice($userId, $device->getId());
            if ($deleted) {

                DataManager::removeAllSessionData();
                DataManager::removeAllCookies();
                return Controller::responseMessage(true, "Sesión cerrada correctamente");
            } else {
                return Controller::responseMessage(false, "Error al cerrar la sesión", [], 500);
            }
        });
    }
}
