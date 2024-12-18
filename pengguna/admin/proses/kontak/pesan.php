<?php
// Koneksi ke database
include '../../../../keamanan/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_kontak = $_POST['id_kontak'];
    $nomor_hp = $_POST['nomor_hp'];
    $judul = $_POST['judul'];
    $pesan_klaen = $_POST['pesan'];
    $pesan_anda = $_POST['pesan_anda'];
    $nama = $_POST['nama'];

    // Pastikan data tidak kosong
    if (!empty($nomor_hp) && !empty($pesan_anda)) {

        // Ambil tanggal dari tabel kontak berdasarkan id_kontak
        $query_tanggal = "SELECT tanggal FROM kontak WHERE id_kontak = '$id_kontak'";
        $result = mysqli_query($koneksi, $query_tanggal);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $tanggal = $row['tanggal'];

            // Buat pesan yang akan dikirimkan
            $pesan = "Haloo $nama, Ini adalah respon balik dari kami mengenai pesan Anda pada tanggal $tanggal 😊\n\n pesan anda: '$pesan_klaen'\n\n Balasan Kami: $pesan_anda";

            // Kirim pesan menggunakan API Fonnte
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $nomor_hp,
                    'message' => $pesan,
                    'countryCode' => '62' // Optional, sesuai dengan kode negara Anda
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: 5nTe3rCha@wSptNGT87z' // Ganti dengan token Anda yang sebenarnya
                ),
            ));

            $response_curl = curl_exec($curl);
            curl_close($curl);

            if ($response_curl === false) {
                echo "error_api";
            } else {
                echo "success";
            }
        } else {
            // Jika tanggal tidak ditemukan atau query gagal
            echo "error_tanggal";
        }
    } else {
        // Jika data kosong, tampilkan pesan error
        echo "data_tidak_lengkap";
    }

    // Tutup koneksi
    mysqli_close($koneksi);
}
