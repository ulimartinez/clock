<?php

//connect to the database
$conn = new mysqli("129.108.32.61", "ctis", "19691963", "clock");
// Check connection
if ($conn -> connect_error) {
	die("Connection failed: " . $con -> connecterror);
}
