<?php
namespace App\Animal;

use App\Game;
use App\Provision\Provision;

class Animal {
    private string $icon;
    private string $name;
    private int $age = 0;
    private int $health = 100;
    private int $mood = 100;
    private int $hunger = 50;
    private int $thirst = 50;

    public function __construct(string $icon, string $name) {
        $this->icon = $icon;
        $this->name = $name;
    }

    public function consume(Provision $provision): void {
        $this->changeHealth($provision->getHealthPoints());
        $this->changeMood($provision->getHappinessPoints());
        $this->changeHunger($provision->getHungerPoints());
        $this->changeThirst($provision->getThirstPoints());
    }

    public function isDead(): bool {
        return $this->health <= 0;
    }

    public function getIcon(): string { return $this->icon; }
    public function getName(): string { return $this->name; }
    public function getAge(): int { return $this->age; }
    public function getHealth(): int { return $this->health; }
    public function getMood(): int { return $this->mood; }
    public function getHunger(): int { return $this->hunger; }
    public function getThirst(): int { return $this->thirst; }

    public function changeHealth(int $points): void {
        $this->health = max(0, min(100, $this->health + $points));
        Game::getInstance()->addMessage("{$this->name} " . 
            ($points >= 0 ? "a gagné +" : "a perdu ") . abs($points) . " points de santé.");
    }

    public function changeMood(int $points): void {
        $this->mood = max(0, min(100, $this->mood + $points));
        Game::getInstance()->addMessage("{$this->name} " . 
            ($points >= 0 ? "a gagné +" : "a perdu ") . abs($points) . " points d'humeur.");
    }

    public function changeHunger(int $points): void {
        $this->hunger = max(0, min(100, $this->hunger + $points));
        Game::getInstance()->addMessage("{$this->name} " . 
            ($points >= 0 ? "a gagné +" : "a perdu ") . abs($points) . " points de faim.");
    }

    public function changeThirst(int $points): void {
        $this->thirst = max(0, min(100, $this->thirst + $points));
        Game::getInstance()->addMessage("{$this->name} " . 
            ($points >= 0 ? "a gagné +" : "a perdu ") . abs($points) . " points de soif.");
    }

    public function sleep(): void {
        if ($this->isDead()) return;

        $this->age++;
        $this->changeHunger(rand(5, 15));
        $this->changeThirst(rand(5, 15));
        $this->changeMood(rand(-80, 80));

        if ($this->hunger >= 100) {
            $loss = rand(10, 30);
            $this->changeHealth(-$loss);
            Game::getInstance()->addMessage("{$this->name} a trop faim (-$loss ❤️)");
        }

        if ($this->thirst >= 100) {
            $loss = rand(10, 30);
            $this->changeHealth(-$loss);
            Game::getInstance()->addMessage("{$this->name} a trop soif (-$loss ❤️)");
        }

        if ($this->mood <= 0) {
            $loss = rand(0, 20);
            $this->changeHealth(-$loss);
            Game::getInstance()->addMessage("{$this->name} est trop triste (-$loss ❤️)");
        }

        if ($this->health <= 0) {
            Game::getInstance()->addMessage("💀 {$this->name} est mort...");
        }
    }
}