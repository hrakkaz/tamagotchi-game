<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/JEU_PHP/style.css">
    <title>Tamagotchi</title>
</head>
<body>
    <div class="game-header">
        <h1>Tamagotchi</h1>
        <div class="game-info">
            <p>Jour: <?= $game->getDays() ?></p>
            <p>Points: <?= $game->getPoints() ?></p>
        </div>
    </div>
    <form action="index.php" method="post"> 
        <input type="hidden" name="step" value="reset">
        <button type="submit">ReStart</button>
    </form>

    <form action="index.php" method="post"> 
        <input type="hidden" name="step" value="night">
        <button type="submit">Passer la nuit</button>
    </form>

    <form action="index.php" method="post"> 
        <input type="hidden" name="step" value="createAnimal">
        <input type="text" name="name" placeholder="Nom de l'animal">
        <select name="icon">
            <option>🐸</option>
            <option>🐨</option>
            <option>🦊</option>
            <option>🦄</option>
            <option>🕷️</option>
            <option>🐝</option>
        </select>
        <button type="submit">Créer</button>
    </form>

    <form action="index.php" method="post"> 
        <input type="hidden" name="step" value="searchProvision">
        <button type="submit">Chercher provisions</button>
    </form>

    <div class="affichage">
        <?php foreach($game->getAnimals() as $index => $animal): ?>
            <div>
                <p><?= $animal->getName() ?></p>
                <p><?= $animal->getIcon() ?></p>
                <p>Âge: <?= $animal->getAge() ?></p>
                <p>❤️ <?= $animal->getHealth() ?></p>
                <p>🎭 <?= $animal->getMood() ?></p>
                <p>🍕 <?= $animal->getHunger() ?></p>
                <p>💧 <?= $animal->getThirst() ?></p>

                <form action="index.php" method="post">
                    <input type="hidden" name="step" value="eat">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit">Nourrir</button>
                </form>

                <form action="index.php" method="post">
                    <input type="hidden" name="step" value="heal">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit">Soigner</button>
                </form>

                <form action="index.php" method="post">
                    <input type="hidden" name="step" value="cuddle">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit">Caresser</button>
                </form>
                <form action="index.php" method="post">
                    <input type="hidden" name="step" value="sleep">
                    <input type="hidden" name="index" value="<?= $index ?>">
                    <button type="submit">Dormir</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="food">
    <h3>Provisions disponibles :</h3>
    <?php foreach($game->getProvisions() as $index => $provision): ?>
        <div>
            <p><?= $provision->getIcon() ?> <?= $provision->getName() ?></p>
            <p>🍕 <?= $provision->getHungerPoints() ?></p>
            <p>💧 <?= $provision->getThirstPoints() ?></p>
            <p>❤️ <?= $provision->getHealthPoints() ?></p>
            <p>🎭 <?= $provision->getHappinessPoints() ?></p>
            <form action="index.php" method="post">
                <input type="hidden" name="step" value="selectProvision">
                <input type="hidden" name="index" value="<?= $index ?>">
                <button type="submit">Choisir</button>                    
            </form>
        </div>
    <?php endforeach; ?>
</div>


    <div class="message">
        <h3>Messages :</h3>
        <?php foreach($game->getMessages() as $message): ?>
            <p><?= $message ?></p>
        <?php endforeach; ?>
    </div>
</body>
</html>
