<?php


namespace App;


use Symfony\Component\HttpFoundation\Response;
use Tracy\Debugger;

class Controller
{

    protected $config = null;
    protected $request = null;
    protected $route = null;

    private $twig = null;

    public function __construct(Config $config, Request $request, array $match)
    {
        $this->config = $config;
        $this->request = $request;
        $this->route = $match;
    }

    public function run()
    {
        return new Response();
    }

    public function twig()
    {
        if ($this->twig === null) {

            $loader = new \Twig_Loader_Filesystem(['Templates/']);

            $this->twig = new \Twig_Environment($loader);

            $this->addTwigGlobals();

        }

        return $this->twig;
    }

    protected function addTwigGlobals()
    {
        Debugger::barDump($this->request->getUser());
        $this->twig()->addGlobal('User', $this->request->getUser());
        $this->twig()->addGlobal('FlashBag', $this->request->getSession()->getFlashBag());
    }

}