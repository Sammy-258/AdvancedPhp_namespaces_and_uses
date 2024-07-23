<?php

namespace App\Controllers;

use Core\Request;
use App\Models\User;

class AuthController
{
    // Handle user login
    public function login()
    {
        session_start();
        $email = Request::input('email');
        $password = Request::input('password');
        
        $user = User::where('email', $email);

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode([
                'message' => 'Login successful',
                'user' => [
                    'id' => $_SESSION['user_id'],
                    'email' => $user->email
                ]
            ]);
        } else {
     
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    }

    // Handle user registration
    public function register()
    {
        session_start();
        $email = Request::input('email');
        $password = Request::input('password');

        if (empty($email) || empty($password)) {
            header('Content-Type: application/json');
            http_response_code(400); // Bad Request
            echo json_encode([
                'error' => 'Email and password are required'
            ]);
            return;
        }

        $password = password_hash($password, PASSWORD_BCRYPT);
        
        if (User::where('email', $email)) {
            header('Content-Type: application/json');
            http_response_code(409); // Conflict
            echo json_encode(['error' => 'Email already in use']);
            return;
        }

        $user = new User;
        $user->email = $email;
        $user->password = $password;
        $user->save();

        $_SESSION['user_id'] = $user->id;

        header('Content-Type: application/json');
        http_response_code(201); // Created
        echo json_encode([
            'message' => 'Registration successful',
            'user' => [
                'id' => $user->id,
                'email' => $user->email
            ]
        ]);
    }

    // Handle user logout
    public function logout()
    {
        
        session_destroy();

        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode(['message' => 'Logout successful']);
    }
}
