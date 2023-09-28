<?php
session_start();
include("connection.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form inputs
  $username = $_POST['userName'];
  $userid = $_POST['userID'];
  $password = $_POST['password'];
  $usertype = $_POST['userType'];

  // Prepare the SQL query to check for the user's credentials
  if($usertype == 'admin') {
    $select_query = "SELECT * FROM library_admins WHERE User_Password='$password'";
  }
  else if($usertype == 'user') {
    $select_query = "SELECT * FROM library_users WHERE User_Password='$password'";
  }

  // Execute the query
  $result = mysqli_query($conn, $select_query);

  // Check if the query returned any rows
  if(mysqli_num_rows($result) > 0) {
    // Save the user's data in the session
    $user = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $user['User_Name'];
    $_SESSION['userid'] = $user['User_ID'];
    $_SESSION['usertype'] = $usertype;

    // Redirect to the appropriate page based on the user's type
    if($usertype == 'admin') {
      header("Location: adminPage.php");
      exit();
    }
    else if($usertype == 'user') {
      header("Location: UserPage.php");
      exit();
    }
  }
  else {
    // If the query did not return any rows, display an error message
    $error_message = "Invalid username, user ID, or password.";
  }

  // Close the database connection
  mysqli_close($conn);
}
else{
	$error_message = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <meta name = "viewport" content="width = device-width, initial-scale = 1">
  <link rel="stylesheet" href="style.css">
</head>
<body class="wholeBody">
  <div class="login-page">
    <div class="form">
      <h2 class="heading">Login To The Library</h2>
      <?php if(isset($error_message)) { ?>
        <div class="error-message"><?php if($error_message != null){echo $error_message; }else{echo "";}?></div>
      <?php } ?>
      <form id="login-form" method="POST">
        <label for="username">Username</label>
        <input type="text" placeholder="Enter username" id="username" required name ="userName">

        <label for="userid">User ID</label>
        <input type="text" placeholder="Enter user ID" id="userid" required name = "userID">

        <label for="password">Password</label>
        <input type="password" placeholder="Enter Password" id="password" required name = "password">

        <label for="usertype">User Type</label>
        <select id="usertype" required name="userType">
          <option value="">Select user type</option>
          <option value="admin">Admin</option>
          <option value="user">User</option>
        </select>

        <button type="submit" class="lgnBTN">Login</button>
        <button class="lgnBTN" type="submit" onclick="location.href='createAccount.php'">Create New Account</button>
      </form>
    </div>
  </div>
  <!-- <script src="IndexJS.js"></script> -->
</body>
</html>