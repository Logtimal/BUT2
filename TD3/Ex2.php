<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="" method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" name="username" id="username" required><br>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" required><br>
        <input type="submit" value="Se connecter" name="submit">
        
    

    <?php

        //Créez un système d'authentification en utilisant des sessions. Les utilisateurs
        //devront se connecter avec un nom d'utilisateur et un mot de passe, puis accéder
        //à une page sécurisée après s'être authentifiés

        session_start();

        $users = [
            'louison' => 'petit',
            'tom' => 'gouin',
            'tangible' => '1234'
        ];

        function authentifier($username, $password){
            global $users;
            if(isset($_POST['submit'])){
                if(array_key_exists($username, $users) && $users[$username] == password_hash($password, PASSWORD_DEFAULT)){
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = password_hash($password, PASSWORD_DEFAULT);
                    return true;
                }
                else return false;
            }
        }

        $username = $_POST['username'];
        $password = $_POST[password_hash('password', PASSWORD_DEFAULT)];

        if(authentifier($username, $password)){
            echo "Bienvenue $username";
        }
        else echo "Nom d'utilisateur ou mot de passe incorrect";


        session_destroy();
    ?>
</body>
</html>


