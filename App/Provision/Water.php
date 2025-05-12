<?php
namespace App\Provision;

class Water extends Provision
{
    public function __construct()
    {
        $this->icon = '💧';
        $this->name = 'Eau';
        $this->healthPoints = 0;
        $this->happinessPoints = -20;
        $this->hungerPoints = 0;
        $this->thirstPoints = -40;
    }
}