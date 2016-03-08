<?php


namespace App;


use Tracy\Debugger;

class User
{

    protected $isLoggedIn = false;
    protected $name = null;
    protected $id = null;
    protected $email = null;

    protected $lastAction = null;

    protected $session = null;

    // load from session
    // save to session
    // roles -> roleprovider
    // credentials -> credentialsprovider

    public function __construct(Request $request)
    {

        $this->session = $request->getSession();

        $sessionData = $this->session->get('brianUser');

        if ($sessionData !== null) {
            $this->loadFromSession($sessionData);
            $this->saveToSession();
        }

        $request->setUser($this);
    }

    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }

    public function notLoggedIn()
    {
        return !$this->isLoggedIn();
    }

    public function getName()
    {
        return $this->name;
    }

    public function logout()
    {
        $this->id = null;
        $this->name = null;
        $this->email = null;
        $this->isLoggedIn = false;

        $this->saveToSession();
    }

    public function checkPassword($email, $password, $otp)
    {
        if (true) {
            $this->id = 1;
            $this->name = 'Franta';
            $this->email = $email;
            $this->isLoggedIn = true;


            $this->saveToSession();
            Debugger::barDump($this->session->get('brianUser'), 'session after save');

            return true;

        } else {
            return false;
        }
    }

    protected function loadFromSession($sessionData)
    {

        $now = new \DateTimeImmutable();

        $this->name = $sessionData['name'];
        $this->id = $sessionData['id'];
        $this->email = $sessionData['email'];

        if ($this->id !== null) {
            $this->isLoggedIn = true;
        }

        $this->lastAction = $now->format(\DATE_ISO8601);

    }

    protected function saveToSession()
    {
        $this->session->set('brianUser', [
            'name' => $this->name,
            'id' => $this->id,
            'email' => $this->email,
            'lastAction' => $this->lastAction
        ]);
    }
}
