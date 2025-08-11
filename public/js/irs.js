$(document).ready(function () {
    // Inisialisasi
    updateStatusText($('#semesterSelect').val());

    // Sembunyikan atau tampilkan button simpan berdasarkan status saat halaman dimuat
    var initialSelectedSemester = $('#semesterSelect').val();
    var initialSelectedIrs = irsData.find(item => item.semester == initialSelectedSemester);
    if (initialSelectedIrs && initialSelectedIrs.status == 1) {
        $('.btn-custom-simpan').hide();
    } else {
        $('.btn-custom-simpan').show();
    }

    $('#semesterSelect').change(function () {
        var selectedSemester = $(this).val();
        updateStatusText(selectedSemester);
        clearValidationErrors($(this));

        // Update download link
        $('#downloadLink').attr('href', '/export/fileirs/'+ mahasiswaNim + '/' + selectedSemester);

        // Sembunyikan atau tampilkan button simpan berdasarkan status
        var selectedIrs = irsData.find(item => item.semester == selectedSemester);
        if (selectedIrs && selectedIrs.status == 1) {
            $('.btn-custom-simpan').hide();
        } else {
            $('.btn-custom-simpan').show();
        }
    });

    function updateStatusText(semester) {
        var statusText = $('#statusText');
        var downloadLink = $('[data-download-link]');

        var selectedIrs = irsData.find(item => item.semester == semester);

        if (selectedIrs) {
            statusText.text(selectedIrs.status == 1 ? 'Sudah disetujui' : 'Belum disetujui');

            // Menonaktifkan input dan memberikan kelas "approved" jika status == 1
            if (selectedIrs.status == '1') {
                $('#jumlahSks, #fileIrsInput').prop('disabled', true).addClass('approved');
                $('#jumlahSks').val(selectedIrs.jumlahsks);
            } else {
                $('#jumlahSks, #fileIrsInput').prop('disabled', false).removeClass('approved');
                $('#jumlahSks').val('');
            } 

            // Menampilkan atau menyembunyikan link berdasarkan status
            if (selectedIrs.status !== null) {
                downloadLink.show();
            } else {
                downloadLink.hide();
            }

            // Mengatur kelas berdasarkan status
            statusText.removeClass('red orange green'); // Hapus kelas sebelum menambahkan kelas baru
            if (selectedIrs.status == '0') {
                statusText.addClass('orange');
            } else if (selectedIrs.status == '1') {
                statusText.addClass('green');
            }

        } else {
            statusText.text('Belum upload');
            $('#jumlahSks, #fileIrsInput').prop('disabled', false).removeClass('approved');

            $('#jumlahSks').val('');

            // Menyembunyikan link jika IRS tidak ditemukan
            downloadLink.hide();

            // Mengatur kelas berdasarkan status
            statusText.removeClass('red orange green').addClass('red');
        }
    }

    // Fungsi untuk menghapus pesan kesalahan
    function clearValidationErrors(element) {
        var parentDiv = element.closest('.grid-m-irs');
        parentDiv.find('.text-danger').html('');
    }

});
