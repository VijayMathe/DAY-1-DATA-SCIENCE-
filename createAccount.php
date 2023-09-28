<?php
session_start();
include("connection.php");

if(isset($_POST["createAcc"])){
  
  $userName = $_POST['userName'];
  $userID = $_POST['userID'];
  $password = $_POST['password'];
  $userAge = $_POST['userAge'];
  $userContactNo = $_POST['userContactNo'];
  $userEmailID = $_POST['userEmailID'];
  $userType = $_POST['userType'];

  $query1 = "INSERT INTO library_users VALUES ('$userName', '$userID', '$password', '$userAge', '$userContactNo', '$userEmailID', '$userType')";

  mysqli_query($conn, $query1);
  
  if(mysqli_affected_rows($conn) > 0) {
    //  echo "Account Created Successfully";
  }

  header("Location: ".$_SERVER['PHP_SELF']);
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Page</title>
  <meta name = "viewport" content="width = device-width, initial-scale = 1">
  <link rel="stylesheet" href="style.css">
  <style>
    .form {
      display: flex;
      justify-content: space-between;
      width: 84%;
    }
    .form > div {
      width: 45%;
    }
    .form > div > label,
    .form > div > input {
      display: block;
      margin-bottom: 10px;
    }
    .heading {
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body class="wholeBody">
  <div class="login-page">
    <h2 class="heading">Create New Account for the Library</h2>
    <form method="post">
      <div class="form">
        <div>
          <label for="username">Username</label>
          <input type="text" placeholder="Enter username" id="username" required name ="userName">
          <label for="userid">User ID</label>
          <input type="number" placeholder="Enter user ID" id="userid" required name="userID">
          <label for="password">Password</label>
          <input type="password" placeholder="Enter Password" id="password" required name="password">
        </div>
        <div>
          <label for="userage">Age</label>
          <input type="number" placeholder="Enter your Age" id="userAge" required name="userAge">
          <label for="usercontact">Contact Number</label>
          <input type="text" placeholder="Enter your Contact Number" id="userContact" required name="userContactNo">
          <label for="useremail">Email ID</label>
          <input type="email" placeholder="Enter your Email ID" id="userEmailID" required name="userEmailID">
          <label for="usertype">Gender</label>
          <select id="usertype" required name="userType">
            <option value="">Select gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
      </div>
      <button type="submit" class="lgnBTN" id="login-btn" name="createAcc">Create Account</button>
    </form>
  </div>
  <script src="IndexJS.js"></script>
</body>
</html>