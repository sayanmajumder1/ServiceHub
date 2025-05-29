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
     <link rel="stylesheet" href="hideScrollbar.css">
</head>
<body>
    <div class="d-flex ">
    <!-- Sidebar -->
        <?php
            include_once "sidenav.php";
        ?>
        <div class="main-content p-4" id="mainContent">
        <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
                <i class="bi bi-list"></i> Menu
            </button>
                 <?php
                        include_once "connection.php";
                        $res=mysqli_query($con,"select * from service where service_id='".$_GET['id']."'");
                        if($row=mysqli_fetch_array($res))
                        {
                 ?>
            <div class="o35">
                <div class="col-md-8">
                    <div class="card-body ab2">
                        <h2>Edit Services:</h2>
                        <p class="card-text"> 
                            <form method="POST" action="service_update.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label>Service Name:</label><br>
                                    <input type="text" name="s_id" id="s_id" value="<?php echo $row['service_id']?>" class="con1" hidden>
                                    <input type="text" name="s_name" id="s_name" value="<?php echo $row['service_name']?>"class="con1" required>
                                </div>
                                
                               
                                <div class="mb-3">
                                    <label>Images:</label><br>
                                    
                                    <img src="./img/<?php echo $row['image']?> "height="125px"width="150px"><br><br>
                                    <label>Do you want to change the image:</label><br><br>
                                    <input type="file" name="s_img" id="s_img" class="con1">
                                </div>
                                <button type="submit" class="btn btn-outline-success">Update Services</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="btn.js"></script>
</body>
</html>