<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location:adminlog.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Service</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" />

  <link rel="stylesheet" href="custom.css" />
  <link rel="stylesheet" href="hideScrollbar.css" />

  <style>
    /* Background gradient for subtle depth */
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #f0eaff 0%, #e0d3ff 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Layout tweaks */
    .d-flex {
      gap: 1rem;
    }

    .main-content {
      flex-grow: 1;
      padding: 2rem;
      min-height: 100vh;
      overflow-y: auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(111, 66, 193, 0.1);
    }

    /* Card styling */
    .card {
      max-width: 600px;
      margin: auto;
      border-radius: 16px;
      box-shadow: 0 12px 36px rgba(111, 66, 193, 0.15);
      transition: box-shadow 0.3s ease;
    }
    .card:hover {
      box-shadow: 0 18px 48px rgba(111, 66, 193, 0.25);
    }

    /* Header style */
    h2 {
      color: #6f42c1;
      font-weight: 700;
      letter-spacing: 0.03em;
      margin-bottom: 2rem;
      text-align: center;
    }

    /* Form inputs */
    .form-control, .form-select {
      border-radius: 12px;
      border: 1.8px solid #ccc;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .form-control:focus, .form-select:focus {
      border-color: #6f42c1;
      box-shadow: 0 0 12px rgba(111, 66, 193, 0.35);
      outline: none;
    }

    /* Button style */
    .btn-outline-success {
      border-radius: 12px;
      font-weight: 700;
      padding: 0.6rem 0;
      letter-spacing: 0.02em;
      transition: background-color 0.3s ease, color 0.3s ease;
      font-size: 1.1rem;
    }
    .btn-outline-success:hover {
      background-color: #6f42c1;
      color: white;
      border-color: #6f42c1;
      box-shadow: 0 6px 15px rgba(111, 66, 193, 0.4);
    }

    /* Modal header with purple background */
    .modal-header {
      background-color: #6f42c1;
      color: white;
      border-bottom: none;
      border-top-left-radius: 16px;
      border-top-right-radius: 16px;
    }

    /* Modal button */
    .modal-footer .btn-primary {
      background-color: #6f42c1;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      padding: 0.5rem 1.5rem;
      transition: background-color 0.3s ease;
    }
    .modal-footer .btn-primary:hover {
      background-color: #563d7c;
    }
  </style>
</head>
<body>

<div class="d-flex">
  <!-- Sidebar -->
  <?php include_once "sidenav.php"; ?>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
      <i class="bi bi-list"></i> Menu
    </button>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
      <div class="w-100">
        <div class="card p-5">
          <div class="card-body">
            <h2>Add New Service</h2>
            <form method="POST" action="service_data.php" enctype="multipart/form-data" novalidate>
              <div class="mb-4">
                <label for="s_name" class="form-label">Service Name</label>
                <input type="text" name="s_name" id="s_name" class="form-control" placeholder="Enter Service Name" required />
              </div>
              <div class="mb-4">
                <label for="s_img" class="form-label">Image</label>
                <input type="file" name="s_img" id="s_img" class="form-control" accept="image/*" required />
              </div>
              <button type="submit" class="btn btn-outline-success w-100">Add Service</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="acceptedModal" tabindex="-1" aria-labelledby="acceptedModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <h5 class="modal-title" id="acceptedModalLabel">Message</h5>
      </div>
      <div class="modal-body">
        <?php if (isset($_GET['add']) && $_GET['add'] == 1): ?>
          Service added successfully!
        <?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="btn.js"></script>

<?php if (isset($_GET['add']) && $_GET['add'] == 1): ?>
<script>
  const acceptedModal = new bootstrap.Modal(document.getElementById('acceptedModal'));
  acceptedModal.show();

  // Remove query param after showing modal (optional)
  window.history.replaceState({}, document.title, window.location.pathname);
</script>
<?php endif; ?>

</body>
</html>
