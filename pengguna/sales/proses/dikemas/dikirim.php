<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_mitra = $_POST['id_mitra'];
$id_sales = $_POST['id_sales'];
$nomor_pemesanan = $_POST['nomor_pemesanan'];
$waktu = date('Y-m-d H:i:s');
$waktu_data = $_POST['waktu'];
$status = 'belum_diterima';
$type_waktu = $_POST['type_waktu'];
$waktu_batas_pengiriman = $waktu_data . ' ' . $type_waktu;

// Lakukan validasi data
if (empty($nomor_pemesanan) || empty($id_mitra)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO dikirim (id_mitra, id_sales, nomor_pemesanan, waktu, waktu_batas_pengiriman, status) 
        VALUES ('$id_mitra', '$id_sales','$nomor_pemesanan','$waktu','$waktu_batas_pengiriman', '$status')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    // Buat query SQL untuk menghapus data checkout berdasarkan nomor_pemesanan
    $query_update = "UPDATE dikemas SET status = 'sudah_dikemas' WHERE nomor_pemesanan = '$nomor_pemesanan'";

    // Jalankan query
    if (mysqli_query($koneksi, $query_update)) {
        // Query untuk mendapatkan data mitra dan sales
        $query_mitra_sales = "SELECT m.nama_lengkap AS nama_lengkap_mitra, m.nomor_hp AS nomor_hp_mitra, 
                              s.nama_lengkap AS nama_lengkap_sales, s.nomor_hp AS nomor_hp_sales 
                              FROM mitra m, sales s 
                              WHERE m.id_mitra = '$id_mitra' AND s.id_sales = '$id_sales'";
        $result_mitra_sales = mysqli_query($koneksi, $query_mitra_sales);

        if ($result_mitra_sales && mysqli_num_rows($result_mitra_sales) > 0) {
            $data = mysqli_fetch_assoc($result_mitra_sales);
            $nama_lengkap_mitra = $data['nama_lengkap_mitra'];
            $nomor_hp_mitra = $data['nomor_hp_mitra'];
            $nama_lengkap_sales = $data['nama_lengkap_sales'];
            $nomor_hp_sales = $data['nomor_hp_sales'];

            // Pesan WhatsApp
            $pesan = "Haloo $nama_lengkap_mitra, Pesanan anda dengan nomor pemesanan ($nomor_pemesanan) sedang dikirim 😊.\nBerikut adalah data sales yang mengirim:\n\nNama: $nama_lengkap_sales\nNomor HP: $nomor_hp_sales";

            // Mengirim pesan WhatsApp menggunakan Fonnte API
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
                    'target' => $nomor_hp_mitra,
                    'message' => $pesan,
                    'countryCode' => '62' // Optional, sesuai dengan kode negara Anda
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: 5nTe3rCha@wSptNGT87z' // Ganti dengan token Anda yang sebenarnya
                ),
            ));

            $response_curl = curl_exec($curl);
            curl_close($curl);

            echo "success";
        } else {
            echo "error: mitra atau sales tidak ditemukan";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
