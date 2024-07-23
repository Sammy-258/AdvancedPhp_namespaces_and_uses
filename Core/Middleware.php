<?php

namespace Core;

class Middleware
{
    
    public static function handle($middleware, $next)
    {
        session_start();
        if ($middleware == 'auth') {
            if (!isset($_SESSION['user_id'])) {
                header('Content-Type: application/json');
                http_response_code(401);
                echo json_encode(['error' => 'Unauthorized. Please log in.']);
                exit;
            }
        }

        $next();
    }
}
