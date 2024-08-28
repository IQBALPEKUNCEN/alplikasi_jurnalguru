<?php

namespace api\controllers;

use api\controllers\base\Controller;
use app\models\base\TokenSession;
use app\models\base\User;
use Firebase\JWT\JWT;
use Yiisoft\Validator\Rule\Required;
use Yiisoft\Validator\Rule\Ip;
use Yiisoft\Validator\Validator;
use api\middleware\JwtMiddleware;

class AuthController extends Controller
{
    public function _register()
    {
        $this->route->post('/login', function () {
            $request = $this->app->request()->data->jsonSerialize();

            $rules = [
                'username' => new Required(),
                'password' => [
                    new Required(),
                    // new Number(),
                    // new Length(min: 6), // php 8
                ],
                'device_id' => new Required(),
                'ip_address' => [
                    new Required(),
                    new Ip()
                ],
                'app_version' => new Required(),
                'app_name' => new Required(),
                'app_package' => new Required(),
            ];

            $result = (new Validator())->validate($request, $rules);

            if (!$result->isValid()) {
                return $this->app->json([
                    "message" => "Error pada form login.",
                    "errors" => $this->app->convertMessages($result->getErrorMessagesIndexedByAttribute())
                ], 400); // bad request
            }

            // cari data user by username nya
            $user = User::findByUsername($request['username']);

            // cek username ada apa ngga
            if (!$user) {
                return $this->app->json([
                    "message" => "Login gagal, periksa kembali error yang tampil.",
                    "errors" => [
                        "username" => "Username tidak ditemukan."
                    ]
                ], 400);
            }

            // cek password bener apa ngga
            if (!$user->validatePassword($request['password'])) {
                return $this->app->json([
                    "message" => "Login gagal, periksa kembali error yang tampil.",
                    "errors" => [
                        "password" => "Password salah."
                    ]
                ], 400);
            }

            // proses login dapetin jwt
            $payload = [
                'sub' => $user->username, // subject whom the token refers to
                'name' => $user->username,
                'iat' => time(),
                'exp' => time() + (45 * 60), // expired time 45 minutes
            ];

            $jwt = JWT::encode($payload, JWTKEY, 'HS256');

            // save token ke database, untuk menggunakan sesi per request
            TokenSession::updateSession($jwt);

            return $this->app->json([
                "message" => "Login berhasil.",
                "access_token" => $jwt,
            ]);
        });

        $this->route->post('/change-password', function () {
            $request = $this->app->request()->data->jsonSerialize();

            $decoded = $this->app->get('jwt_decoded');
            $username = $decoded->sub;

            $rules = [
                'old_password' => new Required(),
                'password' => new Required(),
                'repeat_password' => [
                    new Required(),
                    // new Equal($request['password'], type: CompareType::STRING)
                    // new Equal(targetAttribute: 'password', type: CompareType::STRING) // php 8
                ],
            ];

            $result = (new Validator())->validate($request, $rules);

            // validasi pertama berdasarkan rule
            if (!$result->isValid()) {
                return $this->app->json([
                    "message" => "Error pada field, perbaiki sebelum melakukan submit ulang.",
                    "errors" => $this->app->convertMessages($result->getErrorMessagesIndexedByAttribute())
                ], 400); // bad request
            }

            $old_password = $request['old_password'];
            $password = $request['password'];
            $re_password = $request['repeat_password'];

            // cek apakah old password benar
            // cari data user by username nya
            $user = User::findByUsername($username);

            // cek password bener apa ngga
            if (!$user->validatePassword($old_password)) {
                return $this->app->json([
                    "message" => "Ganti password gagal, periksa kembali error yang tampil.",
                    "errors" => [
                        "old_password" => "Password lama salah."
                    ]
                ], 400);
            }

            // cek apakah password sama dengan repeat password
            if ($password != $re_password) {
                $result->addError("Value must be equal to 'password'.", ['repeat_password'], ['repeat_password']);
            }

            // validasi kedua berdasarkan kondisi
            if (!$result->isValid()) {
                return $this->app->json([
                    "message" => "Error pada field, perbaiki sebelum melakukan submit ulang.",
                    "errors" => $this->app->convertMessages($result->getErrorMessagesIndexedByAttribute())
                ], 400); // bad request
            }

            // ubah password
            if (!$user->changePassword($password)) {
                return $this->app->json([
                    "message" => 'Gagal mengupdate password: ' . json_encode($user->getErrorSummary(true))
                ], 400);
            }

            return $this->app->json([
                "message" => 'Password berhasil diubah.'
            ]);
        })->addMiddleware(new JwtMiddleware());
    }
}
