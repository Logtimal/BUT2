<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Contactez-nous</h1>

    <form action="" method="post">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="sujet">Sujet:</label>
        <input type="text" name="sujet" id="sujet" required><br>
        <label for="message">Message:</label>
        <textarea name="message" id="message" cols="30" rows="10" required></textarea><br>
        <input type="submit" value="Envoyer" name="submit">
    
    <?php

        /*Créez un formulaire de contact qui valide les données du formulaire (nom,
        e-mail,sujet, message) côté serveur.
        Lorsque le formulaire est soumis, affichez les données du formulaire sur la page.
        Utilisez la fonction mail(), htmlspecialchars() et strip_tags()
    
        */



        function recupererData($data){
            if(isset($_POST['submit'])){
                $data = htmlspecialchars($data);
                $data = strip_tags($data);
                return $data;
            }
            else return "";
        }
        
    
        $nom = recupererData($_POST['nom']);
        $email = recupererData($_POST['email']);
        $sujet = recupererData($_POST['sujet']);
        $message = recupererData($_POST['message']);

        echo "Nom: $nom <br>";
        echo "Email: $email <br>";
        echo "Sujet: $sujet <br>";
        echo "Message: $message <br>";
    ?>

</body>
</html>



