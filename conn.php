<?php 

$conn = mysqli_connect('localhost', 'root', '', 'LOGIN');

if (!$conn) {
    die ("something went wrong" . mysqli_connect_error());
}


?>