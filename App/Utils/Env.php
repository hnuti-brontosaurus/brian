<?php


namespace App\Utils;


class Env
{
    public function getEnv($key)
    {
        return getenv($key);
    }
}
