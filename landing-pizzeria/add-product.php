<?php


// Verificar si el usuario está autenticado y tiene el rol de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

include("includes/header.php");

// Conectar a la base de datos
include("db.php");

// Variables para almacenar mensajes de error o éxito
$error = $success = "";

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock_quantity = $_POST["stock_quantity"];

    // Validar los datos (puedes agregar más validaciones según tus necesidades)
    if (empty($name) || empty($description) || empty($price) || empty($stock_quantity)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Insertar el nuevo producto en la base de datos
        $sql = "INSERT INTO products (name, description, price, stock_quantity) 
                VALUES ('$name', '$description', $price, $stock_quantity)";

        if ($conn->query($sql) === TRUE) {
            $success = "Producto agregado con éxito.";
        } else {
            $error = "Error al agregar el producto: " . $conn->error;
        }
    }
}
?>

<h2>Agregar Nuevo Producto</h2>
<form method="post" action="">
    <label for="name">Nombre del Producto:</label>
    <input type="text" name="name" required>

    <label for="description">Descripción:</label>
    <textarea name="description" required></textarea>

    <label for="price">Precio:</label>
    <input type="number" name="price" step="0.01" required>

    <label for="stock_quantity">Cantidad en Stock:</label>
    <input type="number" name="stock_quantity" required>

    <button type="submit">Agregar Producto</button>
</form>

<p style="color: red;"><?php echo $error; ?></p>
<p style="color: green;"><?php echo $success; ?></p>

<?php include("includes/footer.php"); ?>
