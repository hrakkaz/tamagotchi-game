<?php

namespace App;

use App\Animal\Animal;
use App\Provision\Burger;
use App\Provision\Soda;
use App\Provision\Water;
use App\Provision\Watermelon;

class Game {
    private $points = 3;
    private $days = 1;
    private $animals = [];
    private $provisions = [];
    private $selectedProvision = -1;
    private $messages = [];
    private static $instance = null;

    private function __construct() {}
    public function __wakeup() { self::$instance = $this; }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getMessages() { return $this->messages; }
    public function addMessage($message) { $this->messages[] = $message; }
    public function clearMessages() { $this->messages = []; }
    public function getPoints() { return $this->points; }
    public function getAnimals() { return $this->animals; }
    public function getDays() { return $this->days; }
    public function getProvisions() { return array_values($this->provisions); }
    public function getSelectedProvisionIndex() { return $this->selectedProvision; }

    public function addAnimal(Animal $animal) {
        if ($this->consumePoints(1)) {
            $this->animals[] = $animal;
            $this->addMessage("{$animal->getName()} a rejoint votre zoo !");
        }
    }

    public function night() {
        $this->days++;
        $this->points = 3;
        foreach ($this->animals as $animal) {
            $animal->sleep();
        }
        $this->cleanDeadAnimals();
        $this->checkReproduction();
        $this->addMessage("La nuit est passée !");
    }

    private function consumePoints($points) {
        if ($this->points >= $points) {
            $this->points -= $points;
            return true;
        }
        $this->addMessage("Pas assez de points !");
        return false;
    }

    public function searchProvision() {
        if ($this->consumePoints(1)) {
            $rand = rand(1, 100);
            if ($rand <= 30) {
                $this->provisions[] = new Watermelon();
                $this->addMessage("Vous avez trouvé une pastèque !");
            } elseif ($rand <= 50) {
                $this->provisions[] = new Burger();
                $this->addMessage("Vous avez trouvé un burger !");
            } elseif ($rand <= 80) {
                $this->provisions[] = new Soda();
                $this->addMessage("Vous avez trouvé un soda !");
            } elseif ($rand <= 90) {
                $this->provisions[] = new Water();
                $this->addMessage("Vous avez trouvé de l'eau !");
            } else {
                $this->addMessage("Vous n'avez rien trouvé...");
            }
        }
    }

    public function selectProvision($index) {
        if (isset($this->provisions[$index])) {
            $this->selectedProvision = $index;
            $provision = $this->provisions[$index];
            $this->addMessage("Vous avez sélectionné : {$provision->getName()}");
        }
    }

    public function eat($index) {
        if ($this->selectedProvision != -1 && isset($this->animals[$index])) {
            $animal = $this->animals[$index];
            if ($animal->isDead()) {
                $this->addMessage("{$animal->getName()} est mort...");
                return;
            }
            if ($this->consumePoints(1)) {
                $provision = $this->provisions[$this->selectedProvision];
                $animal->consume($provision);
                unset($this->provisions[$this->selectedProvision]);
                $this->selectedProvision = -1;
                $this->addMessage("Vous avez nourri {$animal->getName()} avec {$provision->getName()}");
            }
        } else {
            $this->addMessage("Sélectionnez une provision et un animal valide !");
        }
    }

    public function heal($index) {
        if (isset($this->animals[$index])) {
            $animal = $this->animals[$index];
            if ($animal->isDead()) {
                $this->addMessage("{$animal->getName()} est mort...");
                return;
            }
            if ($this->consumePoints(3)) {
                $amount = rand(20, 100);
                $animal->changeHealth($amount);
                $this->addMessage("Vous avez soigné {$animal->getName()} (+{$amount} ❤️)");
            }
        }
    }

    public function cuddle($index) {
        if (isset($this->animals[$index])) {
            $animal = $this->animals[$index];
            if ($animal->isDead()) {
                $this->addMessage("{$animal->getName()} est mort...");
                return;
            }
            if ($this->consumePoints(2)) {
                $amount = rand(0, 30);
                $animal->changeMood($amount);
                $this->addMessage("Vous avez caressé {$animal->getName()} (+{$amount} 😊)");
            }
        }
    }

    private function cleanDeadAnimals() {
        $this->animals = array_filter($this->animals, function($animal) {
            return !$animal->isDead();
        });
    }

    private function checkReproduction() {
        foreach ($this->animals as $animal) {
            if ($animal->getAge() > 5 && !$animal->isDead()) {
                $baby = new Animal($animal->getIcon(), $animal->getName() . ' Jr');
                $this->addAnimal($baby);
                $this->addMessage("🎉 Un bébé est né : {$baby->getName()} !");
            }
        }
    }
    public function sleep($index)
    {
        $animal = $this->animals[$index];
        
        $animal->changeHealth(20);
        $animal->changeHunger(-10);
        $animal->changeMood(5);
        
        $this->messages[] = "{$animal->getName()} a dormi et se sent beaucoup mieux ! 😴";
    }

}