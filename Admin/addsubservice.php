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
    <title>Add service</title>
    <!-- Bootstrap 5 CSS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="hideScrollbar.css">
    <style>
                body {
            background: #f8f9fa; /* light gray background */
        }
        .card {
            max-width: 600px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 12px 36px rgba(0,0,0,0.15);
        }
        h2 {
            color: #6f42c1; /* nice purple accent */
            margin-bottom: 1.5rem;
        }
        .form-control, .form-select {
            border-radius: 8px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 8px rgba(111, 66, 193, 0.3);
        }
        .btn-outline-success {
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .btn-outline-success:hover {
            background-color: #6f42c1;
            color: white;
            border-color: #6f42c1;
        }
        .modal-header{
            background-color:rgb(150, 60, 186);
            color: white;
        }
       
    </style>
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
      
<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
  <div class="mx-3 w-100">
    <div class="card p-4">
      <div class="card-body">
        <h2 class="text-center">Add Sub Services</h2>
        <form method="POST" action="subservice_data.php" enctype="multipart/form-data" novalidate>
          <div class="mb-4">
            <label for="s_id" class="form-label">Service Name:</label>
            <select id="s_id" name="s_id" class="form-select" required>
              <option selected disabled>Select Service</option>
              <?php
                include_once "connection.php";
                $res = mysqli_query($con, "SELECT * FROM service");
                while ($row = mysqli_fetch_array($res)) {
              ?>
                <option value="<?php echo $row['service_id'] ?>">
                  <?php echo htmlspecialchars($row['service_name']); ?>
                </option>
              <?php } ?>
            </select>
          </div>

          <div class="mb-4">
            <label for="sub_name" class="form-label">Sub Service Name:</label>
            <input type="text" name="sub_name" id="sub_name" class="form-control" placeholder="Enter Sub Service Name" required>
          </div>

          <div class="mb-4">
            <label for="s_des" class="form-label">Sub Service Description:</label>
            <input type="text" name="s_des" id="s_des" class="form-control" placeholder="Enter Service Description" required>
          </div>

          <div class="mb-4">
            <label for="s_img" class="form-label">Images:</label>
            <input type="file" name="s_img" id="s_img" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-outline-success w-100">Add Sub Services</button>
        </form>
      </div>
    </div>
  </div>
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
        if (isset($_GET['add']) && $_GET['add'] == 1)
        {
        ?>
            Sub Service added Successfully!
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
    
    <script src="btn.js"></script>
<?php 
 
 if(isset($_GET['add']) && $_GET['add'] == 1)
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