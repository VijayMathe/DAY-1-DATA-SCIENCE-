
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
			<h2 class="heading">Wallcome To The Library</h2>
			<form id="login-form">
				<label for="username">Username</label>
				<input type="text" placeholder="Enter username" id="username" required name ="userName">

				<label for="userid">User ID</label>
				<input type="text" placeholder="Enter user ID" id="userid" required name = "userID">

				<label for="userid">Password</label>
				<input type="text" placeholder="Enter Password" id="password" required name = "password">

				<label for="usertype">User Type</label>
				<select id="usertype" required name="userType">
					<option value="">Select user type</option>
					<option value="admin">Manager</option>
					<option value="user">User</option>
				</select>

				<button type="submit" class="lgnBTN">Login</button>
			</form>
		</div>
	</div>
	<script src="IndexJS.js"></script>
</body>
</html>