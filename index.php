<?php
spl_autoload_register(function ($class) {
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $fileName = str_replace('App' . DIRECTORY_SEPARATOR, __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR, $className) . '.php';
    if (file_exists($fileName)) {
        require $fileName;
    }
});

session_start();

use App\Animal\Animal;
use App\Game;

$game = $_SESSION['game'] ?? Game::getInstance();

if (isset($_POST['step'])) {
    switch ($_POST['step']) {
        case 'createAnimal':
            if (!empty($_POST['name']) && !empty($_POST['icon'])) {
                $animal = new Animal($_POST['icon'], $_POST['name']);
                $game->addAnimal($animal);
            }
            break;
            case 'reset':
                unset($_SESSION['game']);
            
                // Réinitialiser le singleton (obligatoire !)
                $reflection = new ReflectionClass(Game::class);
                $property = $reflection->getProperty('instance');
                $property->setAccessible(true);
                $property->setValue(null);
            
                // Nouvelle instance propre
                $game = Game::getInstance();
                break;
               
        case 'night':
            $game->night();
            break;
        case 'searchProvision':
            $game->searchProvision();
            break;
        case 'selectProvision':
            if (isset($_POST['index']) && is_numeric($_POST['index'])) {
                $game->selectProvision((int)$_POST['index']);
            }
            break;
        case 'eat':
            if (isset($_POST['index']) && is_numeric($_POST['index'])) {
                $game->eat((int)$_POST['index']);
            }
            break;
        case 'heal':
            if (isset($_POST['index']) && is_numeric($_POST['index'])) {
                $game->heal((int)$_POST['index']);
            }
            break;
        case 'cuddle':
            if (isset($_POST['index']) && is_numeric($_POST['index'])) {
                $game->cuddle((int)$_POST['index']);
            }
            break;
        case 'sleep':
            if (isset($_POST['index']) && is_numeric($_POST['index'])) {
            $game->sleep((int)$_POST['index']);
            }
            break;
            
    }

    $_SESSION['game'] = $game;
    header('Location: index.php');
    exit();
} else {
    require('interphase.php');
    $game->clearMessages();
    $_SESSION['game'] = $game;
}