// Menutup popup saat mengklik di luar popup
window.onclick = function (event) {
  if (event.target == document.getElementById("searchPopup")) {
    closeSearchPopup();
  } else if (event.target == document.getElementById("buyPopup")) {
    closeBuyPopup();
  }
};

document.addEventListener("DOMContentLoaded", function () {
  function startCountdown(element) {
    var countdownTime = parseInt(element.getAttribute("data-time"));
    var interval = setInterval(function () {
      var minutes = Math.floor(countdownTime / 60);
      var seconds = countdownTime % 60;
      if (seconds < 10) {
        seconds = "0" + seconds;
      }
      element.textContent = minutes + ":" + seconds;
      if (countdownTime <= 0) {
        clearInterval(interval);
      }
      countdownTime--;
    }, 1000);
  }

  var countdownElements = document.querySelectorAll(".countdown");
  countdownElements.forEach(function (element) {
    startCountdown(element);
  });
});

function updateBadgePadding() {
  const badges = document.querySelectorAll(".order-status .status-item .badge");
  badges.forEach((badge) => {
    const textLength = badge.textContent.length;
    if (textLength === 1) {
      badge.style.padding = "3px 5px";
      // badge.style.right = "4px";
    } else if (textLength === 2) {
      badge.style.padding = "4px 3.5px";
      // badge.style.right = "6px";
    } else if (textLength === 3) {
      badge.style.padding = "5px 1px";
      // badge.style.right = "-1px";
    }
  });
}

// Call the function to set the initial padding
updateBadgePadding();
