<?php include("includes/header.php");
 ?>
<?php


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    
    $imagen = "recursos/" . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);

    include("db.php");
    $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES ('$nombre', '$descripcion', '$precio', '$imagen')";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<br>
<br>
<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Bienvenido al Dashboard, <?php echo $_SESSION['username']; ?>!</h2>

        <div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-600">Nombre del Producto:</label>
                    <input type="text" name="nombre" class="mt-1 p-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="descripcion" class="block text-sm font-medium text-gray-600">Descripción:</label>
                    <textarea name="descripcion" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>
                <div class="mb-4">
                    <label for="precio" class="block text-sm font-medium text-gray-600">Precio:</label>
                    <input type="number" name="precio" class="mt-1 p-2 w-full border rounded-md">
                </div>
                <div class="mb-4">
                    <label for="imagen" class="block text-sm font-medium text-gray-600">Imagen:</label>
                    <input type="file" name="imagen" accept="image/*" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Publicar Producto</button>
            </form>
        </div>

        <a href="logout.php" class="block mt-4 text-blue-500">Cerrar sesión</a>
    </div>
</body>

</html>
<style>
    img.logos {
    width: 17%;
}
i.fa-solid.fa-user.fa-lg.text-gray-500.group-hover\:text-black {
    display: none;
}
</style>