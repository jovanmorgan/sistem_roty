const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
  container.classList.remove("putar-kekanan");
});

sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
  container.classList.add("putar-kekanan");
});

document.querySelectorAll(".code-input").forEach((input, index, inputs) => {
  input.addEventListener("input", function () {
    if (this.value.length === 1 && index < inputs.length - 1) {
      inputs[index + 1].focus();
    } else if (index === inputs.length - 1 && this.value.length === 1) {
      this.blur(); // Hentikan di input terakhir
    }
  });

  input.addEventListener("keydown", function (event) {
    if (event.key === "Backspace" && this.value.length === 0 && index > 0) {
      inputs[index - 1].focus(); // Pindah ke input sebelumnya jika backspace ditekan
    }
  });
});

document
  .getElementById("signupForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    // Kirim data form untuk pengecekan
    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "proses_check.php", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var response = xhr.responseText.trim();

          if (
            response === "nomor_ponsel_sudah_ada" ||
            response === "error_password_length" ||
            response === "error_password_strength"
          ) {
            handleRegistrationError(response);
          } else {
            // Jika tidak ada error, lanjutkan ke modal OTP
            var kodeVerifikasi = Math.floor(
              100000 + Math.random() * 900000
            ).toString();
            localStorage.setItem("kodeVerifikasi", kodeVerifikasi);

            // Tampilkan modal verifikasi
            document.getElementById("verifyModal").style.display = "block";

            // Mengirimkan kode (panggil AJAX/API untuk mengirimkan kode ke nomor ponsel user)

            // Mulai countdown 60 detik untuk tombol kirim ulang kode
            startResendCountdown();
          }
        } else {
          swal("Error", "Gagal melakukan request", "error");
        }
      }
    };
    xhr.onerror = function () {
      swal("Error", "Gagal melakukan request", "error");
    };
    xhr.send(formData);
  });

document.getElementById("verifyCodeBtn").addEventListener("click", function () {
  var inputKode = "";
  for (var i = 1; i <= 6; i++) {
    inputKode += document.getElementById("code" + i).value;
  }

  var kodeVerifikasi = localStorage.getItem("kodeVerifikasi");

  if (inputKode === kodeVerifikasi) {
    // Kode benar, kirim data form registrasi
    submitRegistration();
  } else {
    // Kode salah, tampilkan pesan kesalahan
    swal("Error", "Kode yang Anda masukkan salah", "error");
  }
});

function submitRegistration() {
  // Kirim data registrasi menggunakan AJAX
  var formData = new FormData(document.getElementById("signupForm"));

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../keamanan/proses_register.php", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        var response = xhr.responseText.trim();
        if (response === "success") {
          swal({
            title: "Success",
            text: "Data berhasil ditambahkan",
            icon: "success",
            buttons: {
              confirm: {
                text: "OK",
                value: "ok",
              },
            },
          }).then((value) => {
            if (value === "ok") {
              document.getElementById("signupForm").reset();
              container.classList.remove("sign-up-mode");
            }
          });
        } else {
          handleRegistrationError(response);
        }
      } else {
        swal("Error", "Gagal melakukan request", "error");
      }
    }
  };
  xhr.onerror = function () {
    swal("Error", "Gagal melakukan request", "error");
  };
  xhr.send(formData);
}

function handleRegistrationError(response) {
  if (response === "nomor_ponsel_sudah_ada") {
    swal(
      "Error",
      "Nomor ponsel sudah terdaftar, silakan gunakan nomor ponsel lain",
      "error"
    );
  } else if (response === "error_password_length") {
    swal("Error", "Password harus memiliki minimal 8 karakter", "error");
  } else if (response === "error_password_strength") {
    swal(
      "Error",
      "Password harus mengandung huruf besar, huruf kecil, dan angka",
      "error"
    );
  } else {
    swal("Error", "Terjadi kesalahan saat proses login", "error");
  }
}

