<?php
$conn=mysqli_connect("localhost","root","","seniorcaredb");
if(!$conn){
	("Connection Failed:" . mysqli_connect_error());
}
?>