// Menggunakan JavaScript untuk menyembunyikan popup setelah 2000 milidetik (2 detik)
setTimeout(function() {
    var successPopup = document.getElementById('successPopup');
    if (successPopup) {
        successPopup.style.opacity = '0';
    }
  }, 2000);