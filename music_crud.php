<?php
include 'config.php';

// Agregar canción
if (isset($_POST['add'])) {
    $titulo = $_POST['titulo'];
    $artista = $_POST['artista'];
    $album = $_POST['album'] ?? null;
    $duracion = !empty($_POST['duracion']) ? "'".$conn->real_escape_string($_POST['duracion'])."'" : "NULL";
    $video_url = !empty($_POST['enlace']) ? "'".$conn->real_escape_string($_POST['enlace'])."'" : "NULL";
    $conn->query("INSERT INTO canciones (titulo, artista, album, duracion, video_url) VALUES ('$titulo', '$artista', '$album', $duracion, $video_url)");
    header("Location: music_crud.php");
}

// Editar canción
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $artista = $_POST['artista'];
    $album = $_POST['album'] ?? null;
    $duracion = !empty($_POST['duracion']) ? "'".$conn->real_escape_string($_POST['duracion'])."'" : "NULL";
    $video_url = !empty($_POST['enlace']) ? "'".$conn->real_escape_string($_POST['enlace'])."'" : "NULL";
    $conn->query("UPDATE canciones SET titulo='$titulo', artista='$artista', album='$album', duracion=$duracion, video_url=$video_url WHERE id=$id");
    header("Location: music_crud.php");
}

// Eliminar canción
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM canciones WHERE id=$id");
    header("Location: music_crud.php");
}

// Buscar por filtro (canción, álbum o artista)
$search = "";
$search_by = "";
if (isset($_GET['search']) && isset($_GET['search_by'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $search_by = $conn->real_escape_string($_GET['search_by']);
    if (in_array($search_by, ['titulo', 'album', 'artista'])) {
        $result = $conn->query("SELECT * FROM canciones WHERE $search_by LIKE '%$search%' ORDER BY artista, id");
    } else {
        $result = $conn->query("SELECT * FROM canciones ORDER BY artista, id");
    }
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
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f4f4f9;
            color: #333;
        }

        h1, h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #3498db;
            color: white;
        }

        form {
            margin-top: 20px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background: #2980b9;
        }

        .delete {
            background: #e74c3c;
        }

        .delete:hover {
            background: #c0392b;
        }

        .video-btn {
            background: #2ecc71;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 14px;
        }

        .video-btn:hover {
            background: #27ae60;
        }

        /* RESPONSIVE DESIGN */
        @media screen and (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            thead tr {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
                background: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }

            td {
                display: flex;
                justify-content: space-between;
                font-size: 14px;
                border: none;
                border-bottom: 1px solid #eee;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #333;
            }

            .video-btn {
                width: 100%;
                margin-top: 8px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Gestor de Canciones</h1>

    <form method="get">
        <label for="search_by">Buscar por:</label>
        <select name="search_by" id="search_by" required>
            <option value="titulo" <?= (isset($_GET['search_by']) && $_GET['search_by'] == 'titulo') ? 'selected' : '' ?>>Canción</option>
            <option value="album" <?= (isset($_GET['search_by']) && $_GET['search_by'] == 'album') ? 'selected' : '' ?>>Álbum</option>
            <option value="artista" <?= (isset($_GET['search_by']) && $_GET['search_by'] == 'artista') ? 'selected' : '' ?>>Artista</option>
        </select>
        <input type="text" name="search" id="search" value="<?= htmlspecialchars($search) ?>" placeholder="Escribe aquí..." required>
        <button type="submit">Buscar</button>
        <a href="music_crud.php" style="display:inline-block; margin-top:5px;">Mostrar todo</a>
    </form>

    <?php
    $current_artist = "";
    while ($row = $result->fetch_assoc()):
        if ($current_artist != $row['artista']) {
            if ($current_artist !== "") echo "</table>";
            $current_artist = $row['artista'];
            echo "<h2>" . htmlspecialchars($current_artist) . "</h2>";
            echo "<table><thead><tr><th>Título</th><th>Álbum</th><th>Duración</th><th>Acciones</th><th>Video</th></tr></thead><tbody>";
        }
    ?>
        <tr>
            <td data-label="Título"><?= htmlspecialchars($row['titulo']) ?></td>
            <td data-label="Álbum"><?= htmlspecialchars($row['album'] ?: '(Sin álbum)') ?></td>
            <td data-label="Duración"><?= htmlspecialchars($row['duracion'] ?: '(Sin duración)') ?></td>
            <td data-label="Acciones">
                <a href="?edit=<?= $row['id'] ?>">Editar</a> | 
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar esta canción?')" class="delete">Eliminar</a>
            </td>
            <td data-label="Video">
                <?php if (!empty($row['video_url'])): ?>
                    <a href="<?= $row['video_url'] ?>" target="_blank" class="video-btn">Mirar Video</a>
                <?php else: ?>
                    <span style="color:#999;">Sin enlace</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
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
        <label>Duración (opcional):</label>
        <input type="text" name="duracion" value="<?= $edit_data['duracion'] ?? '' ?>">
        <label>Enlace (opcional):</label>
        <input type="text" name="enlace" value="<?= $edit_data['video_url'] ?? '' ?>">
        <button type="submit" name="<?= $edit_data ? 'update' : 'add' ?>">
            <?= $edit_data ? "Actualizar Canción" : "Agregar Canción" ?>
        </button>
    </form>
</body>
</html>
