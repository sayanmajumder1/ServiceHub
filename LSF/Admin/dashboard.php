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
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet" >
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="custom.css">
</head>
<body>
    <div class="d-flex ">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-3 d-none d-lg-block" style="width: 250px;" id="sidebar">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>ServiceHub | Admin</h4>
                <button class="btn btn-sm btn-outline-light d-lg-none" id="sidebarCollapse">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            <hr  style=" height: 2px; color:white ;">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item ">
                    <a href="#" class="nav-link hv1 "  onclick="dashboard_click()">
                        <i class="bi bi-house me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link hv1"  onclick="booking_click()">
                        <i class="bi bi-book-fill"></i> Booking
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle hv1 "  role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                    <i class="bi bi-hammer"></i>  Service
                    </a>
                    <ul class="dropdown-menu bg-dark">
                        <li><a href="#" class="dropdown-item hv1 bg-dark"  onclick="service1_click()">Add Service</a></li>
                        <li><a href="#" class="dropdown-item hv1 bg-dark"  onclick="service2_click()">Manage Service</a></li>
                    </ul>
                </li>
        
                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link dropdown-toggle hv1"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-gear"></i>  Service Provider
                    </a>
                    <ul class="dropdown-menu bg-dark">
                        <li><a href="#" class="dropdown-item hv1 bg-dark "  onclick="sp1_click()">New Service Provider </a></li>
                        <li><a href="#" class="dropdown-item hv1 bg-dark "  onclick="sp2_click()">Manage Service Provider</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link hv1"  onclick="payment_click()">
                        <i class="bi bi-wallet"></i> Payment
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content p-4" id="mainContent">
            <button class="btn btn-primary d-lg-none mb-3" id="sidebarToggle">
                <i class="bi bi-list"></i> Menu
            </button>
    
            <div id="ui1">
                <div class="o35">
                    <p style="padding:5px;font-size:2.4rem">Dashboard </p>
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card c1">
                            <div class="card-body">
                                <div style="display: flex; justify-content: center;">
                                    <i class="bi bi-person-fill s1"></i> 
                                </div>
                                <h5 class="card-title"style="text-align:center">  Total User</h5>

                            </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card c1">
                            <div class="card-body">
                                <div style="display: flex; justify-content: center;">
                                    <i class="bi bi-person-gear s1"></i>
                                </div>
                                <h5 class="card-title" style="text-align:center">  Total Service provider</h5>
   
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="row r1">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card c1">
                            <div class="card-body">
                                <div style="display: flex; justify-content: center;">
                                    <i class="bi bi-hammer s1"></i>
                                </div>
                                <h5 class="card-title"style="text-align:center">   Total Services</h5>
     
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card c1">
                            <div class="card-body">
                                <div style="display: flex; justify-content: center;">
                                    <i class="bi bi-book s1"></i>
                                </div>
                                <h5 class="card-title"style="text-align:center">  Total Booking</h5>
                    
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ui2">
                <div class="o35">
                    <p style="padding:5px;font-size:2.2rem">Booking Details</p>
                    <div class="table-responsive">
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Booking No</th>
                        <th scope="col">User Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Service Provider</th>
                        <th scope="col">Service category</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td  data-label="Booking No">B11</td>
                        <td  data-label="User Name">Mark</td>
                        <td  data-label="E-mail">Otto@gmail.com</td>
                        <td  data-label="Service Provider">Sayan majumdar</td>
                        <td  data-label="Service category">Electrician</td>
                        <td  data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr>
                        <!-- <tr>
                        <th scope="row">2</th>
                        <td data-label="Booking No">B11</td>
                        <td data-label="User Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Service Provider">Sayan majumdar</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td data-label="Booking No">B12</td>
                        <td data-label="User Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Service Provider">Sayan majumdar</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr>
                        <tr>
                        <th scope="row">4</th>
                        <td data-label="Booking No">B14</td>
                        <td data-label="User Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Service Provider">Sayan majumdar</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        </tr> -->
                    </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div id="ui3">
                    <div class="o35">
                    <div class="col-md-8">
                        <div class="card-body ab2">
                            <h2>Add Services:</h2>
                            <p class="card-text"> 
                            <form method="POST" action="service_data.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label>Service Name:</label><br>
                                    <input type="text" name="s_name" id="s_name" Placeholder="Enter Service Name"class="con1" required>
                                </div>
                                <div class="mb-3">
                                    <label>Service Description:</label><br>
                                    <input type="text" name="s_des" id="s_des" Placeholder="Enter Service Description"class="con1"required>
                                </div>
                              
                                <div class="mb-3">
                                    <label>Images:</label><br>
                                    <input type="file" name="s_img" id="s_img" class="con1"required>
                                </div>
                                <button type="submit" class="btn btn-outline-success">Add Services</button>
                            </form>
                            </p>
                        </div>
                        </div>
                    </div>
            </div>
            <div id="ui4">
                <div class="o35">
                    <p style="padding:5px;font-size:2.2rem">Manage Services </p>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Service Name</th>
                        <th scope="col">Service Description</th>
                        <th colspan='2'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                            $count=1;
                            include_once "connection.php";
                            $res=mysqli_query($con,"select * from service");
                            while($row=mysqli_fetch_array($res))
                            {

                        ?>
                        <tr>
                        <th scope="row"><?php echo $count++?></th>
                        <td data-label="Image"><img src="./img/<?php echo $row['image']?> "height="125px"width="150px"></td>
                        <td data-label="Service Name"><?php echo $row['s_name'] ?></td>
                        <td data-label="Service Description"><?php echo $row['s_des'] ?></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-info">Edit</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Delete</button></td>
                        </tr>
                        <?php
                            }
                            

                        ?>
                    </tbody>
                    </table>
                </div>
            </div>
            <div id="ui5">
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
                        <th colspan='2'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td data-label="Provider Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Mobile No">123456789</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Verify</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Rejected</button></td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td data-label="Provider Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Mobile No">123456789</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Verify</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Rejected</button></td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td data-label="Provider Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Mobile No">123456789</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Verify</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Rejected</button></td>
                        </tr>
                        <tr>
                        <th scope="row">4</th>
                        <td data-label="Provider Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Mobile No">123456789</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Verify</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Rejected</button></td>
                        </tr>
                    </tbody>
                    </table>
                    </div>
            </div>
            <div id="ui6">
                <div class="o35">
                    <p style="padding:5px;font-size:2.2rem">Manage Service provider</p>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Provider Name</th>
                        <th scope="col">Service Category</th>
                        <th colspan='2'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td data-label="Provider Name">Mark</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Deactive</button></td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td data-label="Provider Name">Mark</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Deactive</button></td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td data-label="Provider Name">Mark</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Deactive</button></td>
                        </tr>
                        <tr>
                        <th scope="row">4</th>
                        <td data-label="Provider Name">Mark</td>
                        <td data-label="Service category">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-danger">Deactive</button></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
            <div id="ui7">
                <div class="o35">
                    <p style="padding:5px;font-size:2.2rem">Payment Details</p>
                    <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Booking No</th>
                        <th scope="col">User Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Service Provider</th>
                        <th scope="col">Service</th>
                        <th colspan='2'>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td data-label="Booking No">B11</td>
                        <td data-label="User Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Service Provider">Sayan majumdar</td>
                        <td data-label="Service">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Refund</button></td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td data-label="Booking No">B11</td>
                        <td data-label="User Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Service Provider">Sayan majumdar</td>
                        <td data-label="Service">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Refund</button></td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td data-label="Booking No">B12</td>
                        <td data-label="User Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Service Provider">Sayan majumdar</td>
                        <td data-label="Service">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Refund</button></td>
                        </tr>
                        <tr>
                        <th scope="row">4</th>
                        <td data-label="Booking No">B14</td>
                        <td data-label="User Name">Mark</td>
                        <td data-label="E-mail">Otto@gmail.com</td>
                        <td data-label="Service Provider">Sayan majumdar</td>
                        <td data-label="Service">Electrician</td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-primary">View</button></td>
                        <td data-label="Action"><button type="button" class="btn btn-outline-success">Refund</button></td>
                        </tr>
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