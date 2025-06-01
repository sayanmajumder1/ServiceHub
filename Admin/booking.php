<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:adminlog.php");
        exit;
    }
    include_once "connection.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="hideScrollbar.css">
</head>
<body>
<div class="d-flex">
    <?php include_once "sidenav.php"; ?>
    <div class="main-content p-4" id="mainContent">
        <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
            <i class="bi bi-list"></i> Menu
        </button>
        <h2>Booking</h2>

        <div class="row">
            <?php
            $statuses = [
                'pending' => 'warning',
                'accepted' => 'success',
                'rejected' => 'danger',
                'completed' => 'primary'
            ];
            foreach ($statuses as $status => $color):
                $result = mysqli_query($con, "SELECT COUNT(*) AS total FROM booking WHERE booking_status='$status'");
                $data = mysqli_fetch_assoc($result);
            ?>
            <div class="col-sm-3 mb-2">
                <div class="card text-white bg-<?php echo $color; ?> h-100 shadow">
                    <div class="card-body status-filter" data-status="<?php echo $status; ?>" style="cursor:pointer">
                        <h5 class="card-title text-center text-capitalize"> <?php echo $status; ?> Booking</h5>
                        <h5 class="card-title text-center"><?php echo $data['total']; ?></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
            

        <div class="table-responsive"  id="bookingTableContainer" style="display: none;">
             <h2 class="mt-4"> Table</h2>

            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Booking No</th>
                    <th>User Name</th>
                    <th>Service Provider</th>
                    <th>Service Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="bookingTableBody">
                <?php
                $status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : '';
                $query = "SELECT booking.booking_id, booking.booking_no, users.name, service_providers.provider_name, service.service_name 
                          FROM booking 
                          JOIN users ON booking.user_id = users.user_id 
                          JOIN service_providers ON booking.provider_id = service_providers.provider_id 
                          JOIN service ON booking.service_id = service.service_id";

                if (!empty($status)) {
                    $query .= " WHERE booking_status = '$status'";
                }

                $res = mysqli_query($con, $query);
                $count = 1;
                while ($row = mysqli_fetch_array($res)):
                    ?>
                    <tr>
                        <th><?php echo $count++; ?></th>
                        <td data-label="Booking No"><?php echo $row['booking_no']; ?></td>
                        <td data-label="User Name"><?php echo $row['name']; ?></td>
                        <td data-label="Provider Name"><?php echo $row['provider_name']; ?></td>
                        <td data-label="Service Name"><?php echo $row['service_name']; ?></td>
                        <td>
                            <a href="bookview.php?id=<?php echo $row['booking_id']; ?>" class="btn btn-outline-primary">View</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="./js/bootstrap.bundle.min.js"></script>
 <script src="btn.js"></script>
<script>
    document.querySelectorAll('.status-filter').forEach(card => {
        card.addEventListener('click', function () {
            const status = this.dataset.status;
            const form = new FormData();
            form.append('status', status);

            fetch('', {
                method: 'POST',
                body: form
            })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTable = doc.querySelector('#bookingTableBody');
                    const tableContainer = document.querySelector('#bookingTableContainer');

                    if (newTable) {
                        document.querySelector('#bookingTableBody').innerHTML = newTable.innerHTML;
                        tableContainer.style.display = 'block'; // Show table
                    }
                });
        });
    });
</script>

</body>
</html>
