<?php

namespace App\Provision;

class Watermelon extends Provision
{
    public function __construct()
    {
        $this->icon = '🍉';
        $this->name = 'Watermelon';
        $this->hungerPoints = -20;
        $this->thirstPoints = 30;    
    }
}