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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" >
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">
</head>
<body>
    <div class="d-flex ">
        <!-- Sidebar -->
        <?php
            include_once "sidenav.php";
        ?>

        <!-- Main Content -->
        <div class="main-content p-4" id="mainContent">
            <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
                <i class="bi bi-list"></i> Menu
            </button>
                <div class="o35">
                    <p style="padding:5px;font-size:2.4rem">Dashboard </p>
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card c1">
                            <div class="card-body">
                                <div style="display: flex; justify-content: center;">
                                    <i class="bi bi-person-fill s1  h222"></i> 
                                </div>
                                <h5 class="card-title h222"style="text-align:center">  Total User</h5>
                                <?php
                                     
                                     include_once "connection.php";
                                     $res=mysqli_query($con,"select count(*) as total from users");
                                     $row=mysqli_fetch_array($res);
                                ?>
                                <h5 class="card-title  h222"style="text-align:center"><?php echo $row['total']?></h5>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card c1">
                            <div class="card-body">
                                <div style="display: flex; justify-content: center;">
                                    <i class="bi bi-person-gear s1  h222"></i>
                                </div>
                                <h5 class="card-title  h222" style="text-align:center">  Total Service provider</h5>
                                <?php
                                     
                                     include_once "connection.php";
                                     $res=mysqli_query($con,"select count(*) as total from service_providers");
                                     $row=mysqli_fetch_array($res);
                                ?>
                                <h5 class="card-title  h222"style="text-align:center"><?php echo $row['total']?></h5>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row r1">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card c1">
                            <div class="card-body">
                                <div style="display: flex; justify-content: center;">
                                    <i class="bi bi-hammer s1  h222"></i>
                                </div>
                                <h5 class="card-title  h222"style="text-align:center">   Total Services</h5>
                                <?php
                                     
                                     include_once "connection.php";
                                     $res=mysqli_query($con,"select count(*) as total from service");
                                     $row=mysqli_fetch_array($res);
                                ?>
                                <h5 class="card-title  h222"style="text-align:center"><?php echo $row['total']?></h5>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card c1">
                            <div class="card-body">
                                <div style="display: flex; justify-content: center;">
                                    <i class="bi bi-book s1  h222"></i>
                                </div>
                                <h5 class="card-title  h222"style="text-align:center">  Total Booking</h5>
                                <?php
                                     
                                     include_once "connection.php";
                                     $res=mysqli_query($con,"select count(*) as total from booking");
                                     $row=mysqli_fetch_array($res);
                                ?>
                                <h5 class="card-title  h222"style="text-align:center"><?php echo $row['total']?></h5>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>   
       
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="btn.js"></script>
</body>
</html>