<?php include("connection.php"); 

if(isset($_POST["addBook"])){
	
    $bookName = $_POST['bookName'];
    $authorName = $_POST['bookAuthor'];
    $bookID = $_POST['bookID'];
    $bookQuant = $_POST['bookQuant'];
    
    // Check if book already exists in database
    $query = "SELECT * FROM book_details WHERE Book_ID = '$bookID'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    
    if($count == 0){
        $insert_query = "INSERT INTO book_details VALUES('$bookName', '$authorName', '$bookID', '$bookQuant')";
        $insert_data = mysqli_query($conn, $insert_query);
        
        if($insert_data){
            $message = "Book added successfully!";
        }
        else{
            $message = "Failed to add the book..!";
        }
    }
    else{
        $message = "Book already exists in the library!";
        echo $message;
    }
}

if(isset($_POST["removeBook"])){
    $bookID = $_POST['bookID'];
    $delete_query = "DELETE FROM book_details WHERE Book_ID = '$bookID'";
    $delete_data = mysqli_query($conn, $delete_query);
        
    if($delete_data){
        $message = "Book removed successfully!";
    }
    else{
        $message = "Failed to remove the book..!";
    }
}

if(isset($_POST["increase"])){
    $bookID = $_POST['bookID'];
    $quantity = $_POST['quantity'];
    $operation = $_POST['operation'];
    $query = "UPDATE book_details SET Quantity = Quantity + 1 WHERE Book_ID = '$bookID'";
    $update_data = mysqli_query($conn, $query);
    if($update_data){
        $message = "Quantity increased successfully!";
        header("Location: ".$_SERVER['REQUEST_URI']); // Redirect the user to the same page
        exit(); // Exit the script to prevent further execution
    }
    else{
        $message = "Failed to increase Quantity..!";
    }
}


if(isset($_POST["decrease"])){
    $bookID = $_POST['bookID'];
    $quantity = $_POST['quantity'];
    $operation = $_POST['operation'];
    $query = "UPDATE book_details SET Quantity = Quantity - 1 WHERE Book_ID = '$bookID'";
    $update_data = mysqli_query($conn, $query);
    if($update_data){
        $message = "Quantity decreased successfully!";
        header("Location: ".$_SERVER['REQUEST_URI']); // Redirect the user to the same page
        exit(); // Exit the script to prevent further execution
    }
    else{
        $message = "Failed to decrease Quantity..!";
    }
}

$query = "SELECT * FROM book_details";
$data = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);


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
    <title>Welcome Admin</title>
    <link rel="stylesheet" type="text/css" href="adminCSS.css">
</head>
<body>
	<header>
    <div class="logo">
      <a href="#"><img src="library_logo.jpg" alt=""></a>
    </div>
    <nav>
      <p class="welcome">Welcome admin</p>
      <a href="library_record.php" class="see-library-record-btn">See Library Record</a>
      <button class='btn-logout' type='button' name='logout' onclick="location.href='loginPage.php'; alert('Successfully logged out!');">logout</button>
    </nav>
  </header>
    <div class="container">
        <div class="left">
            <h2>Library Available Book List</h2>
            <h3>Total Library books: <span id="total-books"><?php echo $total; ?></span></h3>

            <form id="search-form" method="POST">
                <div>
                    <div class="search-container">
                    <label for="book-name" class="bookname">Search for a book by name:</label>
                    <div class="search-input-container">
                        <input type="text" id="book_name_search" placeholder="Enter book name" name="bookName">
                            <button type="submit" name="searchBook" class="btn">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <?php
            if($total != 0){
            ?>

            <table border="3px">
                <th>Book Name</th>
                <th>Book Author</th>
                <th>Book ID</th>
                <th>Quantity Available</th>
                <th>Operation</th>

            <?php
                while ($result = mysqli_fetch_assoc($data)) {
                    $bookID = $result["Book_ID"];
    				echo "<tr>
			            <td>".$result["book-name"]."</td>
			            <td>".$result["Author_Of_The_Book"]."</td>
			            <td>".$bookID."</td>
			            <td>".$result["Quantity"]."</td>
			            <td>
			            	<form method='POST'>
			                    <input type='hidden' name='bookID' value='".$bookID."'>
			                <button class='btn add' name = 'increase' data-id='".$bookID."'>+</button>
			                </form>
			                <form method='POST'>
			                    <input type='hidden' name='bookID' value='".$bookID."'>
			                <button class='btn remove' name = 'decrease' data-id='".$bookID."'>-</button>
			                </form>
			                <form method='POST'>
			                    <input type='hidden' name='bookID' value='".$bookID."'>
			                    <button class='btn delete' type='submit' name='removeBook'>Remove</button>
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
        <div class="right">
            <h2>Add Book to the Library</h2>
            <form id="book-form" action="#" method="POST">
                <label for="bookName">Book Name:</label>
                <input type="text" id="book-name" placeholder="Enter Book Name" required name="bookName">
                <label for="bookAuthor">Author Name:</label>
                <input type="text" id="author-name" placeholder="Enter Book Author Name" required name="bookAuthor">
                <label for="book-id">Book ID:</label>
                <input type="text" id="book-id" placeholder="Enter Book ID"  required name="bookID">
                <label for="book-quantity">Quantity To Insert:</label>
                <input type="number" id="book-quantity" placeholder="Enter no.of Books" required name="bookQuant">
                <input class="btn" type="submit" value="Add Book" name="addBook">
                <input class="btn" type="button" value="Show All Issued Books" onclick="location.href='issued_books.php'" />
                

            </form>
            <div id="message"><?php echo isset($message) ? $message : ""; ?></div>
        </div>
    </div>

    <!-- <script src="adminJs.js"></script> -->
</body>
</html>