document.addEventListener("DOMContentLoaded", function () {
  // Fungsi untuk mengirim permintaan AJAX
  function sendUpdateRequest(status, idMitra) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "proses/icon/update_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.status === "success") {
          // Redirect ke halaman yang sesuai setelah pembaruan
          window.location.href = status;
        } else {
          console.error("Error: " + response.message);
        }
      }
    };

    // Mengirim status dan id_mitra melalui POST
    xhr.send(
      "status=" +
        encodeURIComponent(status) +
        "&id_mitra=" +
        encodeURIComponent(idMitra)
    );
  }

  // Ambil id_mitra (dapat diambil dari data atribut atau variabel lain)
  var idMitra = document.getElementById("id_mitra").value;

  // Menambahkan event listener ke masing-masing tombol
  document
    .getElementById("belum_bayar_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("belum_bayar", idMitra);
    });

  document
    .getElementById("dikemas_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("dikemas", idMitra);
    });

  document
    .getElementById("dikirim_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("dikirim", idMitra);
    });

  document
    .getElementById("diterima_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("diterima", idMitra);
    });

  document
    .getElementById("dibatalkan_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("dibatalkan", idMitra);
    });

  document
    .getElementById("keranjang_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("keranjang", idMitra);
    });
});
