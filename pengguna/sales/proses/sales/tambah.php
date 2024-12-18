<?php
// Aktifkan laporan error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
include '../../../../keamanan/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $nomor_pengguna = $_POST['nomor_pengguna'];
    $nomor_hp = $_POST['nomor_hp'];
    $password = $_POST['password'];

    // Pastikan data tidak kosong
    if (!empty($nama_lengkap) && !empty($nomor_hp) && !empty($nomor_pengguna) && !empty($password)) {
        // Validasi nomor pengguna di tabel sales, admin, dan pimpinan
        $tables = ['sales', 'admin', 'pimpinan'];
        $exists = false;

        foreach ($tables as $table) {
            $check_query = "SELECT * FROM $table WHERE nomor_pengguna = ?";
            $stmt = $koneksi->prepare($check_query);
            if (!$stmt) {
                die('Error preparing statement: ' . $koneksi->error);
            }
            $stmt->bind_param("s", $nomor_pengguna);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $exists = true;
                $stmt->close();
                break;
            }

            $stmt->close();
        }

        if ($exists) {
            echo "error_nomor_pengguna_exists";
            $koneksi->close();
            exit();
        }

        // Validasi password
        if (strlen($password) < 8) {
            echo "error_password_length";
            $koneksi->close();
            exit();
        }

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
            echo "error_password_strength";
            $koneksi->close();
            exit();
        }

        // Query untuk menambah data ke tabel sales
        $insert_query = "INSERT INTO sales (nama_lengkap, nomor_hp, nomor_pengguna, password) VALUES (?, ?, ?, ?)";
        $stmt = $koneksi->prepare($insert_query);
        if (!$stmt) {
            die('Error preparing statement: ' . $koneksi->error);
        }
        $stmt->bind_param("ssss", $nama_lengkap, $nomor_hp, $nomor_pengguna, $password);

        // Eksekusi query
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Gagal: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        echo "data_tidak_lengkap";
    }

    // Tutup koneksi
    $koneksi->close();
}