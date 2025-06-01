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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

     <link rel="stylesheet" href="hideScrollbar.css">

  <style>
        .modal-header{
            background-color:rgb(150, 60, 186);
            color: white;
        }
       .btn {
    font-size: 0.95rem;
}

    </style>
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
                    <!-- <td>
                        <a href="acceptbook.php?id=<?php echo $row['booking_id']?>"><button class="btn-accept">Accept</button>
                        <a href="rejectbook.php?id=<?php echo $row['booking_id']?>"><button class="btn-reject">Reject</button>
                    </td> -->
                    <td>
                         <div class="d-flex flex-column flex-md-row gap-2">
                            
                            <a href="acceptbook.php?id=<?php echo $row['booking_id']?>" class="btn btn-success w-100 w-md-auto">
                                <i class="bi bi-check-circle"></i> Accept
                            </a>
                            <a href="rejectbook.php?id=<?php echo $row['booking_id']?>" class="btn btn-danger w-100 w-md-auto">
                                <i class="bi bi-x-circle"></i> Reject
                            </a>
                        </div> 
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Modal HTML -->
<div class="modal fade" id="acceptedModal"  aria-labelledby="acceptedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="acceptedModalLabel">Message</h1>
      </div>
      <div class="modal-body">
        <?php
        if (isset($_GET['accepted']) && $_GET['accepted'] == 1)
        {
        ?>
            The booking has been accepted.
        <?php
        }
        else if (isset($_GET['rejected']) && $_GET['rejected'] == 1)
        {
        ?>
            The booking has been rejected.
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
<script src="script.js"></script>
<?php 
    if (isset($_GET['accepted']) && $_GET['accepted'] == 1)
    {
?>
    <script>
        // Show modal when page loads if accepted=1 is present in URL
        var acceptedModal = new bootstrap.Modal(document.getElementById('acceptedModal'));
        acceptedModal.show();
    </script>
<?php
    }
    else if(isset($_GET['rejected']) && $_GET['rejected'] == 1)
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
