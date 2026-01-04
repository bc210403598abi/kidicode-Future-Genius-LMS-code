<?php 
session_start();
if (!isset($_SESSION['authemail']) AND !isset($_SESSION['authemail']) AND $_SESSION['user_types']!='admin' ) {
	header('location:../index.php');
}else {
	require_once 'db.php';
	$stquery = "SELECT * FROM users WHERE email =  '$_SESSION[authemail]' ";
	$stdata = mysqli_fetch_assoc(mysqli_query($conn, $stquery));
	$userid =  $stdata['id'];
	$full_name =  $stdata['full_name'];
	$email =  $stdata['email'];
	$dob =  $stdata['dob'];
	$password =  $stdata['password'];
	$user_type =  $stdata['user_type'];
	$profile =  $stdata['profile'];
    $status =  $stdata['status'];
}
?>