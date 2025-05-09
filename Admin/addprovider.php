
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
    <title>Add Provider</title>
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
                    <p style="padding:5px;font-size:2.2rem">Add Service provider</p>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Provider Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Mobile No</th>
                        <th scope="col">Service Category</th>
                        <th colspan='3'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                        $count=1;
                        $value='pending';
                        include_once "connection.php";
                        $res = mysqli_query($con, "SELECT service_providers.provider_id,service_providers.provider_name, service_providers.email, service_providers.phone, service.service_name 
                        FROM service_providers INNER JOIN service ON service_providers.service_id = service.service_id 
                        WHERE service_providers.approved_action = '$value'");
                    
                        while($row=mysqli_fetch_array($res))
                        {

                    ?>
                  
                        <tr>
                        <th scope="row"><?php echo $count++ ?></th>
                        <td data-label="Provider Name"><?php echo $row['provider_name']?></td>
                        <td data-label="E-mail"><?php  echo $row['email'] ?></td>
                        <td data-label="Mobile No"><?php  echo $row['phone']?></td>
                        <td data-label="Service category"><?php echo $row['service_name']?></td>
                        <td data-label="Action"><a href="view.php?id=<?php echo $row['provider_id']?>"><button type="button" class="btn btn-outline-primary">View</button></a></td>
                        <td data-label="Action"><a href="verifyprovider.php?id=<?php echo $row['provider_id']?>"><button type="button" class="btn btn-outline-success">Verify</button></a></td>
                        <td data-label="Action"><a href="reject1provider.php?id=<?php echo $row['provider_id']?>"><button type="button" class="btn btn-outline-danger">Rejected</button></a></td>
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