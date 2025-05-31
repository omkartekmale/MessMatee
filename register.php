<?php
session_start();
include "includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $mess_name = ($role === "owner") ? $_POST['mess_name'] : null;
    $image = null;

    if ($role === "owner" && isset($_FILES['image'])) {
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
    }

    $query = "INSERT INTO users (name, email, password, role, mess_name, image) VALUES ('$name', '$email', '$password', '$role', '$mess_name', '$image')";
    $conn->query($query);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MessMate</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background: url('images/omkar1.jpg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>

<div class="registration-container">
    <h2>Register</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <select style="width: 100%;
    padding: 12px;margin: 12px 0;border: 1px solid rgba(255, 255, 255, 0.3);border-radius: 8px;background: rgba(255, 255, 255, 0.2);color: rgb(11, 10, 10);outline: none;
    font-size: 16px;"name="role" id="role" onchange="toggleMessFields()" required>
            <option value="student">Student</option>
            <option value="owner">Mess Owner</option>
        </select>
        <div id="mess_fields" style="display: none;">
            <input type="text" name="mess_name" placeholder="Mess Name">
            <input type="file" name="image">
        </div>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="index.php">Login</a></p>
</div>

<script>
    function toggleMessFields() {
        const role = document.getElementById("role").value;
        document.getElementById("mess_fields").style.display = (role === "owner") ? "block" : "none";
    }
</script>

</body>
</html>
