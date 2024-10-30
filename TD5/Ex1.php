<?php
// Activer le rapport d'erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "TD5";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Fonction pour récupérer les départements
function getDepartements($conn) {
    $sql = "SELECT * FROM departement";
    $result = $conn->query($sql);

    $departements = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $departements[] = $row;
        }
    }
    return $departements;
}

// Récupération des départements
$departements = getDepartements($conn);

// Fermeture de la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Départements</title>
</head>
<body>
    <?php if (!empty($departements)): ?>
        <table border="1" style="border-collapse: collapse; width: 100%;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th>Numéro</th>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Nom majuscule</th>
                    <th>Slug</th>
                    <th>Soundex</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($departements as $dep): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dep['departement_id']); ?></td>
                        <td><?php echo htmlspecialchars($dep['departement_code']); ?></td>
                        <td><?php echo htmlspecialchars($dep['departement_nom']); ?></td>
                        <td><?php echo htmlspecialchars($dep['departement_nom_uppercase']); ?> €</td>
                        <td><?php echo htmlspecialchars($dep['departement_slug']); ?> %</td>
                        <td><?php echo htmlspecialchars($dep['departement_nom_soundex']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun département trouvé.</p>
    <?php endif; ?>
</body>
</html>
