<?php
session_start();
require 'connection.php';

if (isset($_GET['opsi'])) :

	$opsi = $_GET['opsi'];

if($opsi=="input") { //opsi input

	if (isset($_POST['outlook'])) { $outlook = $_POST['outlook']; } else { echo "outlook tidak ditemukan"; }
	if (isset($_POST['temperature'])) { $temperature = $_POST['temperature']; } else { echo "temperature tidak ditemukan"; }
	if (isset($_POST['humidity'])) { $humidity = $_POST['humidity']; } else { echo "humidity tidak ditemukan"; }
	if (isset($_POST['windy'])) { $windy = $_POST['windy']; } else { echo "windy tidak ditemukan"; }
	if (isset($_POST['play'])) { $play = $_POST['play']; } else { echo "play tidak ditemukan"; }

	$query = "INSERT INTO tb_testing (outlook, temperature, humidity, windy, play) VALUES ('$outlook', '$temperature', '$humidity', '$windy', '$play')";

	$insert = mysqli_query($koneksi,$query);

	if ($insert == false) {
		?>
		<script type='text/javascript'>
			alert('Gagal Menambah Data');
			window.location.href="index.php";
		</script>
		<?php
	}
	else {
		?>
		<script type='text/javascript'>
			alert('Sukses Menambah Data');
			window.location.href="index.php";
		</script>
		<?php
	}

} elseif($opsi=="edit") { //opsi update

	if (isset($_POST['id'])) {$id = $_POST['id']; } else {echo "id tidak ditemukan"; }
	if (isset($_POST['outlook'])) { $outlook = $_POST['outlook']; } else { echo "outlook tidak ditemukan"; }
	if (isset($_POST['temperature'])) { $temperature = $_POST['temperature']; } else { echo "temperature tidak ditemukan"; }
	if (isset($_POST['humidity'])) { $humidity = $_POST['humidity']; } else { echo "humidity tidak ditemukan"; }
	if (isset($_POST['windy'])) { $windy = $_POST['windy']; } else { echo "windy tidak ditemukan"; }
	if (isset($_POST['play'])) { $play = $_POST['play']; } else { echo "play tidak ditemukan"; }

	$query = "UPDATE tb_testing SET outlook='$outlook', temperature='$temperature', humidity='$humidity', windy='$windy', play='$play' WHERE id= '$id'";

	$update = mysqli_query($koneksi,$query);
	
	if ($update == false) {
		?>
		<script type='text/javascript'>
			alert('Gagal Mengubah Data');
			window.location.href="index.php";
		</script>
		<?php
	}
	else {
		?>
		<script type='text/javascript'>
			alert('Sukses Mengubah Data');
			window.location.href="index.php";
		</script>
		<?php
	}	

} elseif($opsi=="delete") { //opsi delete
	if (isset($_GET['id'])) {$id = $_GET['id']; } else {echo "id tidak ditemukan";}

	// hapus data
	$query = "DELETE FROM tb_testing WHERE id = $id";
	$delete = mysqli_query($koneksi,$query);

	// panggil data id paling terakhir
	$query = "SELECT id FROM tb_testing ORDER BY id DESC";
	$result = mysqli_query($koneksi,$query);
	$id_desc = mysqli_fetch_assoc($result);
	// jumlahkan data id terakhir
	$ai = $id_desc['id']+1;

	// tetapkan auto incremet baru agar kembali terurut dari data sembelumnya
	$query = "ALTER TABLE tb_testing auto_increment=$ai";
	$alter = mysqli_query($koneksi,$query);

	if ($delete == false) {
		?>
		<script type='text/javascript'>
			alert('Gagal Menghapus Data');
			window.location.href="index.php";
		</script>
		<?php
	}
	else {
		?>
		<script type='text/javascript'>
			alert('Sukses Menghapus Data');
			window.location.href="index.php";
		</script>
		<?php
	}
}

endif;
?>