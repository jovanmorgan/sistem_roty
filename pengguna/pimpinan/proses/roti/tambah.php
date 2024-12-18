<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_roti_list = $_POST['nama_roti'];
    $harga_list = $_POST['harga'];
    $berat_list = $_POST['berat'];
    $rasa_list = $_POST['rasa'];
    $vitamin_list = $_POST['vitamin'];
    $gula_list = $_POST['gula'];
    $deskripsi_list = $_POST['deskripsi'];
    $stok_list = $_POST['stok']; // Tambahkan ini
    $gambar_roti_list = $_FILES['gambar_roti']['name'];

    $upload_dir = '../../../../assets/img/roti/';
    $success = true;

    // Ambil nomor_sejenis terbaru
    $result = mysqli_query($koneksi, "SELECT MAX(nomor_sejenis) AS max_nomor_sejenis FROM roti");
    $row = mysqli_fetch_assoc($result);
    $nomor_sejenis_baru = ($row['max_nomor_sejenis'] ? $row['max_nomor_sejenis'] + 1 : 1);

    foreach ($nama_roti_list as $index => $nama_roti) {
        $harga = $harga_list[$index];
        $berat = $berat_list[$index];
        $rasa = $rasa_list[$index];
        $vitamin = $vitamin_list[$index];
        $gula = $gula_list[$index];
        $deskripsi = $deskripsi_list[$index];
        $stok = $stok_list[$index]; // Ambil stok

        // Penanganan file upload
        $gambar_roti = isset($gambar_roti_list[$index]) ? $gambar_roti_list[$index] : null;
        if ($gambar_roti) {
            $file_tmp_path = $_FILES['gambar_roti']['tmp_name'][$index];
            $file_name = $_FILES['gambar_roti']['name'][$index];
            $dest_path = $upload_dir . $file_name;

            if (!move_uploaded_file($file_tmp_path, $dest_path)) {
                $success = false;
                break;
            }
        } else {
            $gambar_roti = null;
        }

        // Lakukan proses penyimpanan data ke database
        $sql = "INSERT INTO roti (nomor_sejenis, nama_roti, harga, berat, rasa, vitamin, gula, deskripsi, stok, gambar_roti) 
                VALUES ('$nomor_sejenis_baru', '$nama_roti', '$harga', '$berat', '$rasa', '$vitamin', '$gula', '$deskripsi', '$stok', '$gambar_roti')";

        if (!mysqli_query($koneksi, $sql)) {
            $success = false;
            break;
        }
    }

    if ($success) {
        echo 'success';
    } else {
        echo 'error';
    }
}
