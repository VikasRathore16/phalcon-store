<?php

use Phalcon\Mvc\Controller;

use Phalcon\Http\Request;

class CartController extends Controller
{

    public function indexAction()
    {
        $this->view->cart = $this->session->get('cart');
      
    }

    public function addAction()
    {
        $request = new Request();
        $product_id = $request->get('product_id');


        $product = Products::find($product_id);
        $newproduct = array([
            'product_id' => $product[0]->product_id,
            'product_name' => $product[0]->product_name,
            'product_image' => $product[0]->product_image,
            'product_category' => $product[0]->product_category,
            'sale_price' => $product[0]->sale_price,
            'cost_price' => $product[0]->cost_price,
        ]);

        if (($this->session->get('products')['product']) == null) {
            $this->session->set(
                'products',
                [
                    'product' =>
                    $newproduct
                ]
            );
        } else {
            $arr = ($this->session->get('products'));
            array_push($arr['product'], $newproduct[0]);
            print_r($this->session->set(
                'products',
                [
                    'product' =>
                    $arr['product']
                ]
            ));
        };

        $arr = ($this->session->get('products'));
        print_r($arr['product']);
        $unique = [];
        $cart = [];
        foreach ($arr['product'] as $product) {
            array_push($unique, $product['product_id']);
            $cart[$product['product_id']] = $product;
        }
        echo "Unique";
        $unique = array_count_values($unique);
        foreach ($cart as $key => $value) {
            foreach ($unique as $id => $quantity) {
                if ($key == $id) {
                    $cart[$key]['quantity'] = $quantity;
                }
            }
        }
        $this->session->set(
            'cart',
            [
                'cart' => $cart,
            ]
        );
        print_r($this->session->get('cart'));
        // $this->session->destroy();
        die();
    }

    public function removeAction()
    {
        $product_id = $this->request->getPost('product_id');

        $arr = $this->session->get('cart');

        foreach ($arr['cart'] as $key => $value) {
            if ($key == $product_id) {
                unset($arr['cart'][$key]);
            }
        }
        $this->session->set(
            'cart',
            [
                'cart' => $arr['cart'],
            ]
        );

        $productSessions = $this->session->get('products');
        foreach ($productSessions['product'] as $key => $value) {
            if ($value['product_id'] == $product_id) {
                unset($productSessions['product'][$key]);
            }
        }
        $this->session->set(
            'products',
            [
                'product' =>
                $productSessions['product']
            ]
        );


        die();
    }
    public function updateAction()
    {
        $val = $this->request->getPost('quantity');
        $product_id = $this->request->getPost('product_id');

        $arr = $this->session->get('cart');
        foreach ($arr['cart'] as $key => $value) {
            if ($key == $product_id) {
                $arr['cart'][$key]['quantity'] = $val;
            }
        }
        $this->session->set(
            'cart',
            [
                'cart' => $arr['cart'],
            ]
        );
        $productSessions = $this->session->get('products');
        foreach ($productSessions['product'] as $key => $value) {
            print_r($value);
            if ($value['product_id'] == $product_id) {
                $assign = $value;
                unset($productSessions['product'][$key]);
            }
        }
        for ($i = 0; $i < $val; $i++) {
            array_push($productSessions['product'], $assign);
        }
        $this->session->set(
            'products',
            [
                'product' =>
                $productSessions['product']
            ]
        );
        die();
    }

    public function checkoutAction()
    {
        $this->view->cart = $this->session->get('cart');
        $this->view->user = $this->session->get('user');

        
    }

    public function destroysesAction()
    {
        $this->session->destroy('products');
        die();
    }
}
