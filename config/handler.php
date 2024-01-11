<?php

namespace config;

class handler
{

    private array $modules;
    public function __construct()
    {
        $this->modules = registry::get('modules');
    }

    public function notify()
    {
        foreach ($this->modules as $module) {
            $module::getInstance()->notify();
        }
    }

}