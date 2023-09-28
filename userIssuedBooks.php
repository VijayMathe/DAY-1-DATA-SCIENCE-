<?php
// Include the database connection file
session_start();
include("connection.php");

// Query to retrieve all the issued books for the current user
$userid = $_SESSION['userid'];
$query = "SELECT * FROM issued_books WHERE Reader_ID = '$userid'";
$result = mysqli_query($conn, $query);

// Check if the query executed successfully
if (!$result) {
    die("Error in query execution: " . mysqli_error($conn));
}

$total = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
    <link rel="stylesheet" href="userIssuedBooksCSS.css">
</head>
<body>
    <div class="right-side">
        <div class="welcome-container">
            <img src="user-icon-2.png" alt="User Icon">
            <h5><?php echo $_SESSION['username']; ?></h5>
        </div>
    </div>
    <div class="container">
        <h2 class="h2">Your issued Books</h2>
        <?php if($total != 0){ ?>
            <div class="table-container">
                <table border="2px">
                    <thead>
                        <tr>
                            <th>Book Name</th>
                            <th>Book ID</th>
                            <th>Reader Name</th>
                            <th>Issued Date</th>
                            <th>Return Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row["Book_Name"]; ?></td>
                            <td><?php echo $row["Book_ID"]; ?></td>
                            <td><?php echo $row["Reader_name"]; ?></td>
                            <td><?php echo $row["issued_Date"]; ?></td>
                            <td><?php echo $row["return_date"]; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <p>No records found..!</p>
        <?php } ?>
    </div>
</body>
</html>