<?php


namespace App\Controller;


use App\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class Login extends Controller
{

    public function run()
    {

        if ($this->route['_route'] == 'login') {
            $r = new Response();
            $r->setContent(
                $this->twig()->render('login.twig')
            );

            return $r;

        } elseif ($this->route['_route'] == 'postLogin') {

            return $this->handleUserLogin();

        } else {
            throw new \RuntimeException('neočekávaný request');
        }


    }

    protected function handleUserLogin()
    {
        $email = $this->request->get('Email');
        $password = $this->request->get('Password');
        $otp = $this->request->get('Otp');

        if ($email === null || $password === null) {
            $this->request->getSession()->getFlashBag()->add('danger', 'Email a heslo jsou povinné.');
            return new RedirectResponse('/login');
        }

        if ($this->request->getUser()->checkPassword($email, $password, $otp) === true) {
            return new RedirectResponse('/');
        } else {
            $this->request->getSession()->getFlashBag()->add('danger', 'Email nebo heslo nesedí.');
            return new RedirectResponse('/login');
        }
    }
}
