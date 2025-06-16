<?php
session_start();
include_once "db_connect.php";

if (!isset($_SESSION['user_id'])) {
  header("Location:/ServiceHub/Signup_Login/login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
  $user = mysqli_fetch_assoc($result);
  $image = $user['image'];
  $displayImage = !empty($image) ? 'assets/images/' . $image : 'assets/images/default_user.png';
} else {
  session_destroy();
  header("Location:/ServiceHub/Signup_Login/login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile Page</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-gray-50">
  <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
      <!-- Back Button -->
      <div class="mb-8">
        <button onclick="window.location.href='/ServiceHub/Homepage/home.php'" class="flex items-center space-x-2 text-purple-600 hover:text-purple-700 transition-colors">
          <i class="bi bi-arrow-left-circle text-xl"></i>
          <span class="font-medium">Back to Home</span>
        </button>
      </div>

      <!-- Profile Card -->
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden relative lg:w-2/3 lg:ml-20">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-32"></div>

        <!-- Profile Image -->
        <div class="flex justify-center -mt-20 relative">
          <div class="group relative">
            <img src="<?php echo $displayImage; ?>" class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover transition-transform duration-300 group-hover:scale-105" alt="Profile Picture">
            <form action="upload_profile.php" method="post" enctype="multipart/form-data">
              <input type="file" name="image" accept="image/*" id="uploadBtn" class="hidden" onchange="this.form.submit();">
              <button type="button" onclick="document.getElementById('uploadBtn').click();" class="absolute -bottom-2 right-2 bg-white p-2 rounded-full shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 hover:bg-gray-100">
                <i class="bi bi-pencil text-purple-600"></i>
              </button>
            </form>
          </div> 
        </div>

        <!-- Profile Content -->
        <div class="p-8 pt-6">

          <form action="upload_profile.php" method="post" class="space-y-6">
            <!-- Name Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
              <input type="text" name="first_name" value="<?php echo htmlspecialchars($user['name']); ?>" required
                class="w-full px-4 py-2 border border-purple-300 rounded-2xl focus:ring-2 focus:ring-purple-200 focus:border-purple-500 transition-all">
            </div>

            <!-- Email Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
              <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly
                class="w-full px-4 py-2 border border-gray-200 rounded-2xl bg-gray-100 cursor-not-allowed">
            </div>

            <!-- Address Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
              <textarea name="address" rows="3" placeholder="Enter your address"
                class="w-full px-4 py-2 border border-purple-300 rounded-2xl focus:ring-2 focus:ring-purple-200 focus:border-purple-500 transition-all"><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>

            <!-- Phone Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
              <input type="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required
                class="w-full px-4 py-2 border border-purple-300 rounded-2xl focus:ring-2 focus:ring-purple-200 focus:border-purple-500 transition-all">
            </div>

            <!-- Save Button -->
            <button type="submit" name="update_profile" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-2xl shadow-md transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
              Save Changes
            </button>
          </form>

          <!-- Logout Button -->
          <form action="logout.php" method="post" class="mt-6 text-center">
            <button type="submit" class="text-red-500 hover:text-red-600 font-medium transition-colors">
              Log Out
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>