<?php

namespace App\Modules\Auth\Controller;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

final class AuthController
{
    public function loginForm(Request $request, array $params, Auth $auth): Response|array
    {
        if ($auth->check()) {
            return Response::redirect('/dashboard');
        }

        return [
            'view' => 'modules/auth/views/login',
            'data' => [
                'title' => 'Login SISURAT',
                'error' => Session::flash('error'),
            ],
        ];
    }

    public function login(Request $request, array $params, Auth $auth): Response
    {
        $username = trim((string) $request->input('username'));
        $password = (string) $request->input('password');

        if (!$auth->login($username, $password)) {
            Session::flash('error', 'Username atau password salah.');
            return Response::redirect('/login');
        }

        return Response::redirect('/dashboard');
    }

    public function logout(Request $request, array $params, Auth $auth): Response
    {
        $auth->logout();
        return Response::redirect('/login');
    }
}
