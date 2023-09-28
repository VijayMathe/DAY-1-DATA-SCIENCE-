<?php include("connection.php");

session_start();

if(isset($_POST["issueBook"])){

    $bookName = $_POST['bookName'];
    $bookID = $_POST['bookID'];
    $username = $_SESSION['username'];
    $userid = $_SESSION['userid'];
    $issuedDate = date('Y/m/d');
    $returnDate = date('Y-m-d', strtotime($issuedDate . ' +10 days'));

    $resultContact = mysqli_query($conn, "SELECT User_Contact FROM library_users WHERE User_ID = $userid");
    $rowContact = mysqli_fetch_array($resultContact);
    $readerContact = strval($rowContact['User_Contact']);

    $resultEmail = mysqli_query($conn, "SELECT User_Email FROM library_users WHERE User_ID = $userid");
    $rowEmail = mysqli_fetch_array($resultEmail);
    $readerEmail = strval($rowEmail['User_Email']);

    $resultGender = mysqli_query($conn, "SELECT User_Gender FROM library_users WHERE User_ID = $userid");
    $rowGender = mysqli_fetch_array($resultGender);
    $readerGender = strval($rowGender['User_Gender']);

    $query = "SELECT * FROM book_details WHERE `book-name` = '$bookName' AND `Book_ID` = '$bookID'";
    $data = mysqli_query($conn, $query);

    $total = mysqli_num_rows($data);

    // if book exists in the database
    if($total == 1){
        $result = mysqli_fetch_assoc($data);
        $quantity = $result['Quantity'];

        // if book is available
        if($quantity > 0){ 
            $bookInsertQuery = "INSERT INTO issued_books VALUES('$bookName', '$bookID', '$username', '$userid', '$issuedDate', '$returnDate', '$readerContact', '$readerEmail', '$readerGender')";
            $issuedData = mysqli_query($conn, $bookInsertQuery);

            $query = "UPDATE book_details SET `Quantity` = `Quantity` - 1 WHERE `book-name` = '$bookName' AND `Book_ID` = '$bookID'";
            $data = mysqli_query($conn, $query);

            if($data){
                $message = "Book issued successfully!";
                // if the quantity becomes zero, delete the book
                $query = "DELETE FROM book_details WHERE `book-name` = '$bookName' AND `Book_ID` = '$bookID' AND `Quantity` = 0";
                $data = mysqli_query($conn, $query);
            }
            else{
                $message = "Failed to issue the book!";
            }
        }

        // if book is not available
        else{ 
            $message = "Sorry, this book is currently not available!";
        }
    }

    // if book does not exist in the database
    else{ 
        $message = "Sorry, this book is not available in our library!";
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
else{

}

if(isset($_POST["searchBook"])){
    $bookName = $_POST['bookName'];

    $query = "SELECT * FROM book_details WHERE `book-name` LIKE '%$bookName%'";
    $data = mysqli_query($conn, $query);

    $total = mysqli_num_rows($data);
}
else{
    $query = "SELECT * FROM book_details";
    $data = mysqli_query($conn, $query);
    $total = mysqli_num_rows($data);
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Library User</title>
    <link rel="stylesheet" href="UserCSS.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <h2 class="h2">Library Available Books</h2>
            
            <?php if($total != 0){ ?>
                <table border="2px">
                    <th>Book Name</th>
                    <th>Book Author</th>
                    <th>Book ID</th>
                    <th>Quantity Available</th>
                <?php while ($result = mysqli_fetch_assoc($data)) { ?>
                    <tr>
                        <td><?php echo $result["book-name"]; ?></td>
                        <td><?php echo $result["Author_Of_The_Book"]; ?></td>
                        <td><?php echo $result["Book_ID"]; ?></td>
                        <td><?php echo $result["Quantity"]; ?></td>
                    </tr>
                <?php } ?>
                </table>
            <?php } else { ?>
                <p>No records found..!</p>
            <?php } ?>
        </div>
        <div class="right-side">
            <div class="welcome-container">
                <img src="user-icon-2.png" alt="User Icon">
                <h5><?php echo $_SESSION['username']; ?></h5>
                <form method='POST'>
                    <input type='hidden' name='bookID'>
                    <button class='btn logout' type='button' name='logout' onclick="location.href='loginPage.php'; alert('Successfully logged out!');">logout</button>
                </form>
            </div>
            <form id="search-form" method="POST">
                <div>
                    <div class="search-container">
                    <label for="book-name" class="bookname">Search for a book by name:</label>
                    <div class="search-input-container">
                        <input type="text" id="book-name" placeholder="Enter book name" name="bookName">
                            <button type="submit" name="searchBook" class="searchBTN">Search</button>
                        </div>
                    </div>
                </div>
            </form>
            <h2 id="h2"> Issue a Book</h2>
            <form id="issue-form" method="POST">
                <div class="issue-book-form">
                    <label for="book-name" class="bookname">Book Name:</label>
                    <input type="text" id="book-name" placeholder="Enter Book name" name="bookName" required>
                    <br>
                    <label for="book-id" class="bookid">Book ID:</label>
                    <input type="text" id="book-id" placeholder="Enter Book ID" name="bookID" required>
                    <button type="submit" name="issueBook">Issue Book</button>
                </div>
            </form>
                <button type="button" name="seeIssuedBooks" onclick="location.href='userIssuedBooks.php';">See Your Issued Books</button>

            <?php if(isset($message)){ ?>
                <div id="message"><?php echo $message; ?></div>
            <?php } ?>
        </div>
    </div>
    <script src="UserJs.js"></script>
</body>
</html>