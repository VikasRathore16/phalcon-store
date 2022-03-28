<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class IndexController extends Controller
{
    public function indexAction()
    {
    }
    public function dashboardAction()
    {
        if ($this->session->get('email') == null) {
            $response = new Response();
            $response->setStatusCode(403);
            $response->setContent("<h1>Authentication Failed ! 403</h1> <p>Please Login</p>");

            $response->send();
            die();
        }
        $this->view->msg = $this->service;
        $appName = $this->getAppName;
        $this->view->appName = $appName;
    }
}
