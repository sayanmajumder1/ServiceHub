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
    <title>Manage sub Service</title>
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
        <div class="main-content p-4" id="mainContent">
            <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
                <i class="bi bi-list"></i> Menu
            </button>
        <div class="o35">
                    <p style="padding:5px;font-size:2.2rem">Manage Services </p>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Service Name</th>
                        <th scope="col">Sub Service Name</th>
                        <th scope="col">Service Description</th>
                        <th colspan='2'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        $count=1;
                        include_once "connection.php";
                        $res=mysqli_query($con,"select subservice.* ,service.service_name from subservice inner join service on 
                        subservice.service_id=service.service_id");
                        while($row=mysqli_fetch_array($res))
                        {

                    ?>
                      <tr>
                        <th scope="row"><?php echo $count++?></th>
                        <td data-label="Image"><img src="./img/<?php echo $row['image']?> "height="125px"width="150px"></td>

                        <td data-label="Service name"><?php echo $row['service_name'] ?></td>
                        <td data-label="Sub Service name"><?php echo $row['subservice_name'] ?></td>
                        <td data-label="Service Description"><?php echo $row['service_des'] ?></td>
                        <td data-label="Action"><a href="subservice_edit.php?id=<?php echo $row['subservice_id']?>"><button type="button" class="btn btn-outline-info">Edit</button></a></td>
                        <td data-label="Action"><a href="subservice_delete.php?id=<?php echo $row['subservice_id']?>"><button type="button" class="btn btn-outline-danger">Delete</button></a></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                    </table>
                </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="btn.js"></script>
</body>
</html>