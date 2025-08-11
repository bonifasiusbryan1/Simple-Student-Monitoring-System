function show(id) {
    // Menyembunyikan semua div dengan class 'hidden'
    var divs = document.querySelectorAll('.hidden');
    for (var i = 0; i < divs.length; i++) {
      divs[i].style.display = 'none';
    }

    // Menampilkan div dengan id sesuai dengan anchor yang diakses
    var selectedDiv = document.getElementById(id);
    if (selectedDiv) {
      selectedDiv.style.display = 'block';
    }
}

// Menampilkan div dengan id ke1 saat halaman dimuat
document.addEventListener('DOMContentLoaded', function () {
    show('satuakun');
});

