<?php
// Inicia la sesión
session_start();

$host = "bhqherqffrpus0bap7qx-mysql.services.clever-cloud.com:21747";
$db_user = "udvmhc33gva54ot1";
$db_password = "HO8e0SD1SWSz3GRF7pR";
$db_name = "bhqherqffrpus0bap7qx";

$conn = new mysqli($host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];

    // Verificar si el usuario y contraseña existen
    $queryCheckUser = "SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?";
    $stmtCheckUser = $conn->prepare($queryCheckUser);
    $stmtCheckUser->bind_param("ss", $usuario, $contrasena);
    $stmtCheckUser->execute();
    $resultCheckUser = $stmtCheckUser->get_result();

    if ($resultCheckUser->num_rows > 0) {
        // El usuario y contraseña coinciden, verificar la cuenta y licencia
        $row = $resultCheckUser->fetch_assoc();
        if ($row['cuenta_bloqueada'] == 1) {
            // La cuenta está bloqueada
            header("Location: baneado/baneado");
            exit();
        }

        // Verificar si la cuenta está activada
        if ($row['accountstatus'] == 1) {
            // Verificar la validez de la licencia (30 días)
            $fechaLicencia = $row["expirationdate"];
            $hoy = date("Y-m-d");

            if ($fechaLicencia >= $hoy) {
                // Inicio de sesión exitoso y licencia activa
                $_SESSION['usuario'] = $row['usuario'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['ipadres'] = $row['ipadres'];
                $_SESSION['telefono'] = $row['telefono'];
                $_SESSION['Address'] = $row['Address']; 
                $_SESSION['zipcode'] = $row['zipcode']; 
                $_SESSION['nombrecompleto'] = $row['nombrecompleto']; 
                $_SESSION['creationdate'] = $row['creationdate'];  
                $_SESSION['dineroactual'] = $row['dineroactual'];              
                $_SESSION['city'] = $row['city']; 
                // Redirige al usuario a la página de inicio
                header("Location: inicio/index");
                exit();
            } else {
                header("Location: vencida/vencida");
                exit();
            }
        } else {
            header("Location: activarcuenta");
        }
    } else {
        // Credenciales incorrectas
        header("Location: error/error");
    }

    $stmtCheckUser->close();
}

$conn->close();
?>
