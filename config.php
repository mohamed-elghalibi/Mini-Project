<?php
$conn=new mysqli("localhost","root","","todo_list");
if($conn->connect_error){
    die("error".$conn->connect_error);
}
?>