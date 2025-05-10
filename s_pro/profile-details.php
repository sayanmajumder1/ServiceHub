<?php

    session_start();
  
	 
	
     if(!isset($_SESSION["email"]))
     {
         header("location:/serviceHub/Signup_login/login.php");
         exit;
     }



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Service Provider Profile</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f1fc;
    }

    .profile-container {
      margin-left: 250px; /* sidebar width */
    }

    .profile-header {
      background-color: #9810FA;
      color: white;
      padding: 40px 30px;
      border-bottom-left-radius: 30px;
    }

    .profile-header h2 {
      margin: 0;
      font-size: 26px;
    }

    .profile-header p {
      margin: 5px 0 0;
      font-size: 14px;
    }

    .profile-card {
      background: #fff;
      max-width: 500px;
      margin: -40px auto 30px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 30px;
      text-align: center;
    }

    .profile-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #9810FA;
      margin-bottom: 15px;
    }

    .profile-card h3 {
      margin: 0 0 5px;
      font-size: 22px;
      color: #333;
    }

    .profile-card small {
      color: #aaa;
    }

    .details {
      margin-top: 20px;
      text-align: left;
    }

    .details p {
      margin: 8px 0;
      font-size: 15px;
      color: #555;
    }

    .edit-btn {
      margin-top: 20px;
      padding: 10px 25px;
      background: #9810FA;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    .edit-btn:hover {
      background: #7a0ed0;
    }

    @media (max-width: 768px) {
      .profile-container {
        margin-left: 0;
      }

      .profile-card {
        margin: 20px auto;
      }
    }
  </style>
</head>
<body>
  <?php include 'sidebar.php'; ?>
  <div class="profile-container">
    <div class="profile-header">
      <h2>Service Provider Profile</h2>
    </div>
    <?php

        include_once "connection.php";
        $res=mysqli_query($con,"select service_providers.* ,service.service_name from service_providers inner join service on
        service_providers.service_id =service.service_id where email='".$_SESSION['email']."'");
        $row=mysqli_fetch_array($res);
    ?>
    <div class="profile-card">
      <img src="img/n1.jpg" alt="Profile Picture" class="profile-img">
      <h3><?php  echo $row['provider_name'] ?></h3>
      <h6><?php  echo $row['service_name'] ?></h6>
      <div class="details">
        <p><strong>Email:</strong> <?php  echo $row['email'] ?></p>
        <p><strong>Phone:</strong> <?php  echo $row['phone'] ?></p>
        <p><strong>Description:</strong><?php  echo $row['description'] ?></p>
        <p><strong>Location:</strong><?php  echo $row['address'] ?></p>
        <p><strong>Business Name:</strong><?php  echo $row['businessname'] ?></p>
        <p><strong>Lisence No:</strong><?php  echo $row['lisenceno'] ?></p>
        <p><strong>Identity No:</strong><?php  echo $row['identityno'] ?></p>
        <p><strong>Password:</strong><?php  echo $row['password'] ?></p>
      </div>
      <a href="profile_update.php"><button class="edit-btn">Edit Profile</button></a>
    </div>
  </div>

</body>
</html>
