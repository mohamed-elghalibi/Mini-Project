<?php
require("config.php");
session_start();
if(!isset($_SESSION['identifiant'])){
    header("Location: login.php");
    exit();
}
$identifiant=$_SESSION['identifiant'];
$id=$_SESSION['identifiant_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === "ajouter") {
    $description = $_POST["tache"];
    $priorite = $_POST["priorite"];

    $stmt = $conn->prepare("INSERT INTO taches (description, priorite, identifiant_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $description, $priorite, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === "supprimer") {
    $tache_id = $_POST["tache_id"];

    $stmt = $conn->prepare("DELETE FROM taches WHERE id = ? AND identifiant_id = ?");
    $stmt->bind_param("ii", $tache_id, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === "mise_a_jour") {
    $tache_id = $_POST['tache_id'];
        $nouveau = $_POST['nouvelle_description'];
        $stmt = $conn->prepare("UPDATE taches SET description = ? WHERE id = ? AND identifiant_id = ?");
        $stmt->bind_param("sii", $nouveau, $tache_id, $id);
        $stmt->execute();
        header("Location: index.php");
        exit();
    
}

$stmt = $conn->prepare("SELECT * FROM taches WHERE identifiant_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$taches = [];
$taches= $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Gestionnaire de Tâches</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1 id="headnom">Bonjour <?php echo $identifiant; ?> </h1>
        <button id="déconnexionbutton"><a href="déconnexion.php" style="text-decoration:none;">Déconnexion</a></button>
    </header>
    <main>
        <section id="ajouter-tache">
            <form action="" method="POST">
            <input type="text" name="tache" placeholder="Nouvelle tâche…" required>
            <select name="priorite" >
                <option value="Urgente">🔴 Urgente</option>
                <option value="Normale">🟡 Normale</option>
                <option value="Faible">🟢 Faible</option>
            </select>
            <input type="submit" name="action" value="ajouter">
            </form>
        </section>

        <section id="filtres">
            <button data-filter="all" class="filter-btn active">Toutes</button>
            <button data-filter="Urgente" class="filter-btn">🔴 Urgentes</button>
            <button data-filter="Normale" class="filter-btn">🟡 Normales</button>
            <button data-filter="Faible" class="filter-btn">🟢 Faibles</button>
        </section>

        <section id="taches_list" class="taches_list">
            <?php if(empty($taches)): ?>
                <p>Aucun tache pour afficher</p>
            <?php else : ?>
                <?php foreach ($taches as $t): ?>
                    <div class="task" data-priority="<?php echo htmlspecialchars($t['priorite']); ?>">
                        <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST['action'] === 'modifier' && $_POST['tache_id'] == $t['id']): ?>
                            <form method="POST">
                                <input type="hidden" name="tache_id" value="<?php echo $t['id']; ?>">
                                <input type="text" name="nouvelle_description" value="<?php echo htmlspecialchars($t['description']); ?>" required>
                                <button type="submit" name="action" value="mise_a_jour">✅</button>
                            </form>
                        <?php else: ?>
                            <span class="desc"><?php echo htmlspecialchars($t['description']); ?></span>
                            <span class="badge badge-<?php echo strtolower($t['priorite']); ?>">
                            <?php echo htmlspecialchars($t['priorite']); ?>
                            </span>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="tache_id" value="<?php echo $t['id']; ?>">
                                <button type="submit" name="action" value="modifier">✏️</button>
                                <button type="submit" name="action" value="supprimer">🗑️</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </section>
    </main>

<script src="script.js"></script>
</body>
</html>
