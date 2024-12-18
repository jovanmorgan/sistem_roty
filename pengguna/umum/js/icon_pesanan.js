document.addEventListener("DOMContentLoaded", function () {
  // Fungsi untuk mengirim permintaan AJAX
  function sendUpdateRequest(status, callback) {
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

    xhr.send("status=" + encodeURIComponent(status));
  }

  // Menambahkan event listener ke masing-masing tombol
  document
    .getElementById("belum_bayar_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("belum_bayar");
    });

  document
    .getElementById("dikemas_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("dikemas");
    });

  document
    .getElementById("dikirim_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("dikirim");
    });

  document
    .getElementById("diterima_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("diterima");
    });

  document
    .getElementById("dibatalkan_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("dibatalkan");
    });

  // Menambahkan event listener ke masing-masing tombol
  document
    .getElementById("keranjang_btn")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Mencegah tindakan default tautan
      sendUpdateRequest("keranjang");
    });
});
