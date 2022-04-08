<?php

use Phalcon\Mvc\Controller;


class OrderController extends Controller
{
    public function indexAction()
    {
        print_r($this->request->getPost());
        echo '<pre>';
        print_r(json_encode($this->session->get('cart')['cart']));
        // die();
        if ($this->session->has('user')) {
            $order = new Orders();
            $arr = [
                'user_id' => $this->request->get('user_id'),
                'products' => json_encode($this->session->get('cart')['cart']),
                'shipping_address' =>  $this->request->get('address'),
                'shipping_pincode' =>  $this->request->get('pincode'),
                'total_amount' => $this->request->get('total'),

            ];
            $order->assign(
                $arr,
                [
                    'user_id',
                    'products',
                    'shipping_address',
                    'shipping_pincode',
                    'total_amount'
                ]
            );

            $success = $order->save();
            if ($success) {
                $this->session->destroy('cart');
                $this->view->msg = "Your order has been placed";
            } else {
                $this->view->msg = "Something Went Wrong";
            }
        } else {
            $this->response->redirect('login');
        }
    }
}
