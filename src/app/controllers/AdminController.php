<?php

use Phalcon\Mvc\Controller;
// use Phalcon\Http\Response;

class AdminController extends Controller
{
    public function indexAction()
    {
    }
    public function dashboardAction()
    {
        $this->view->products = Products::find();

        if ($this->session->get('email') == null) {
            $response = new Response();
            $response->setStatusCode(403);
            $response->setContent("<h1>Authentication Failed ! 403</h1> <p>Please Login</p>");

            $response->send();
            die();
        }
        // $this->view->msg = $this->service;
        // $appName = $this->getAppName;
        // $this->view->appName = $appName;
    }

    public function usersAction()
    {
        $this->view->users = Users::find();
    }

    public function addproductAction()
    {
        $product = new Products();
        $product->assign(
            $this->request->getPost(),
            [
                'product_name',
                'product_category',
                'sale_price',
                'cost_price',
            ]
        );
        $success = $product->save();
        if ($success) {
            header('Location: http://localhost:8080/admin/dashboard');
        }
        if (!$success) {
            $this->view->msg = '<h4 class="alert alert-danger">Something went wrong</h4>';
        }
    }
}
