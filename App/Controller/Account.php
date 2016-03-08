<?php


namespace App\Controller;


use App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Account extends Controller
{

    public function run()
    {
        $r = new Response();

        $r->setContent('Account');

        return $r;

    }

}