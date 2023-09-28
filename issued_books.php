<?php include("connection.php"); 

$query = "SELECT * FROM issued_books";
$data = mysqli_query($conn, $query);

if (!$data) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}

$total = mysqli_num_rows($data);


if(isset($_POST["searchBook"])){

    $bookName = $_POST['bookName'];

    $query = "SELECT * FROM issued_books WHERE `Book_Name` LIKE '%$bookName%'";
    $data = mysqli_query($conn, $query);

    $total = mysqli_num_rows($data);
}
else{
    $query = "SELECT * FROM issued_books";
    $data = mysqli_query($conn, $query);
    $total = mysqli_num_rows($data);
}

if(isset($_POST["removeBook"])){
    $bookID = $_POST['bookID'];
    $delete_query = "DELETE FROM issued_books WHERE Book_ID = '$bookID'";
    $delete_data = mysqli_query($conn, $delete_query);
        
    if($delete_data){
        $message = "Book removed successfully!";
    }
    else{
        $message = "Failed to remove the book..!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Issued Books</title>
    <link rel="stylesheet" type="text/css" href="issued_books_CSS.css">
</head>
<body>
    <div class="container">
        <div class="left">
            <h1>Issued Books</h1>

            <div>
                <div class="search-container">
                <label for="book-name" class="bookname">Search for a book by name:</label>
                <div class="search-input-container">
                    <input type="text" id="book-name" placeholder="Enter book name" name="bookName">
                        <button type="submit" name="searchBook" class="searchBTN">Search</button>
                    </div>
                </div>
            </div>


            <?php
            if($total != 0){
            ?>
            <h3>Total Issued books : <span id="total-books"><?php echo $total; ?></span></h3>

            <table border="3px">
                <th>Book Name</th>
                <th>Book ID</th>
                <th>Reader Name</th>
                <th>Reader ID</th>
                <th>Issued Date</th>
                <th>Return Date</th>
                <th>Reader Contact</th>
                <th>Reader Email ID</th>
                <th>Returned the book to the library ?</th>

            <?php
                while ($result = mysqli_fetch_assoc($data)) {
                    $bookID = $result["Book_ID"];
                    $returnDate = $result["return_date"];
                    $today = date('Y-m-d');
                    $color = (strtotime($returnDate) < strtotime($today)) ? 'color:red;' : ''; // Check if return date has passed away and set the style attribute accordingly
                    echo "<tr>
                            <td>".$result["Book_Name"]."</td>
                            <td>".$result["Book_ID"]."</td>
                            <td>".$result["Reader_name"]."</td>
                            <td>".$result["Reader_ID"]."</td>
                            <td>".$result["issued_Date"]."</td>
                            <td style='".$color."'>".$result["return_date"]."</td>
                            <td>".$result["Reader_Contact"]."</td>
                            <td>".$result["Reader_Email_ID"]."</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='bookID' value='".$result["Book_ID"]."'>
                                    <button class='btn delete' type='submit' name='removeBook'>Yes</button>
                                </form>
                            </td>
                          </tr>";
                }

            }
            else{

                echo "No records found..!";
            }

            ?>
            </table>
        </div>
    </div>

    <!-- <script src="adminJs.js"></script> -->
</body>
</html>
