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
    <title>Ongoing Booking </title>
    <link rel="stylesheet" href="style.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">

    <h1 class="page-title">Ongoing Booking</h1>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Booking Date & Time</th>
                    <th>Booking status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
                                     
                 include_once "connection.php";
                $res=mysqli_query($con,"select booking.*,users.name,users.address from booking inner join users on booking.user_id=users.user_id 
                where provider_id='".$_SESSION['id']."' and booking_status='accepted'");
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
                    <td><?php   echo $row['booking_status']?></td>

                    <td>
                        <a href="viewbooking.php?id=<?php echo $row['booking_id']?>"><button class="btn btn-primary">View</button>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
<!-- Modal -->
<div class="modal fade" id="taskCompletedModal" tabindex="-1" aria-labelledby="taskCompletedLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskCompletedLabel">Task Completed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Your task has been completed successfully!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var myModal = new bootstrap.Modal(document.getElementById('taskCompletedModal'));
    myModal.show();
  });
</script>
<?php endif; ?>

</div>
<script src="script.js"></script>
</body>
</html>
