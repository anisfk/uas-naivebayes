<?php
$host		= "sql201.ezyro.com";
$user		= "ezyro_32422795";
$pass		= "bvbf9qz7o6";
$db			= "ezyro_32422795_anis";

$koneksi	= mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
	die("tidak bisa terkoneksi");
}
?>