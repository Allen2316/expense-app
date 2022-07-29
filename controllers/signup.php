<?php
require_once "models/usermodel.php";

class Signup extends SessionController
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->render("login/signup");
    }

    function newUser()
    {
        if ($this->existPOST(['username', 'password'])) {
            $username = $this->getPost('username');
            $password = $this->getPost('password');

            if ($username == '' || empty($username) || $password == '' || empty($password)) {
                $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EMPTY]);
            } else {
                // Si los valores estan correctos. guardar la base de datos.
                $user = new UserModel();
                $user->setUsername($username);
                $user->setPassword($password);
                $user->setRole('user');

                //Si existe el usuario.
                if ($user->exists($username)) {
                    $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER_EXISTS]);
                } else if ($user->save()) {
                    //Si no existe guardar y mandar al index con un mensaje de success.
                    $this->redirect('', ['success' => SuccessMessages::SUCCESS_SIGNUP_NEWUSER]);
                } else {
                    $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
                }
            }
        } else {
            $this->redirect('signup', ['error' => ErrorMessages::ERROR_SIGNUP_NEWUSER]);
        }
    }
}
