<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_galeri = $_POST['id_galeri'];
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $deskripsi = $_POST['deskripsi'];

    // Handling image upload
    if (isset($_FILES['gambar_galeri']) && $_FILES['gambar_galeri']['error'] === UPLOAD_ERR_OK) {
        $gambar_galeri = $_FILES['gambar_galeri']['name'];
        $target_dir = "../../../../assets/img/galeri/";
        $target_file = $target_dir . basename($gambar_galeri);

        // Upload file
        if (move_uploaded_file($_FILES['gambar_galeri']['tmp_name'], $target_file)) {
            // Update query with new image
            $query = "UPDATE galeri SET nama='$nama', jenis='$jenis', deskripsi='$deskripsi', gambar_galeri='$gambar_galeri' WHERE id_galeri='$id_galeri'";
        } else {
            echo 'error';
            exit;
        }
    } else {
        // Update query without new image
        $query = "UPDATE galeri SET nama='$nama', jenis='$jenis', deskripsi='$deskripsi' WHERE id_galeri='$id_galeri'";
    }

    // Execute query
    if (mysqli_query($koneksi, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
