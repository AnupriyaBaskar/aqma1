<?php
session_start();

$email = $_POST['email'];
$password = $_POST['upswd1'];

if (!empty($email) && !empty($password)) {
    $host = "127.0.0.1";
    $dbusername = "aqmaom9z_Admin";
    $dbpassword = "Admin@12345678iicaqm";
    $dbname = "aqmaom9z_usersdata";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT upswd1 FROM register WHERE email = ? LIMIT 1";

        // Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($stored_password);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum == 1) {
            $stmt->fetch();
            if ($password == $stored_password) {
                // Password is correct, start a session and redirect to a success page
                $_SESSION['email'] = $email;
                header("Location: index.html"); // Redirect to welcome page
                exit();
            } else {
                // Password is incorrect
                header("Location: error.html"); // Redirect to error page
                exit();
            }
        } else {
            // Email not found
            header("Location: error.html"); // Redirect to error page
            exit();
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}
?>
