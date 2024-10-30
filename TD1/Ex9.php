<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $valo = 1700;
        $totk = 160;
        $botw = 164;

        $totalDuration = $valo + $totk + $botw;

        echo "Durée de jeu pour le jeu 1: " . $valo . " heures<br>";
        echo "Durée de jeu pour le jeu 2: " . $totk . " heures<br>";
        echo "Durée de jeu pour le jeu 3: " . $botw . " heures<br>";
        echo "Durée totale de jeu: " . $totalDuration . " heures";
    ?>
    
</body>

</html>