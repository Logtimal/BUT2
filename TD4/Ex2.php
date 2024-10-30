<?php
// Enregistrement des utilisateurs
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonFile = 'ressources/utilisateurs.json';
    $users = [];

    // Charger les utilisateurs 
    if (file_exists($jsonFile) && filesize($jsonFile) > 0) {
        $jsonData = file_get_contents($jsonFile);
        $users = json_decode($jsonData, true);
        if ($users === null) {
            error_log("Erreur de décodage JSON : " . json_last_error_msg());
            echo "<p style='color: red; text-align: center;'>Erreur lors du chargement des utilisateurs existants.</p>";
        }
    }

    $nouvelUtilisateur = [
        'nom' => htmlspecialchars($_POST['nom']),
        'prenom' => htmlspecialchars($_POST['prenom']),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
        'motdepasse' => password_hash($_POST['motdepasse'], PASSWORD_BCRYPT) 
    ];

    if (!empty($nouvelUtilisateur['nom']) && !empty($nouvelUtilisateur['prenom']) && !empty($nouvelUtilisateur['email']) && !empty($_POST['motdepasse'])) {
        $users[] = $nouvelUtilisateur;

        // utilisateurs mis à jour 
        $jsonData = json_encode($users, JSON_PRETTY_PRINT);
        if ($jsonData === false) {
            error_log("Erreur d'encodage JSON : " . json_last_error_msg());
            echo "<p style='color: red; text-align: center;'>Erreur lors de l'enregistrement des données.</p>";
        } else {
            if (file_put_contents($jsonFile, $jsonData) === false) {
                error_log("Erreur lors de l'enregistrement des utilisateurs.");
                echo "<p style='color: red; text-align: center;'>Erreur lors de l'enregistrement des utilisateurs dans le fichier.</p>";
            } else {
                echo "<p style='color: green; text-align: center;'>Utilisateur enregistré avec succès.</p>";
            }
        }
    } else {
        echo "<p style='color: red; text-align: center;'>Tous les champs sont obligatoires.</p>";
    }
}

// Charger les utilisateurs 
$users = [];
if (file_exists('ressources/utilisateurs.json') && filesize('ressources/utilisateurs.json') > 0) {
    $jsonData = file_get_contents('ressources/utilisateurs.json');
    $users = json_decode($jsonData, true);
    if ($users === null) {
        error_log("Erreur de décodage JSON pour l'affichage : " . json_last_error_msg());
        echo "<p style='color: red; text-align: center;'>Erreur lors du chargement de la liste des utilisateurs.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription & Liste des Utilisateurs</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { width: 50%; margin: 20px auto; text-align: center; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Formulaire d'Inscription</h2>
    <form method="POST" action="">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="motdepasse">Mot de passe :</label>
            <input type="password" id="motdepasse" name="motdepasse" required>
        </div>
        <button type="submit">S'inscrire</button>
    </form>

    <h2 style="text-align: center;">Liste des Utilisateurs</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
        </tr>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['nom']); ?></td>
                    <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" style="text-align: center;">Aucun utilisateur trouvé</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>