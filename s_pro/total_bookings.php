<?php

  session_start();
  
	 

     if(!isset($_SESSION["email"]))
     {
         header("location:/project_php/serviceHub/Signup_login/login.php");
         exit;
     }



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Total Bookings</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content p-4">
  <h2 class="mb-4">Total Bookings Overview</h2>

  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card text-white bg-success h-100 shadow">
        <div class="card-body">
          <h5 class="card-title ">Accepted Bookings</h5>
          <?php
                                     
            include_once "connection.php";
            $res=mysqli_query($con,"select count(*) as total from booking where provider_id='".$_SESSION['id']."' and booking_status='accepted'");
            $row=mysqli_fetch_array($res);
          ?>
          <p class="card-text fs-4"><?php  echo $row['total'] ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card text-white bg-warning h-100 shadow">
        <div class="card-body">
          <h5 class="card-title ">Pending Bookings</h5>
          <?php
                                     
            include_once "connection.php";
            $res=mysqli_query($con,"select count(*) as total from booking where provider_id='".$_SESSION['id']."' and booking_status='pending'");
            $row=mysqli_fetch_array($res);
          ?>
          <p class="card-text fs-4"><?php  echo $row['total'] ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card text-white bg-danger h-100 shadow">
        <div class="card-body">
          <h5 class="card-title ">Rejected Bookings</h5>
          <?php
                                     
            include_once "connection.php";
            $res=mysqli_query($con,"select count(*) as total from booking where provider_id='".$_SESSION['id']."' and booking_status='rejected'");
            $row=mysqli_fetch_array($res);
          ?>
          <p class="card-text fs-4"><?php  echo $row['total'] ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5">
    <h4>Booking Records</h4>
    <table class="table table-bordered table-striped mt-3">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Customer Name</th>
          <th>Date & Time</th>
          <th>Status</th>
        </tr>
      </thead>
      <?php
                                     
        include_once "connection.php";
        $res=mysqli_query($con,"select booking.*,users.name from booking inner join users on booking.user_id=users.user_id where provider_id='".$_SESSION['id']."'");
        $count=1;
        while($row=mysqli_fetch_array($res))
        {
        ?>
       
      <tbody>
        <tr>
          <td><?php echo $count++?></td>
          <td><?php echo $row['name']?></td>
          <td><?php echo $row['booking_time']?></td>
          <td><?php echo $row['booking_status']?></td>
        </tr>
        <?php
        }
       ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
