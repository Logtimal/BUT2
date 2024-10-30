<?php
// Chemin vers le fichier JSON
$jsonFile = 'ressources/taches.json';

// Fonction pour charger les tâches depuis le fichier JSON
function chargerTaches($jsonFile) {
    if (file_exists($jsonFile) && filesize($jsonFile) > 0) {
        $jsonData = file_get_contents($jsonFile);
        $taches = json_decode($jsonData, true);
        if ($taches === null) {
            error_log("Erreur de décodage JSON : " . json_last_error_msg());
            return [];
        }
        return $taches;
    }
    return [];
}

// Fonction pour enregistrer les tâches dans le fichier JSON
function enregistrerTaches($jsonFile, $taches) {
    $jsonData = json_encode($taches, JSON_PRETTY_PRINT);
    if ($jsonData === false) {
        error_log("Erreur d'encodage JSON : " . json_last_error_msg());
        return false;
    }
    return file_put_contents($jsonFile, $jsonData) !== false;
}

// Charger les tâches existantes
$taches = chargerTaches($jsonFile);

// Ajouter une tâche
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $nouvelleTache = [
        'nom' => htmlspecialchars($_POST['nom']),
        'description' => htmlspecialchars($_POST['description']),
        'echeance' => $_POST['echeance']
    ];
    $taches[] = $nouvelleTache;
    enregistrerTaches($jsonFile, $taches);
}

// Modifier une tâche
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $index = $_POST['index'];
    if (isset($taches[$index])) {
        $taches[$index]['nom'] = htmlspecialchars($_POST['nom']);
        $taches[$index]['description'] = htmlspecialchars($_POST['description']);
        $taches[$index]['echeance'] = $_POST['echeance'];
        enregistrerTaches($jsonFile, $taches);
    }
}

// Supprimer une tâche
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    $index = $_POST['index'];
    if (isset($taches[$index])) {
        array_splice($taches, $index, 1);
        enregistrerTaches($jsonFile, $taches);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tâches</title>
    <style>
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { width: 50%; margin: 20px auto; text-align: center; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Formulaire d'Enregistrement de Tâche</h2>
    <form method="POST" action="">
        <input type="hidden" name="action" value="ajouter">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="description">Description :</label>
            <input type="text" id="description" name="description" required>
        </div>
        <div>
            <label for="echeance">Échéance :</label>
            <input type="date" id="echeance" name="echeance" required>
        </div>
        <button type="submit">Ajouter la tâche</button>
    </form>

    <h2 style="text-align: center;">Liste des Tâches</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Description</th>
            <th>Échéance</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($taches)): ?>
            <?php foreach ($taches as $index => $tache): ?>
                <tr>
                    <td><?php echo htmlspecialchars($tache['nom']); ?></td>
                    <td><?php echo htmlspecialchars($tache['description']); ?></td>
                    <td><?php echo htmlspecialchars($tache['echeance']); ?></td>
                    <td>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="action" value="modifier">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="text" name="nom" value="<?php echo htmlspecialchars($tache['nom']); ?>" required>
                            <input type="text" name="description" value="<?php echo htmlspecialchars($tache['description']); ?>" required>
                            <input type="date" name="echeance" value="<?php echo htmlspecialchars($tache['echeance']); ?>" required>
                            <button type="submit">Modifier</button>
                        </form>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align: center;">Aucune tâche trouvée</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>