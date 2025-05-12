<?php

namespace App\Provision;

class Burger  extends Provision
{
    public function __construct()
    {
        $this->icon = '🍔';
        $this->name = 'Burger';
        $this->healthPoints = -10;
        $this->hungerPoints = -100;
        $this->thirstPoints = 30;    
    }
}