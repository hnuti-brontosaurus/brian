<?php


namespace App\Controller;


use App\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Logout extends Controller
{

    public function run()
    {

        $this->request->getUser()->logout();

        $this->request->getSession()->getFlashBag()->add('success', 'Byl jsi odhlášen.');

        return new RedirectResponse('/login');

    }

}
