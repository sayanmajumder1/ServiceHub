<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css" />
 <style> 
 /* ===================== User Profile  Section  ===================== */
 /* Profile Section  Style */
 .profile-pic {
  display: block;
  margin: 0 auto;
  border: 4px solid #fff;
  border-radius: 50%;
  width: 100px;
  height: 100px;
  object-fit: cover;
  background-color: #fff;
  position: relative;
  z-index: 1;
  transition: transform 0.3s ease;
}

.profile-pic:hover {
  transform: scale(1.05);
}

.animated-profile {
  animation: fadeSlideIn 1s ease-in-out;
}

@keyframes fadeSlideIn {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Edit button style */
.edit-btn-profile {
  position: absolute;
  bottom: -5px;
  right: calc(50% - 20px);
  transform: translateX(50%);
  border-radius: 50%;
  padding: 6px 9px;
  background-color: #fff;
  color: #333;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  border: none;
  display: none;
  transition: all 0.3s ease;
  z-index: 2;
}

.edit-btn-profile i {
  font-size: 16px;
  cursor: pointer;
}

.edit-btn-profile:hover {
  background-color: #f0f0f0;
}

.position-relative:hover .edit-btn-profile {
  display: block;
}

.form-control,
.form-select {
  border-radius: 20px;
}

.gender-btn-group .btn {
  border-radius: 20px;
  padding: 8px 20px;
}

.save-btn {
  border-radius: 30px;
  padding: 10px;
  font-weight: 600;
}

.profile-card {
  max-width: 500px;
  margin: auto;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
  position: relative;
  padding-top: 60px;
}

/* Back Button Style */
.back-btn {
  background-color: #ad67c8;
  color: #fff;
  border: none;
  border-radius: 30px;
  padding: 8px 20px;
  font-weight: 600;
  transition: background-color 0.3s ease, transform 0.2s ease;
  box-shadow: 0 4px 12px rgba(173, 103, 200, 0.3);
  padding-bottom:5px;
  
}

.back-btn i {
  margin-right: 6px;
}

.back-btn:hover {
  background-color: #9a56b2;
  transform: translateY(-1px);
}
.button-padding{
  padding-bottom:15px;
  position: relative;
}



/*From Styling */
/* Base button styling */
/* Base button styling */
/* Base button styling */
.custom-btn {
    background-color: #ad67c8 !important;
    border: 2px solid #ad67c8 !important;
    color: white;
    padding: 10px 20px; /* Make the button more spacious */
    font-size: 1rem; /* Adjust font size */
    font-weight: 600; /* Make text a bit bolder */
    border-radius: 30px; /* Rounded corners for a modern look */
    text-transform: uppercase; /* Make the text all uppercase */
    transition: all 0.3s ease; /* Smooth transition for hover effect */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
}

/* Hover effect with smoother transition */
.custom-btn:hover {
    background-color: #ad67c8 !important; /* Retain the original color on hover */
    border-color: #ad67c8 !important;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Bigger shadow for a lifted effect */
    transform: translateY(-4px); /* Slightly larger upward motion */
}

/* Focus effect for accessibility (when the button is focused via keyboard or mouse) */
.custom-btn:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(173, 103, 200, 0.5); /* Glow effect */
}

/* Active state (when the button is clicked) */
.custom-btn:active {
    background-color: #ad67c8 !important; /* Retain the original color when clicked */
    border-color: #ad67c8 !important; /* Keep the original border color */
    transform: translateY(1px); /* Slightly moves the button down when clicked */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Removes extra shadow on click */
}
.form-control{
  border-color: #ad67c8 !important;
}
input.form-control:focus {
    box-shadow: 0 0 0 2px rgba(173, 103, 200, 0.3); /* soft purple glow */
    outline: none;
    border-color: #ad67c8;
}

textarea.form-control:focus {
    box-shadow: 0 0 0 2px rgba(173, 103, 200, 0.3); /* soft custom glow */
    outline: none;
    border-color: #ad67c8; /* Matches your theme */
}

.password-text-button{
  padding-top:5px;
  
}


 </style>
</head>
<body class="bg-light">
  
<div class="container py-5">
  <div class = "button-padding">
 <!-- Back Button -->
 <button class="btn back-btn" onclick="history.back()">
          <i class="bi bi-arrow-left-circle"></i> Back
        </button>
</div>    

  <div class="card profile-card">

    <!-- Profile Image -->
    <div class="position-relative text-center" style="margin-top: -40px;">
      <img src="assets/images/logo2.png" class="img-fluid rounded-circle shadow profile-pic animated-profile" alt="Profile Picture">
      <button class="btn btn-light edit-btn-profile" title="Edit Photo">
        <i class="bi bi-pencil"></i>
      </button>
    </div>

    <!-- Profile Form -->
    <div class="card-body mt-3 pt-2">
      <h5 class="text-center mb-4">Profile</h5>

      <form>
        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" placeholder="First Name" value="Enter First Name ">
        </div>

        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" placeholder="Last Name" value="Enter Your Last Name ">
        </div>

        <div class="mb-3">
          <label class="form-label">E-mail</label>
          <input type="email" class="form-control" placeholder="Email" value="Enter Your Email">
        </div>

        <div class="mb-3">
          <label class="form-label">Date of Birth</label>
          <input type="text" class="form-control" placeholder="Enter Your D.O.B">
        </div>
        <div class="mb-3">
          <label class="form-label">Enter Your Phone No </label>
          <input type="phone" class="form-control" placeholder="Enter Your Phone No">
        </div>
        <div class="mb-3">
          <label class="form-label">Gender</label>
          <div class="btn-group w-100 gender-btn-group" role="group">
            <input type="radio" class="btn-check" name="gender" id="male" checked>

            <label class="btn  custom-btn" for="male">Male</label>

            <input type="radio" class="btn-check" name="gender" id="female">
            <label class="btn   custom-btn" for="female">Female</label>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label">Location</label>
          <textarea class="form-control" rows="3" placeholder="Location...">Enter Your Location </textarea>
        </div>

        <button type="submit" class="btn btn-secondary w-100 save-btn" disabled>Save Changes</button>
        <div class = "password-text-button ">
        <button type="submit" class="btn btn-link text-decoration-none text-secondary  justify-center p-0">Change The Password</button>

        </div>
      </form>
    </div>
  </div>
</div>


</body>
</html>
