<?php
    require "template/header.php";
	session_start();
	require "core/conf.inc.php";
	
    if(!isAdmin()){
		header("location:../index.php");
	}

?>