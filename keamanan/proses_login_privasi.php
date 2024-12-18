<?php
include 'koneksi.php';

function checkpenggunahType($nomor_pengguna)
{
    global $koneksi;
    $query_admin = "SELECT * FROM admin WHERE nomor_pengguna = '$nomor_pengguna'";
    $query_sales = "SELECT * FROM sales WHERE nomor_pengguna = '$nomor_pengguna'";
    $query_pimpinan = "SELECT * FROM pimpinan WHERE nomor_pengguna = '$nomor_pengguna'";

    $result_admin = mysqli_query($koneksi, $query_admin);
    $result_sales = mysqli_query($koneksi, $query_sales);
    $result_pimpinan = mysqli_query($koneksi, $query_pimpinan);

    if (mysqli_num_rows($result_admin) > 0) {
        return "admin";
    } elseif (mysqli_num_rows($result_sales) > 0) {
        return "sales";
    } elseif (mysqli_num_rows($result_pimpinan) > 0) {
        return "pimpinan";
    } else {
        return "not_found";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nomor_pengguna']) && isset($_POST['password'])) {
    $nomor_pengguna = $_POST['nomor_pengguna'];
    $password = $_POST['password'];

    // Lakukan validasi data
    if (empty($nomor_pengguna) && empty($password)) {
        echo "tidak_ada_data";
        exit();
    }
    if (empty($nomor_pengguna)) {
        echo "nomor_pengguna_tidak_ada";
        exit();
    }

    if (empty($password)) {
        echo "password_tidak_ada";
        exit();
    }

    $penggunahType = checkpenggunahType($nomor_pengguna);
    if ($penggunahType !== "not_found") {
        $query_penggunah = "SELECT * FROM $penggunahType WHERE nomor_pengguna = '$nomor_pengguna'";
        $result_penggunah = mysqli_query($koneksi, $query_penggunah);

        if (mysqli_num_rows($result_penggunah) > 0) {
            $row = mysqli_fetch_assoc($result_penggunah);
            $hashed_password = $row['password'];
            $nama_lengkap = $row['nama_lengkap'];

            if ($password === $hashed_password) {
                // Process login for other penggunah types
                session_start();
                $_SESSION['nomor_pengguna'] = $nomor_pengguna;

                switch ($penggunahType) {
                    case "admin":
                        $_SESSION['id_admin'] = $row['id_admin'];
                        break;
                    case "sales":
                        $_SESSION['id_sales'] = $row['id_sales'];
                        break;
                    case "pimpinan":
                        $_SESSION['id_pimpinan'] = $row['id_pimpinan'];
                        break;
                    default:
                        break;
                }

                // Success response
                echo "success:" . $nama_lengkap . ":" . $penggunahType . ":" . getRedirectURL($penggunahType);
            } else {
                echo "error_password";
            }
        } else {
            echo "error_nomor_pengguna";
        }
    } else {
        echo "error_nomor_pengguna";
    }
}


function getRedirectURL($penggunahType)
{
    switch ($penggunahType) {
        case "admin":
            return "../pengguna/admin/";
        case "sales":
            return "../pengguna/sales/";
        case "pimpinan":
            return "../pengguna/pimpinan/";
        default:
            return "../berlangganan/login_privasi.php";
    }
}
