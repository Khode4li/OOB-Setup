<?php
use modules\telegram;
class handler{
    private array $modules = [
        telegram::class
    ];

    public function notify()
    {
        foreach ($this->modules as $module){
            $module::getInstance()->notify();
        }
    }

}