<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // TODO: Validate the user's input

    // Connect to the database
	

    $conn = mysqli_connect("localhost", "root", "", "signup");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email is already taken
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email address already exists
        echo "That email address is already taken.";
    } else {       
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            // User account created successfully
            echo "Your account has been created. You can now log in.";
        } else {
            // Error creating user account
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}

?>
