const form = document.getElementById("login-form");

form.addEventListener("submit", function(event) {
	event.preventDefault();

	const usertype = document.getElementById("usertype").value;

	if (usertype === "admin") {
		window.location.href = "adminPage.php";
	} else if (usertype === "user") {
		window.location.href = "userPage.php";
	}
});
  
document.getElementById("newAcc-btn").addEventListener("click", function() {
    window.location.href = "createAccount.php";
});
