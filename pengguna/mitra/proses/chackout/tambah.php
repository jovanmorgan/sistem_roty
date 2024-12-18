<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor_pemesanan = $_POST['nomor_pemesanan'] ?? ''; // Ambil dari input hidden
    $id_mitra = $_POST['id_mitra'] ?? '';
    $waktu = date('Y-m-d H:i:s');

    if (empty($nomor_pemesanan)) {
        echo 'data_tidak_lengkap';
        exit;
    }

    if ($_FILES['bukti_pembayaran']['error'] === 0) {
        $target_dir = "../../../../assets/img/bukti_pembayaran/";
        $original_filename = basename($_FILES['bukti_pembayaran']['name']);
        $file_extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));

        // Pastikan filename tidak kosong dan sudah benar
        if (!empty($original_filename)) {
            $new_filename = $nomor_pemesanan . "_" . time() . "." . $file_extension;
            $target_file = $target_dir . $new_filename;

            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_extension, $allowed_types)) {
                if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $target_file)) {
                    // Update status dan bukti pembayaran di tabel checkout
                    $query = "UPDATE checkout 
                              SET bukti_pembayaran = ?, status = 'sudah_bayar'
                              WHERE nomor_pemesanan = ?";
                    $stmt = mysqli_prepare($koneksi, $query);
                    mysqli_stmt_bind_param($stmt, "ss", $new_filename, $nomor_pemesanan);

                    if (mysqli_stmt_execute($stmt)) {
                        // Masukkan nomor_pemesanan dan status ke dalam tabel dikemas
                        $insert_query = "INSERT INTO dikemas (id_mitra, nomor_pemesanan, waktu, status) VALUES (?, ?, ?, 'belum_dikemas')";
                        $insert_stmt = mysqli_prepare($koneksi, $insert_query);
                        mysqli_stmt_bind_param($insert_stmt, "sss", $id_mitra, $nomor_pemesanan, $waktu);

                        if (mysqli_stmt_execute($insert_stmt)) {
                            echo 'success';
                        } else {
                            echo 'db_error';
                        }
                    } else {
                        echo 'db_error';
                    }
                } else {
                    echo 'upload_error';
                }
            } else {
                echo 'invalid_file_type';
            }
        } else {
            echo 'upload_error';
        }
    } else {
        echo 'upload_error';
    }
} else {
    echo 'invalid_request';
}

mysqli_close($koneksi);
