function showLoading() {
  var loading = document.querySelector(".loading");
  var loadingImg = document.querySelector(".loading-img");
  var loadingTop = document.querySelector(".loading-top");
  var loadingBottom = document.querySelector(".loading-bottom");

  loading.style.display = "flex"; // Menampilkan loading
  loadingImg.style.display = "block"; // Tampilkan gambar loading

  // Set minimum display time
  var minDisplayTime = 500;
  var startTime = performance.now();

  // Menghitung waktu muat gambar
  var img = new Image();
  img.onload = function () {
    var endTime = performance.now();
    var loadTime = endTime - startTime;
    var remainingTime = Math.max(0, minDisplayTime - loadTime);

    setTimeout(function () {
      // Animasi keluar div dan loading image mengecil

      setTimeout(function () {
        loadingImg.style.animation = "spinAndScaleDown 1s forwards";
        loadingTop.style.animation = "slideDownBack 1s forwards";
        loadingBottom.style.animation = "slideUpBack 1s forwards";
        loading.style.animation = "hilangkanWarna 1s forwards";
      }, 1000);

      // Sembunyikan loading setelah animasi selesai
      setTimeout(function () {
        loading.style.display = "none";
      }, 1900); // Sesuaikan dengan durasi animasi (3 detik + 1 detik)
    }, remainingTime);
  };
  img.src = "../../assets/img/logo_fasya2.jpeg"; // Ganti dengan gambar atau sumber daya lain di halaman Anda
}

// Menampilkan loading saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
  showLoading();
});
