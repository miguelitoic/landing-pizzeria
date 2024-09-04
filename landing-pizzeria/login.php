<?php
include("includes/header.php");
include("db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        $error = "Nombre de usuario y contraseña son obligatorios.";
    } else {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (isset($row['password'])) {
                $hashedPassword = $row['password'];

                if (password_verify($password, $hashedPassword)) {
                    session_start();
                    $_SESSION['username'] = $username;

                    header("Location: dashboard.php");
                    exit();
                } else {
                    $error = "Contraseña incorrecta.";
                }
            } else {
                $error = "Error en la base de datos. La columna 'password' no está definida.";
            }
        } else {
            $error = "Nombre de usuario no encontrado.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Iniciar Sesión</title>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Iniciar Sesión</h2>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </form>
        </div>
        <div class="card-footer">
            <p style="color: red;"><?php echo $error; ?></p>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

</body>
</html>
<style>
    img.logos {
    width: 17%;
}
</style>