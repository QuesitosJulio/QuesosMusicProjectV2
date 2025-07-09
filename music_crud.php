<?php

// Configurar DB
$host = "mysql.railway.internal";
$user = "root";
$password = "tNSqWVXZdBqcSJQBfOoeGaJrjfuuHPKp";
$dbname = "music_db";
$port = 3306;

$conn = new mysqli($host, $user, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Agregar cancion
if (isset($_POST['add'])) {
    $titulo = $_POST['titulo'];
    $artista = $_POST['artista'];
    $album = $_POST['album'] ?? null;
    $duracion = $_POST['duracion'];
    $video_url = $_POST['enlace'];
    $conn->query("INSERT INTO canciones (titulo, artista, album, duracion, video_url) VALUES ('$titulo', '$artista', '$album', '$duracion', '$video_url')");
    header("Location: music_crud.php");
}

// Editar cancion
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $artista = $_POST['artista'];
    $album = $_POST['album'];
    $duracion = $_POST['duracion'];
    $video_url = $_POST['enlace'];
    $conn->query("UPDATE canciones SET titulo='$titulo', artista='$artista', album='$album', duracion='$duracion', video_url='$video_url' WHERE id=$id");
    header("Location: music_crud.php");
}

// Eliminar cancion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM canciones WHERE id=$id");
    header("Location: music_crud.php");
}


// Buscar artista/album/cancion
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $result = $conn->query("SELECT * FROM canciones 
        WHERE titulo LIKE '%$search%' 
        OR artista LIKE '%$search%' 
        OR album LIKE '%$search%' 
        ORDER BY artista, id");
} else {
    $result = $conn->query("SELECT * FROM canciones ORDER BY artista, id");
}

// Consultar individualmente
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_data = $conn->query("SELECT * FROM canciones WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Música</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f9; color: #333; }
        h1 { color: #444; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background: #ddd; }
        form { margin-top: 20px; background: #fff; padding: 15px; border: 1px solid #ccc; }
        input, select { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 8px 12px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
        .delete { background: #e74c3c; }
        .delete:hover { background: #c0392b; }
    </style>
</head>
<body>
    <h1>Gestor de Canciones</h1>

    <form method="get">
        <label for="search">Buscar por canción, álbum o artista:</label>
        <input type="text" name="search" id="search" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Buscar</button>
        <a href="music_crud.php">Mostrar todo</a>
    </form>

    <?php
    $current_artist = "";
    while ($row = $result->fetch_assoc()):
        if ($current_artist != $row['artista']) {
            if ($current_artist !== "") echo "</table>";
            $current_artist = $row['artista'];
            echo "<h2>" . htmlspecialchars($current_artist) . "</h2>";
            echo "<table><tr><th>Título</th><th>Álbum</th><th>Duración</th><th>Acciones</th></tr>";
        }
    ?>
        <tr>
            <td>
                <?php if (!empty($row['video_url'])): ?>
                    <a href="<?= $row['video_url'] ?>" target="_blank" style="text-decoration:none; color:#2c3e50;">
                        <?= htmlspecialchars($row['titulo']) ?>
                    </a>
                <?php else: ?>
                    <?= htmlspecialchars($row['titulo']) ?>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['album'] ?: '(Sin álbum)') ?></td>
            <td><?= htmlspecialchars($row['duracion']) ?></td>
            <td>
                <a href="?edit=<?= $row['id'] ?>">Editar</a> | 
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar esta canción?')" class="delete">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </table>

    <h2><?= $edit_data ? "Editar Canción" : "Agregar Nueva Canción" ?></h2>
    <form method="post">
        <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <?php endif; ?>
        <label>Título:</label>
        <input type="text" name="titulo" required value="<?= $edit_data['titulo'] ?? '' ?>">
        <label>Artista:</label>
        <input type="text" name="artista" required value="<?= $edit_data['artista'] ?? '' ?>">
        <label>Álbum (opcional):</label>
        <input type="text" name="album" value="<?= $edit_data['album'] ?? '' ?>">
        <label>Duración:</label>
        <input type="text" name="duracion" required value="<?= $edit_data['duracion'] ?? '' ?>">
        <label>Enlace:</label>
        <input type="text" name="enlace" required value="<?= $edit_data['video_url'] ?? '' ?>">
        <button type="submit" name="<?= $edit_data ? 'update' : 'add' ?>">
            <?= $edit_data ? "Actualizar Canción" : "Agregar Canción" ?>
        </button>
    </form>
</body>
</html>
