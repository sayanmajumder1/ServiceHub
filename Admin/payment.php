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
    <title>Payment</title>
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
                    <p style="padding:5px;font-size:2.2rem">Payment Details</p>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Booking No</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Service Provider</th>
                        <th scope="col">Service Category</th>
                        <th scope="col">Payment status</th>
                        <th colspan='2'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        include_once "connection.php";
                        $count=1;
                        $res=mysqli_query($con,"SELECT booking.*, users.name, users.email, service_providers.provider_name, service.service_name FROM
                        booking JOIN users ON booking.user_id = users.user_id JOIN service_providers ON booking.provider_id = service_providers.provider_id 
                        JOIN service ON booking.service_id = service.service_id");
                        while($row=mysqli_fetch_array($res))
                        {

                    ?>
                        <tr>
                        <th scope="row"><?php  echo $count++?></th>
                        <td data-label="Booking No"><?php  echo $row['booking_no']?></td>
                        <td data-label="User Name"><?php  echo $row['name']?></td>
                        <td data-label="Service Provider"><?php  echo $row['provider_name'] ?></td>
                        <td data-label="Service"><?php  echo $row['service_name']?></td>
                         <td data-label="status"><?php  echo $row['payment_status']?></td>
                        <td data-label="Action"><a href="paymentview.php?id=<?php echo $row['booking_id']; ?>"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Refund</button></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="btn.js"></script>
</body>
</html>