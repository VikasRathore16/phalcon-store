<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;
use Phalcon\Http\Response;



class LoginController extends Controller
{
    public function indexAction()
    {
        if ($this->cookies->has("email")) {
            //Get the cookie 
            $this->cookies->useEncryption(false);
            $loginCookie = $this->cookies->get("email");

            // Get the cookie's value 

            $value = $loginCookie->getValue();
            $this->view->value = $value;
            header("Location:  http://localhost:8080/index/dashboard");
        }


        $request = new Request();
        $this->view->request = $request->get();
        $email = $request->get('email');
        $password = $request->get('password');
        $remember = $request->get('Remember');
        $this->view->email = $email;
        $this->view->password = $password;
        $checkemail = Users::find("email = '$email'");
        $checkpassword = Users::find("password = '$password'");

        $user = Users::query()
            ->where("email = '$email'")
            ->andWhere("password = '$password'")
            ->execute();
        $this->view->user = $user;

        if (count($checkemail) > 0 && count($checkpassword)) {
            $this->view->msg = 'Authentication failed';
        }

        if (count($user) > 0) {
            if ($remember == 'on') {
                $this->cookies->useEncryption(false);
                $this->cookies->set(
                    'email',
                    $email
                );
            }
            $this->view->msg = $this->session->set('email', $email);
            $this->view->msg = $this->session->set('password', $password);
            if ($email == 'admin@gmail.com') {
                header("Location: http://localhost:8080/admin/dashboard");
            } else {
                header("Location: http://localhost:8080/user");
            }
        }
    }


    

    public function logoutAction()
    {

        $remember = $this->cookies->get('email');
        $remember->delete("email");
        $this->session->remove('email');
        unset($this->session);
        header("Location: http://localhost:8080/");
    }
}
