<?php
require_once "credentials.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$sql = "
    SELECT m.id, m.nom, m.annee, m.details, m.type,
           p.nom AS parent_nom
    FROM materiel m
    LEFT JOIN materiel p ON m.parent = p.id
    ORDER BY m.id
";

$stmt = $pdo->query($sql);
$materiels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inventaire du matériel</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h1>Inventaire du matériel</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Année</th>
        <th>Détails</th>
        <th>Type</th>
        <th>Appartient à</th>
    </tr>

    <?php foreach ($materiels as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['id']) ?></td>
            <td><?= htmlspecialchars($m['nom']) ?></td>
            <td><?= htmlspecialchars($m['annee']) ?></td>
            <td><?= htmlspecialchars($m['details']) ?></td>
            <td><?= htmlspecialchars($m['type']) ?></td>
            <td><?= htmlspecialchars($m['parent_nom'] ?? '—') ?></td>
        </tr>
    <?php endforeach; ?>

</table>

</body>
</html>
