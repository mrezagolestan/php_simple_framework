<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Core\Request\RequestInterface;
use Core\Utils\Auth\Auth;
use Core\Utils\Hash;

class AuthController extends Controller
{

    public function __construct(
        private readonly RequestInterface $request,
        private readonly Auth             $auth,
    )
    {

    }

    public function login()
    {
        if (isset($this->request->username)) {
            //TODO: should be check pass from DB further
            $dbHashedPassword = Hash::make('helloworld');

            if (Hash::check($this->request->password, $dbHashedPassword)) {
                //TODO: should be set ID based on DB further
                $this->auth->auth(1);

                setFlashMessage('success', 'You successfully logged in.');

                return redirect(config()->auth->redirect_after_login);
            } else {
                setFlashMessage('danger', 'Password is incorrect.');
            }
        }
        return view('auth/login');
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect('/');
    }
}