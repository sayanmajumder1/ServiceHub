<?php

session_start();



if (!isset($_SESSION["email"])) {
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="hideScrollbar.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f1fc;
    }

    .profile-container {
      margin-left: 250px;
      /* sidebar width */
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

    /* .profile-card {
      background: #fff;
      max-width: 500px;
      margin: -40px auto 30px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 30px;
      text-align: center;
    } */
    .profile-card {
      background: #fff;
      max-width: 500px;
      margin: 30px auto;
      /* Changed from -40px auto 30px */
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 30px;
      text-align: center;
      position: relative;
      top: 0;
      /* Ensure no upward shift */
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

    .profile-container1 {
      position: relative;
      width: 90px;
      height: 90px;
      border-radius: 50%;
      overflow: hidden;
      cursor: pointer;
    }

    .profile-img1 {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .icon-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: 0.3s ease;
      color: #fff;
      font-size: 30px;
    }

    .profile-container1:hover .icon-overlay {
      opacity: 1;
    }

    input[type="file"] {
      display: none;
    }
         .modal-header{
            background-color:rgb(150, 60, 186);
            color: white;
        }
       .btn {
    font-size: 0.95rem;
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
    $res = mysqli_query($con, "select service_providers.* ,service.service_name from service_providers inner join service on
        service_providers.service_id =service.service_id where email='" . $_SESSION['email'] . "'");
    $row = mysqli_fetch_array($res);
    ?>
    <div class="profile-card">
      <!-- <img src="img/n1.jpg" alt="Profile Picture" class="profile-img"> -->
      <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="file-upload" class="profile-container1">
          <img src="./uploads2/<?php echo $row['image'] ?>" alt="Profile Picture" class="profile-img1">
          <div class="icon-overlay"><i class="fa fa-camera"></i></div>
        </label>
        <input type="file" name="profile" id="file-upload" onchange="this.form.submit()">
      </form>

      <h3><?php echo $row['provider_name'] ?></h3>
      <h6><?php echo $row['service_name'] ?></h6>
      <div class="details">
        <p><strong>Email:</strong> <?php echo $row['email'] ?></p>
        <p><strong>Phone:</strong> <?php echo $row['phone'] ?></p>
        <p><strong>Description:</strong><?php echo $row['description'] ?></p>
        <p><strong>Location:</strong><?php echo $row['address'] ?></p>
        <p><strong>Business Name:</strong><?php echo $row['businessname'] ?></p>
        <p><strong>Lisence No:</strong><?php echo $row['lisenceno'] ?></p>
        <p><strong>Identity No:</strong><?php echo $row['identityno'] ?></p>

      </div>
      <a href="profile_update.php"><button class="edit-btn">Edit Profile</button></a>
      <a href="change_password.php"><button class="edit-btn">Change Password</button></a>


    </div>
  </div>
<!-- Modal HTML -->
<div class="modal fade" id="acceptedModal"  aria-labelledby="acceptedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="acceptedModalLabel">Message</h1>
      </div>
      <div class="modal-body">
        <?php
        if (isset($_GET['status']) && $_GET['status'] == 1)
        {
        ?>
            Your profile has been updated.
        <?php
        }
        else if (isset($_GET['status']) && $_GET['status'] == 2)
        {
        ?>
            Your Password has been changed.
        <?php
        }
        else if (isset($_GET['status']) && $_GET['status'] == 3)
        {
        ?>
            Your previous password cannot be matched.
        <?php
        }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<script src="script.js"></script>
<?php 
    if (isset($_GET['status']) && $_GET['status'] == 1)
    {
?>
    <script>
        // Show modal when page loads if accepted=1 is present in URL
        var acceptedModal = new bootstrap.Modal(document.getElementById('acceptedModal'));
        acceptedModal.show();
    </script>
<?php
    }
    else if(isset($_GET['status']) && $_GET['status'] == 2)
    {
?>
    <script>
        // Show modal when page loads if accepted=1 is present in URL
        var acceptedModal = new bootstrap.Modal(document.getElementById('acceptedModal'));
        acceptedModal.show();
    </script>
<?php
    }
    else if(isset($_GET['status']) && $_GET['status'] == 3)
    {
?>

    <script>
        // Show modal when page loads if accepted=1 is present in URL
        var acceptedModal = new bootstrap.Modal(document.getElementById('acceptedModal'));
        acceptedModal.show();
    </script>
<?php
    }
 ?>
</body>

</html>