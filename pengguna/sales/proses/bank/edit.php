<?php
// Koneksi ke database
include '../../../../keamanan/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id = $_POST['id'];
    $bank = $_POST['bank'];
    $nomor_rekening = $_POST['nomor_rekening'];

    // Pastikan data tidak kosong
    if (!empty($id) && !empty($bank) && !empty($nomor_rekening)) {
        // Query untuk memperbarui data di tabel bank
        $query = "UPDATE bank SET bank = ?, nomor_rekening = ? WHERE id_bank = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ssi", $bank, $nomor_rekening, $id);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "success";
        } else {
            // Gagal, tampilkan pesan error
            echo "Gagal mengupdate data: " . $stmt->error;
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
