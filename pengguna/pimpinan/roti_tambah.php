<!-- penggunah -->
<?php include 'fitur/penggunah.php'; ?>

<!DOCTYPE html>
<html lang="en">

<!-- Head -->
<?php include 'fitur/head.php'; ?>

<body translate="no">

    <!-- Header -->
    <?php include 'fitur/header.php'; ?>

    <!-- sidebar -->
    <?php include 'fitur/sidebar.php'; ?>

    <main id="main" class="main">

        <!-- title -->
        <?php include 'fitur/title.php'; ?>

        <?php include 'fitur/papan_nama.php'; ?>

        <section class="section">
            <div class="row">
                <form id="form_tambah_semua" method="POST" action="proses/roti/tambah.php"
                    enctype="multipart/form-data">
                    <div id="form_container">
                        <!-- Form yang akan ditambahkan secara dinamis -->
                    </div>
            </div>
        </section>
        <section class="section">
            <div class="row">
                <div class="col-lg-12" id="konten_form">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-primary" id="tambah_form">Tambah Roti
                                    Sejenis</button>
                                <button type="submit" class="btn btn-success" style="margin: 10px;">Simpan
                                    Semua</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SweetAlert2 Script -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let formContainer = document.getElementById('form_container');
                let tambahFormButton = document.getElementById('tambah_form');
                let formCount = 0;

                // Fungsi untuk membuat form baru
                function createForm() {
                    formCount++;
                    let formHTML = ` 
    <div class="col-lg-12 mb-3 form_item" data-form-id="${formCount}">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center mt-3">Roti Ke ${formCount}</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_roti_${formCount}" class="form-label">Nama Roti</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-bread-line"></i></span>
                            <input type="text" class="form-control" id="nama_roti_${formCount}" name="nama_roti[]" required/>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="harga_${formCount}" class="form-label">Harga Roti</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-money-dollar-circle-line"></i></span>
                            <input type="number" class="form-control" id="harga_${formCount}" name="harga[]" required/>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="berat_${formCount}" class="form-label">Berat Roti</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-weight-line"></i></span>
                            <input type="text" class="form-control" id="berat_${formCount}" name="berat[]" required/>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rasa_${formCount}" class="form-label">Rasa Roti</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-restaurant-line"></i></span>
                            <input type="text" class="form-control" id="rasa_${formCount}" name="rasa[]" required/>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="vitamin_${formCount}" class="form-label">Vitamin Roti</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-capsule-line"></i></span>
                            <input type="text" class="form-control" id="vitamin_${formCount}" name="vitamin[]" required/>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gula_${formCount}" class="form-label">Gula Roti</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-cup-line"></i></span>
                            <input type="text" class="form-control" id="gula_${formCount}" name="gula[]" required/>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="stok_${formCount}" class="form-label">Stok Roti</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-store-2-line"></i></span>
                            <input type="number" class="form-control" id="stok_${formCount}" name="stok[]" required/>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Deskripsi" id="deskripsi_${formCount}" name="deskripsi[]" style="height: 100px" required></textarea>
                            <label for="deskripsi_${formCount}">Deskripsi</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="gambar_roti_${formCount}" class="form-label">Gambar Roti</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-image-line"></i></span>
                            <input type="file" class="form-control" id="gambar_roti_${formCount}" name="gambar_roti[]" accept="image/*" required/>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <img id="imagePreview_${formCount}" src="" alt="Pratinjau Gambar" class="img-fluid" style="display: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);" required/>
                    </div>
                    <hr />
                    <div class="col-12 text-center mt-3">
                        <button type="button" class="btn btn-danger hapus_form" style="display: none;">Hapus Form</button>
                    </div>
                </div>
            </div>
        </div>
    </div>`;

                    formContainer.insertAdjacentHTML('beforeend', formHTML);
                    toggleDeleteButtons(); // Periksa dan atur tombol hapus
                }


                // Event listener untuk menambahkan form
                tambahFormButton.addEventListener('click', createForm);

                // Event listener untuk form submit
                document.getElementById('form_tambah_semua').addEventListener('submit', function(event) {
                    event.preventDefault(); // Menghentikan aksi default form submit

                    var form = this;
                    var formData = new FormData(form);

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'proses/roti/tambah.php', true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var response = xhr.responseText.trim();

                            if (response === 'success') {
                                form.reset();
                                document.querySelectorAll('img[id^="imagePreview_"]').forEach(function(
                                    img) {
                                    img.style.display = 'none';
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Data berhasil ditambahkan',
                                    timer: 1200, // 1,2 detik
                                    showConfirmButton: false // Menghilangkan tombol OK
                                });
                            } else if (response === 'data_tidak_lengkap') {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Error',
                                    text: 'Data yang Anda masukkan belum lengkap',
                                    timer: 2000, // 2 detik
                                    showConfirmButton: false // Menghilangkan tombol OK
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Gagal menambahkan data',
                                    timer: 2000, // 2 detik
                                    showConfirmButton: false // Menghilangkan tombol OK
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengirim data',
                                timer: 2000, // 2 detik
                                showConfirmButton: false // Menghilangkan tombol OK
                            });
                        }
                    };
                    xhr.send(formData);
                });

                // Event listener untuk hapus form
                document.addEventListener('click', function(event) {
                    if (event.target.classList.contains('hapus_form')) {
                        let formToDelete = event.target.closest('.form_item');
                        formToDelete.remove();
                        updateFormNumbers(); // Update nomor form setelah form dihapus
                        toggleDeleteButtons(); // Periksa dan atur tombol hapus
                    }
                });

                // Fungsi untuk menampilkan preview gambar
                document.addEventListener('change', function(event) {
                    if (event.target.matches('input[type="file"]')) {
                        var fileInput = event.target;
                        var reader = new FileReader();
                        reader.onload = function() {
                            var preview = document.getElementById('imagePreview_' + fileInput.id.split(
                                '_')[2]);
                            preview.src = reader.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                });

                // Fungsi untuk mengupdate nomor form setelah ada yang dihapus
                function updateFormNumbers() {
                    let forms = document.querySelectorAll('.form_item');
                    formCount = 0;
                    forms.forEach(function(form, index) {
                        formCount++;
                        form.querySelector('.card-title').textContent = `Form ${formCount}`;
                        form.dataset.formId = formCount;
                        updateInputIds(form, formCount);
                    });
                }

                // Fungsi untuk mengupdate id dan for label pada input
                function updateInputIds(form, formCount) {
                    form.querySelectorAll('input, textarea, label').forEach(function(input) {
                        if (input.id) {
                            let newId = input.id.replace(/\d+$/, formCount);
                            input.id = newId;
                        }
                        if (input.htmlFor) {
                            let newFor = input.htmlFor.replace(/\d+$/, formCount);
                            input.htmlFor = newFor;
                        }
                    });

                    // Update id imagePreview juga
                    let imgPreview = form.querySelector('img[id^="imagePreview_"]');
                    if (imgPreview) {
                        imgPreview.id = `imagePreview_${formCount}`;
                    }
                }

                // Fungsi untuk menampilkan/menyembunyikan tombol hapus
                function toggleDeleteButtons() {
                    let forms = document.querySelectorAll('.form_item');
                    forms.forEach(function(form) {
                        let deleteButton = form.querySelector('.hapus_form');
                        if (forms.length > 1) {
                            deleteButton.style.display = 'inline-block';
                        } else {
                            deleteButton.style.display = 'none';
                        }
                    });
                }

                // Membuat form pertama saat halaman dimuat
                createForm();
            });
        </script>


    </main>
    <!-- End #main -->

    <?php include 'fitur/bagian_akhir.php'; ?>

</body>

</html>