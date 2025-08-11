$(document).ready(function () {
    // Inisialisasi
    updateStatusText($('#semesterSelect').val());

    // Sembunyikan atau tampilkan button simpan berdasarkan status saat halaman dimuat
    var initialSelectedSemester = $('#semesterSelect').val();
    var initialSelectedKhs = khsData.find(item => item.semester == initialSelectedSemester);
    if (initialSelectedKhs && initialSelectedKhs.status == 1) {
        $('.btn-custom-simpan').hide();
    } else {
        $('.btn-custom-simpan').show();
    }

    $('#semesterSelect').change(function () {
        var selectedSemester = $(this).val();
        updateStatusText(selectedSemester);
        clearValidationErrors($(this));

        // Update download link
        $('#downloadLink').attr('href', '/export/filekhs/' + mahasiswaNim + '/' + selectedSemester);

        // Sembunyikan atau tampilkan button simpan berdasarkan status
        var selectedKhs = khsData.find(item => item.semester == selectedSemester);
        if (selectedKhs && selectedKhs.status == 1) {
            $('.btn-custom-simpan').hide();
        } else {
            $('.btn-custom-simpan').show();
        }
    });

    function updateStatusText(semester) {
        var statusText = $('#statusText');
        var downloadLink = $('[data-download-link]');

        var selectedKHS = khsData.find(item => item.semester == semester);

        if (selectedKHS) {
            statusText.text(selectedKHS.status == 1 ? 'Sudah disetujui' : 'Belum disetujui');

            // Menonaktifkan input dan memberikan kelas "approved" jika status == 1
            if (selectedKHS.status == '1') {
                $('#skss, #sksk, #ips, #ipk, #filekhsInput').prop('disabled', true).addClass('approved');
                $('#skss').val(selectedKHS.skss);
                $('#sksk').val(selectedKHS.sksk);
                $('#ips').val(selectedKHS.ips);
                $('#ipk').val(selectedKHS.ipk);
            } else {
                $('#skss, #sksk, #ips, #ipk, #filekhsInput').prop('disabled', false).removeClass('approved');
                $('#skss, #sksk, #ips, #ipk').val('');
            } 

            // Menampilkan atau menyembunyikan link berdasarkan status
            if (selectedKHS.status !== null) {
                downloadLink.show();
            } else {
                downloadLink.hide();
            }

            // Mengatur kelas berdasarkan status
            statusText.removeClass('red orange green'); // Hapus kelas sebelum menambahkan kelas baru
            if (selectedKHS.status == '0') {
                statusText.addClass('orange');
            } else if (selectedKHS.status == '1') {
                statusText.addClass('green');
            }
        } else {
            statusText.text('Belum upload');

            $('#skss, #sksk, #ips, #ipk, #filekhsInput').prop('disabled', false).removeClass('approved');

            // Menyembunyikan link jika KHS tidak ditemukan
            downloadLink.hide();

            // Reset nilai input
            $('#skss, #sksk, #ips, #ipk').val('');

            // Mengatur kelas berdasarkan status
            statusText.removeClass('red orange green').addClass('red');
        }
    }

    // Fungsi untuk menghapus pesan kesalahan
    function clearValidationErrors(element) {
        var parentDiv = element.closest('.grid-m-khs');
        parentDiv.find('.text-danger').html('');
    }
    
});
