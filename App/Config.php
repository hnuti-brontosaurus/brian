<?php


namespace App;


class Config
{
    protected $config = [];

    public function load($file)
    {
        if (file_exists($file)) {
            $this->config = array_merge_recursive($this->config, include_once($file) );
        }
    }

    public function get($key)
    {

        if (isset($this->config[$key])) {
            return $this->config[$key];
        } else {
            return null;
        }
    }

    public function getRequired($key)
    {
        $val = $this->get($key);
        if ($val === null) {
            throw new \RuntimeException('Setting '. $key .' not found in config.');
        } else {
            return $val;
        }
    }

}