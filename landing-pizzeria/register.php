<?php
include("includes/header.php");
include("db.php");

$error = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Verificar si el nombre de usuario o el correo electrónico ya están registrados
        $checkExistence = "SELECT user_id FROM users WHERE username = ? OR email = ?";
        $stmtExistence = $conn->prepare($checkExistence);
        $stmtExistence->bind_param("ss", $username, $email);
        $stmtExistence->execute();
        $stmtExistence->store_result();

        if ($stmtExistence->num_rows > 0) {
            $error = "El nombre de usuario o el correo electrónico ya están registrados.";
        } else {
            // Hashear la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario con el rol seleccionado
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

            if ($stmt->execute()) {
                $success = "Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                $error = "Error en el registro: " . $stmt->error;
            }

            $stmt->close();
        }

        $stmtExistence->close();
    }
}
?>

<!-- Resto del código HTML -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Registro</title>
    <style>
        .mt-5, .my-5 {
            margin-top: 11rem !important;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Registro</h2>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="form-group">
                    <label for="username">Nombre de Usuario:</label>
                    <input type="text" class="form-control" name="username" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="form-group">
                    <label for="role">Rol:</label>
                    <select class="form-control" name="role" required>
                        <option value="usuario">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </form>
        </div>
        <div class="card-footer">
            <p style="color: red;"><?php echo $error; ?></p>
            <p style="color: green;"><?php echo $success; ?></p>
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