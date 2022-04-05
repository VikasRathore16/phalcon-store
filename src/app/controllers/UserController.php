<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function dashboardAction()
    {
        $user = ($this->session->get('user'));
        $this->view->user = $user;
        if ($this->request->has('pincode')) {
            $updateUser = Users::find($user['user_id']);
            $updateUser[0]->address = $this->request->getPost('address');
            $updateUser[0]->country = $this->request->getPost('country');
            $updateUser[0]->state = $this->request->getPost('state');
            $updateUser[0]->pincode = $this->request->getPost('pincode');
            $success = $updateUser[0]->save();
            if ($success) {
                $this->view->msg = "Updated Details";
                $this->session->set('user', [
                    'user_id' => $updateUser[0]->user_id,
                    'username' => $updateUser[0]->username,
                    'firstname' => $updateUser[0]->firstname,
                    'lastname' => $updateUser[0]->lastname,
                    'email' => $updateUser[0]->email,
                    'role' => $updateUser[0]->role,
                    'address' => $this->request->getPost('address'),
                    'pincode' => $this->request->getPost('pincode'),
                    'state' => $this->request->getPost('state'),
                    'country' => $this->request->getPost('country')
                ]);
            } else {
                $this->view->msg = "Something went Wrong";
            }
        }
    }
}
