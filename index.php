<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // $_POST pega do form (tem o action lá na declaração do form)
        $email = $_POST['email'];
        $password = $_POST['password'];
    

        if (!empty($email) && !empty($password)) {
            $_SESSION['email'] = $email;
    
            header("Location: home.html");
            exit();
        } else {
            $error = "Por favor, preencha todos os campos.";
        }
    }
?>

