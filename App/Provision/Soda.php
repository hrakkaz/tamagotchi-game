<?php
namespace App\Provision;

class Soda extends Provision
{
    public function __construct()
    {
        $this->icon = '🥤';
        $this->name = 'Soda';
        $this->healthPoints = 0;
        $this->happinessPoints = 30;
        $this->hungerPoints = 0;
        $this->thirstPoints = -10;
    }
}