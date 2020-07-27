<?php

namespace src\Controller;

class UserController extends \Core\Controller
{
    public function indexAction()
    {
       
        $this->render('User/index');
    }

    public function registerAction()
    {
        $this->render('User/register');   
        $params = $this->request->getParams();
        if (isset($params['password']) && isset($params['email'])) {
            $params['password'] =  password_hash($params['password'], PASSWORD_DEFAULT);
            $user = new \src\Model\UserModel($params);
            if (!$user->id) {
                $user->save();
                echo " Votre compte a ete cree.";
            }
        }
    }
}
