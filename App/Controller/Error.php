<?php


namespace App\Controller;


use App\Controller;
use Symfony\Component\HttpFoundation\Response;

class Error extends Controller
{
    public function run()
    {
        $r = new Response();

        $r->setStatusCode(404);

        $r->setContent('Not found.');

        return $r;

    }
}
