<?php
    session_start();
    if(!isset($_SESSION["username"])) {
        header("location:adminlog.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>

    <!-- Bootstrap 5 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-header {
            background: linear-gradient(to right,rgb(113, 18, 133),rgb(187, 52, 214));
            color: white;
            padding: 30px 20px;
            border-radius: 0 0 20px 20px;
            text-align: center;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-top: -60px;
            background-color: #fff;
        }
        .info-card {
            margin-top: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(23, 149, 154, 0.83);
            background: #fff;
            padding: 20px;
        }
        .btn-edit {
            background-color: #2575fc;
            color: white;
        }
        .btn-logout {
            background-color: #dc3545;
            color: white;
        }
        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
        .modal-header{
            background-color:rgb(150, 60, 186);
            color: white;
        }
       

    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include_once "sidenav.php"; ?>

    <!-- Main Content -->
    <div class="main-content p-4 " id="mainContent">
        <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
            <i class="bi bi-list"></i> Menu
        </button>

        <div class="container">
            <!-- Profile Header -->
            <div class="profile-header">
                <h2>Admin Profile</h2>
                <p>Manage your profile information</p>
            </div>
            <?php

                include_once "connection.php";
                $res=mysqli_query($con,"select * from admin where username='".$_SESSION['username']."'");
                $row=mysqli_fetch_array($res);


            ?>
            <!-- Profile Content -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="text-center">
                        
                        <h4 class="mt-2"><?php  echo ucfirst($row['name'])?></h4>
                        <p class="text-muted">Administrator</p>
                    </div>

                    <div class="info-card text-center">
                        <h5 class="mb-3">Profile Details</h5>
                        <div class="mb-2">
                            <strong>Username:</strong>  <?php  echo $row['username']?>
                        </div>
                        <div class="mb-2">
                            <strong>Email:</strong>   <?php  echo $row['email']?>
                        </div>
                        <div class="mb-2">
                            <strong>Phone:</strong>   <?php  echo $row['no']?>
                        </div>                   
                        <div class="mb-2">
                            <strong>Password:</strong>   <?php  echo $row['password']?>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <a href="adminupdate.php?id=<?php echo $row['admin_id']; ?>"class="btn btn-outline-primary">Edit Profile</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- main-content -->
</div> <!-- d-flex -->

<!-- Modal HTML -->
<div class="modal fade" id="acceptedModal"  aria-labelledby="acceptedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="acceptedModalLabel">Message</h1>
      </div>
      <div class="modal-body">
        <?php
        if (isset($_GET['add']) && $_GET['add'] == 1)
        {
        ?>
            Admin details successfully updated!
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
    
    <script src="btn.js"></script>
<?php 
 
 if(isset($_GET['add']) && $_GET['add'] == 1)
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
