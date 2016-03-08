<?php

namespace App;


class Request extends \Symfony\Component\HttpFoundation\Request
{

    protected $user = null;

    public function setUser (User $user)
    {
        $this->user = $user;
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        return $this->user;
    }

}
