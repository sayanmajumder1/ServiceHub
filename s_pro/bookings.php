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
    <title>Accept Booking | Service Provider</title>
    <link rel="stylesheet" href="style.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

    <h1 class="page-title">Bookings Request</h1>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Booking Date & Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
                                     
                 include_once "connection.php";
                $res=mysqli_query($con,"select booking.*,users.name,users.address from booking inner join users on booking.user_id=users.user_id 
                 
                where provider_id='".$_SESSION['id']."' and booking_status='pending'");
                 $count=1;
                 while($row=mysqli_fetch_array($res))
                {
            ?>
            <tbody>
                <tr>
                    <td><?php   echo $count++?></td>
                    <td><?php   echo $row['name']?></td>
                    <td><?php   echo $row['address']?></td>
                    <td><?php   echo $row['booking_time']?></td>
                    <td>
                        <a href="acceptbook.php?id=<?php echo $row['booking_id']?>"><button class="btn-accept">Accept</button>
                        <a href="rejectbook.php?id=<?php echo $row['booking_id']?>"><button class="btn-reject">Reject</button>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>
<script src="script.js"></script>
</body>
</html>