// Countdown untuk tombol kirim ulang kode
function startResendCountdown() {
  var countdown = 60;
  var resendBtn = document.getElementById("resendCodeBtn");
  var timerElement = document.getElementById("timer");

  resendBtn.disabled = true;
  timerElement.innerText = `Kirim Ulang Kode dalam ${countdown} detik`;

  var interval = setInterval(function () {
    countdown--;
    timerElement.innerText = `Kirim Ulang Kode dalam ${countdown} detik`;

    if (countdown <= 0) {
      clearInterval(interval);
      resendBtn.disabled = false;
      timerElement.innerText = "";
      resendBtn.innerText = "Kirim Ulang Kode";
    }
  }, 1000);
}

document.getElementById("resendCodeBtn").addEventListener("click", function () {
  // Generate kode random 6 digit baru
  var kodeVerifikasi = Math.floor(100000 + Math.random() * 900000).toString();
  localStorage.setItem("kodeVerifikasi", kodeVerifikasi);

  // Mengirimkan kode baru (panggil AJAX/API untuk mengirimkan kode ke nomor ponsel user)

  // Mulai ulang countdown 60 detik untuk tombol kirim ulang kode
  startResendCountdown();
});

// js login
document
  .querySelector(".sign-in-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    var formData = new FormData(this);

    var nomor_hp = formData.get("nomor_hp");
    var password = formData.get("password");

    if (nomor_hp === "" || password === "") {
      swal("Error", "Nomor ponsel dan password wajib diisi", "error");
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "proses_login.php", true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var response = xhr.responseText;
          var responseArray = response.split(":"); // Memisahkan respons menjadi array
          if (responseArray[0].trim() === "success") {
            // Tampilkan alert login berhasil dengan pesan selamat datang
            swal(
              "Login berhasil!",
              "Selamat datang " + responseArray[1],
              "success"
            );

            // Tunda pengalihan ke halaman berikutnya selama beberapa detik
            setTimeout(function () {
              window.location.href = "berlangganan/admin";
            }, 2000); // Pengalihan dilakukan setelah 3 detik (3000 milidetik)
          } else if (responseArray[0].trim() === "error_password") {
            swal("Error", "Password yang dimasukkan salah", "error");
          } else if (response.trim() === "error_password_length") {
            swal(
              "Error",
              "Password harus memiliki minimal 8 karakter",
              "error"
            );
          } else if (response.trim() === "error_password_strength") {
            swal(
              "Error",
              "Password harus mengandung huruf besar, huruf kecil, dan angka",
              "error"
            );
          } else if (response.trim() === "nomor_ponsel_sudah_ada") {
            swal(
              "Error",
              "Nomor ponsel sudah terdaftar, silakan gunakan nomor ponsel lain",
              "error"
            );
          } else {
            swal("Error", "Terjadi kesalahan saat proses login", "error");
          }
        } else {
          swal("Error", "gagal", "error");
        }
      }
    };
    xhr.onerror = function () {
      swal("Error", "Gagal melakukan request", "error");
    };
    xhr.send(formData);
  });

// bagian login baru
// Ambil elemen modal
var modal = document.getElementById("verifyModal");

// Ambil elemen tombol close
var closeButton = document.getElementsByClassName("close")[0];

// Fungsi untuk menutup modal
function closeModal() {
  modal.style.display = "none";
}

// Tutup modal saat tombol X diklik
closeButton.onclick = function () {
  closeModal();
};

// Tutup modal saat pengguna mengklik di luar konten modal
window.onclick = function (event) {
  if (event.target == modal) {
    closeModal();
  }
};
function togglePasswordVisibility(inputId) {
  var passwordInput = document.getElementById(inputId);
  var passwordIcon = passwordInput.nextElementSibling;

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    passwordIcon.classList.remove("bx-hide");
    passwordIcon.classList.add("bx-show-alt");
  } else {
    passwordInput.type = "password";
    passwordIcon.classList.remove("bx-show-alt");
    passwordIcon.classList.add("bx-hide");
  }
}
