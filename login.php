<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the user input from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connect to the database
    $con = mysqli_connect("localhost", "root", "", "signup");

    // Check if the connection was successful
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL query to select the user with the given email and password
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    // Execute the query
    $result = mysqli_query($con, $sql);

    // Check if there is a row with the given email and password
    if (mysqli_num_rows($result) > 0) {
        // User exists, redirect to the dashboard page
        header("Location: index.html");
        exit();
    } else {
        // User does not exist, display an error message
        echo "Invalid email or password.";
        if ($conn->query($sql) === TRUE) {
            // User account created successfully
            echo " log in successful.";
        } else {
            // Error creating user account
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close the database connection
    mysqli_close($con);
}
?>
