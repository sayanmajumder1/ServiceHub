
<div class="sidebar bg text-white p-3 d-none d-lg-block" style="width: 250px; height: 100vh; overflow-y: auto;" id="sidebar">
    <div class="d-flex flex-column align-items-center mb-4">
        <!-- Add an Image -->
        <img src="img/i1.jpeg" alt="Admin" class="rounded-circle mb-2" style="width: 70px; height: 70px; object-fit: cover;">
        <h4><span>ServiceHub </span>| Admin</h4>
        <button class="btn btn-sm btn-outline-light d-lg-none mt-2" id="sidebarCollapse">
            <i class="bi bi-x"></i>
        </button>
    </div>
    
    <hr style="height: 2px; color:white;">
    
    <ul class="nav nav-pills flex-column">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link  hv1" onclick="dashboard_click()">
                <i class="bi bi-house me-2"></i> Dashboard
            </a>
        </li>

        <!-- Users -->
        <li class="nav-item">
            <a href="user.php" class="nav-link  hv1" onclick="user_click()">
                <i class="bi bi-people-fill me-2"></i>      Users
            </a>
        </li>

        <!-- Booking -->
        <li class="nav-item">
            <a href="booking.php" class="nav-link  hv1" onclick="booking_click()">
                <i class="bi bi-book-fill me-2"></i> Booking
            </a>
        </li>

        <!-- Service Section (Dropdown with Arrow) -->
        <li class="nav-item">
            <a class="nav-link  hv1 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#serviceMenu" role="button" aria-expanded="false" aria-controls="serviceMenu">
                <div><i class="bi bi-hammer me-2"></i> Service</div>
                <i class="bi bi-caret-down-fill transition" id="serviceArrow"></i>
            </a>
            <div class="collapse ps-3" id="serviceMenu" data-bs-parent="#sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="addservice.php" class="nav-link  hv1" onclick="service1_click()">Add Service</a>
                    </li>
                    <li class="nav-item">
                        <a href="manageservice.php" class="nav-link  hv1" onclick="service2_click()">Manage Service</a>
                    </li>
                     <li class="nav-item">
                        <a href="addsubservice.php" class="nav-link  hv1" onclick="service3_click()">Add Sub Service</a>
                    </li>
                     <li class="nav-item">
                        <a href="managesubservice.php" class="nav-link  hv1" onclick="service4_click()">Manage Sub Service</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Service Provider Section (Dropdown with Arrow) -->
        <li class="nav-item">
            <a class="nav-link hv1 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#providerMenu" role="button" aria-expanded="false" aria-controls="providerMenu">
                <div><i class="bi bi-person-gear me-2"></i> Service Provider</div>
                <i class="bi bi-caret-down-fill transition" id="providerArrow"></i>
            </a>
            <div class="collapse ps-3" id="providerMenu" data-bs-parent="#sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="addprovider.php" class="nav-link  hv1" onclick="sp1_click()">New Service Provider</a>
                    </li>
                    <li class="nav-item">
                        <a href="acceptprovider.php" class="nav-link  hv1" onclick="sp2_click()">Accepted Service Provider</a>
                    </li>
                    <li class="nav-item">
                        <a href="rejectprovider.php" class="nav-link  hv1" onclick="sp3_click()">Rejected Service Provider</a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Payment Section -->
        <li class="nav-item">
            <a href="payment.php" class="nav-link  hv1" onclick="payment_click()">
                <i class="bi bi-wallet me-2"></i> Payment
            </a>
        </li>

        <!-- feedback Section -->
        <li class="nav-item">
            <a href="feedback.php" class="nav-link  hv1" onclick="feedback_click()">
               <i class="bi bi-chat-left-text-fill me-2"></i> Feedback
            </a>
        </li>
       <!-- Setting Section (Dropdown with Arrow) -->
       <li class="nav-item">
            <a class="nav-link hv1 d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#providerMenu1" role="button" aria-expanded="false" aria-controls="providerMenu1">
                <div><i class="bi bi-person-gear me-2"></i> Settings</div>
                <i class="bi bi-caret-down-fill transition" id="providerArrow"></i>
            </a>
            <div class="collapse ps-3" id="providerMenu1" data-bs-parent="#sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="adminview.php" class="nav-link  hv1" onclick="se1_click()"><i class="bi bi-person"></i>   Admin Details</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link  hv1" onclick="se2_click()">🔓 Log out</a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>

