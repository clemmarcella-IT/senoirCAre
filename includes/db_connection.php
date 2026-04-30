<?php
$conn=mysqli_connect("localhost","root","","senior_caredb");
if(!$conn){
	("Connection Failed:" . mysqli_connect_error());
}
?>