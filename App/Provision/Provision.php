<?php

namespace App\Provision;

abstract class Provision // Abstract = Ne peut pas se faire instancier 
{
    protected $icon = '';
    protected $name = '';

    protected $healthPoints = 0;
    protected $happinessPoints = 0;
    protected $hungerPoints = 0;
    protected $thirstPoints = 0;

    public function getHealthPoints() 
    {
        return $this->healthPoints;
    }

    public function getHappinessPoints() 
    {
        return $this->happinessPoints;
    }

    public function getHungerPoints() 
    {
        return $this->hungerPoints;
    }

    public function getThirstPoints() 
    {
        return $this->thirstPoints;
    }

    public function getName() 
    {
        return $this->name;
    }

    public function getIcon() 
    {
        return $this->icon;
    }
}
