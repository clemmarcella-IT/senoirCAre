<?php
$conn=mysqli_connect("localhost","root","","seniorcare_newdb");
if(!$conn){
	("Connection Failed:" . mysqli_connect_error());
}
?>