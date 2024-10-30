<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="color">Couleur:</label>
        <input type="text" name="color" id="color" required><br>
        <input type="submit" value="Enregistrer" name="submit">
    </form>
    <?php

        //Créer un formulaire qui enregistre en cookie une couleur, celle-ci doit être
        //utilisée dans le CSS du body HTML (vous pouvez utiliser l’attribut html style)
        
        function validerCouleur($color){
            $listCouleurs = ['red', 'green', 'blue', 'yellow', 'black', 'white', 'purple', 'pink', 'orange', 'brown', 'grey'];
            if(isset($_POST['submit'])){
                if(preg_match('/^#[0-9A-F]{6}$/i', $color) or in_array($color, $listCouleurs)){
                    return true;
                }
                else return false;
            }
        }


        function enregistrerCouleur($color){
            if(isset($_POST['submit'])){
                setcookie('color', $color, time() + 3600);
            }
        }

        $color = $_POST['color'];
        enregistrerCouleur($color);

        if(isset($_COOKIE['color'])){
            echo "<body style='background-color: $_COOKIE[color]'>";
        }

    ?>
    
</body>
</html>