

<?php
    
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("location:adminlog.php");
        exit;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>view Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">
     <link rel="stylesheet" href="hideScrollbar.css">
    <style>
        .profile-card {
            max-width: 600px;
            margin: auto;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(88, 86, 86, 0.1);
        }
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-top: -75px;
            border: 5px solid white;
        }
        .bg{
            background-color:#9810FA;
        }
    </style>
</head>
<body>
<?php
include_once "connection.php";

// For example purposes, we fetch row with ID = 1
$res = mysqli_query($con, "SELECT *, service.service_name FROM service_providers INNER JOIN service ON service_providers.service_id = service.service_id 
 WHERE provider_id = '".$_GET['id']."'");
$row = mysqli_fetch_assoc($res);
?>

<div class="d-flex">
    <!-- Sidebar -->
    <?php include_once "sidenav.php"; ?>

    <!-- Main Content -->
    <div class="main-content p-4" id="mainContent">
    <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
        <i class="bi bi-list"></i> Menu
    </button>

        <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="card profile-card p-4 text-center w-100" style="max-width: 600px;">
                <div class="bg text-white p-4 rounded-top">
                <h3 class="mb-0">Service Provider Profile</h3>
                </div>
                <img src="img/i1.jpeg" alt="Profile Picture" class="profile-img mx-auto mt-3">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $row['provider_name']; ?></h4>
                    <p class="text-muted"><?php echo $row['email']; ?></p>
                    <hr>
                    <div class="text-start px-2 px-md-4">
                        <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
                        <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                        <p><strong>Business Name:</strong> <?php echo $row['businessname']; ?></p>
                        <p><strong>Service Category:</strong> <?php echo $row['service_name']; ?></p>
                        <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                        <p><strong>Lisence No:</strong> <?php echo $row['lisenceno']; ?></p>
                        <p><strong>Identity No:</strong> <?php echo $row['identityno']; ?></p>
                         <p><strong>Identity Image:</strong><br><img src="/serviceHub/Signup_Login/<?= $row['identityimage']; ?>" alt="ID Image" height="120px" width="250px">
                        <p><strong>Status:</strong> <?php echo ucfirst($row['approved_action']); ?></p>
                    </div>
                    <a href="verifyprovider.php?id=<?php echo $row['provider_id']; ?>" class="btn btn-outline-success mt-3">Approved</a>
            <a href="totallyrejected.php?id=<?php echo $row['provider_id']; ?>" class="btn btn-outline-danger mt-3">Totally rejected</a>
                </div>
            </div>
        </div>
    </div>


</div> <!-- d-flex -->


<script src="btn.js"></script>
<script src="./js/bootstrap.bundle.min.js"></script>
</body>
</html>
