<?php


namespace App\Controller;


use App\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Index extends Controller
{

    public function run()
    {


        if ($this->request->getUser()->notLoggedIn())
        {
            $r = new RedirectResponse('/login');
            return $r;
        }

        $r = new Response();
        $r->setContent(
            $this->twig()->render('dashboard.twig')
        );

        return $r;

    }

}