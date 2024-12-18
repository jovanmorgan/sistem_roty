<?php
// Koneksi ke database
include '../../../../keamanan/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $bank = $_POST['bank'];
    $nomor_rekening = $_POST['nomor_rekening'];

    // Pastikan data tidak kosong
    if (!empty($bank) && !empty($nomor_rekening)) {
        // Query untuk menambah data ke tabel bank
        $query = "INSERT INTO bank (bank, nomor_rekening) VALUES (?, ?)";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ss", $bank, $nomor_rekening);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "success";
        } else {
            // Gagal, tampilkan pesan error
            echo "Gagal";
        }

        // Tutup statement
        $stmt->close();
    } else {
        // Jika data kosong, tampilkan pesan error
        echo "data_tidak_lengkap";
    }

    // Tutup koneksi
    $koneksi->close();
}