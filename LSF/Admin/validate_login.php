<?php
session_start();
include_once "connection.php";
// Get username and password from form


    $username = $_POST['u_name'];
    $password = $_POST['password'];
    // Validate username and password
    if (empty($username) || empty($password)) {
      echo "Please fill in both username and password.";
      exit();
    }
    else
    {
        // Query database for user
        $query = "SELECT * FROM admin WHERE username = '$username'";
        $result =mysqli_query($con,$query);

        // Check if user exists
        if ($result->num_rows > 0) 
        {
            // Get user data
            $row = mysqli_fetch_array($result);
      
              // Verify password
              if ($password == $row['password']) 
              {
                $_SESSION['username']=$password;
                // Login successful
                echo "Login successful!";
                
                // Redirect to dashboard or other page
                header("Location: dashboard.php");
                exit();
              } 
              else 
              {
                // Password incorrect
               echo "Password incorrect.";
              }
        } 
        else
        {
          // User does not exist
          echo "User does not exist.";
        }
    }

?>