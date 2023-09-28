<?php
// Include the database connection file
session_start();
include("connection.php");

// Query to retrieve all the issued books for the current user
$userid = $_SESSION['userid'];
$query = "SELECT * FROM library_record";
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
    <title>Library Record</title>
    <link rel="stylesheet" href="userIssuedBooksCSS.css">
</head>
<body>
    <div class="container">
        <h2>The Library Record</h2>
        <?php if($total != 0){ ?>
            <div class="table-container">
                <table border="2px">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Book ID</th>
                            <th>User Name</th>
                            <th>User ID</th>
                            <th>Issued Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row["Book_Title"]; ?></td>
                            <td><?php echo $row["Book_ID"]; ?></td>
                            <td><?php echo $row["User_name"]; ?></td>
                            <td><?php echo $row["User_ID"]; ?></td>
                            <td><?php echo $row["issued_Date"]; ?></td>
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