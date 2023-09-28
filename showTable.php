<?php
include("connection.php");
// error_reporting(0);
$query = "SELECT * FROM book_details";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);

if($total != 0){
	?>

	<table border="3px">
		<th>Book Name</th>
		<th>Book Author</th>
		<th>Book ID</th>
		<th>Quantity Available</th>

	<?php
	while ($result = mysqli_fetch_assoc($data)) {
		echo "<tr>
				<td>".$result["book-name"]."</td>
				<td>".$result["Author_Of_The_Book"]."</td>
				<td>".$result["Book_ID"]."</td>
				<td>".$result["Quantity"]."</td>
			</tr>
			";
	}
}
else{
	echo "No records found..!";
}

?>
</table>