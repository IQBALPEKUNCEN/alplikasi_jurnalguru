<?php

namespace api\middleware;

use api\middleware\base\Middleware;
use app\models\base\TokenSession;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use UnexpectedValueException;

class JwtMiddleware extends Middleware
{
    public function before($params)
    {
        $token = $this->app->request()->getHeader('Authorization');
        $jwt = str_replace('Bearer ', '', $token);

        try {
            $decoded = JWT::decode($jwt, new Key(JWTKEY, 'HS256'));

            // update sesi waktu token selama 15 menit
            $token_valid = TokenSession::updateSession($jwt);
            if (!$token_valid) {
                return $this->app->json([
                    "message" => 'Sesi anda sudah habis, silahkan login kembali.'
                ], 401); // Unauthorized
            }
        } catch (UnexpectedValueException $e) {
            return $this->app->json([
                "message" => 'Token: ' . $e->getMessage()
            ], 401); // Unauthorized
        } catch (Exception $e) {
            return $this->app->json([
                "message" => 'Token: ' . $e->getMessage()
            ], 400);
        }

        // Simpan nilai yang diperlukan dalam variabel yang dapat diakses oleh fungsi route
        $this->app->set('jwt_decoded', $decoded);
    }
}
