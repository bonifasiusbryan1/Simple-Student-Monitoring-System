$(document).ready(function () {
    function updateTableDisplay(selectedAngkatan, selectedStatus) {
        $('table tr').hide();

        if (selectedAngkatan === 'semua') {
            if (selectedStatus === 'semua') {
                $('table tr').show();
                $('#mahasiswanull').hide();
                $('#btnCetak').show(); // Menampilkan tombol cetak
            } else {
                var data = $('table tr[data-status="' + selectedStatus + '"]');
                if (data.length > 0) {
                    $('table tr[data-list]').show();
                    data.show();
                    $('#mahasiswanull').hide();
                    $('#btnCetak').show(); // Menampilkan tombol cetak
                } else {
                    $('table tr[data-list]').hide();
                    data.hide();
                    $('#mahasiswanull').show();
                    $('#btnCetak').hide(); // Menyembunyikan tombol cetak
                }
            }
        } else {
            if (selectedStatus === 'semua') {
                var data = $('table tr[data-angkatan="' + selectedAngkatan + '"]');
            } else {
                var data = $('table tr[data-angkatan="' + selectedAngkatan + '"][data-status="' + selectedStatus + '"]');
            }

            if (data.length > 0) {
                $('table tr[data-list]').show();
                data.show();
                $('#mahasiswanull').hide();
                $('#btnCetak').show(); // Menampilkan tombol cetak
            } else {
                $('table tr[data-list]').hide();
                data.hide();
                $('#mahasiswanull').show();
                $('#btnCetak').hide(); // Menyembunyikan tombol cetak
            }
        }
    }

    // Initial display based on the selected values
    var initialAngkatan = $('#angkatanSelect').val();
    var initialStatus = $('#pilihstatusSelect').val();
    updateTableDisplay(initialAngkatan, initialStatus);

    // On change event for the selects
    $('#angkatanSelect, #pilihstatusSelect').change(function () {
        var selectedAngkatan = $('#angkatanSelect').val();
        var selectedStatus = $('#pilihstatusSelect').val();
        updateTableDisplay(selectedAngkatan, selectedStatus);
    });

    // Tombol Cetak
    $('#btnCetak').click(function () {
        var angkatan = $('#angkatanSelect').val();
        var status = $('#pilihstatusSelect').val();
        var url = "/cetak/rekap/mahasiswa/" + angkatan + "/" + status;
        window.location.href = url;
    });
});
