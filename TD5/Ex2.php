<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ex2_td5";

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insérer un utilisateur dans la base de données lors de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $motdepasse = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hash du mot de passe

    $stmt = $conn->prepare("INSERT INTO User (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("Échec de la préparation de la requête: " . $conn->error);
    }
    
    $stmt->bind_param("ssss", $nom, $prenom, $email, $motdepasse);

    if ($stmt->execute() === TRUE) {
        echo "Nouvel enregistrement créé avec succès";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    $stmt->close();
}

// Lister tous les utilisateurs
$sql = "SELECT id, nom, prenom, email FROM User";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>

<h2>Formulaire d'inscription</h2>
<form method="post" action="">
  Nom: <input type="text" name="nom" required><br><br>
  Prénom: <input type="text" name="prenom" required><br><br>
  Email: <input type="email" name="email" required><br><br>
  Mot de passe: <input type="password" name="mot_de_passe" required><br><br>
  <input type="submit" value="S'inscrire">
</form>

<h2>Liste des utilisateurs</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Afficher les données de chaque ligne
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"]. "</td><td>" . $row["nom"]. "</td><td>" . $row["prenom"]. "</td><td>" . $row["email"]. "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='4'>0 résultats</td></tr>";
    }
    $conn->close();
    ?>
</table>

</body>
</html>
