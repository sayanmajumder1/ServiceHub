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
    <link href="./css/bootstrap.min.css" rel="stylesheet">
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

<!-- Bootstrap JS Bundle -->
<script src="./js/bootstrap.bundle.min.js"></script>
<script src="btn.js"></script>

</body>
</html>
