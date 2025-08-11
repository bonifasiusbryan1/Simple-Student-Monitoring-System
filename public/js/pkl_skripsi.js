$(document).ready(function () {
    // Inisialisasi
    updateStatusText($('#statusText').data('status'));

    // Sembunyikan atau tampilkan button simpan berdasarkan status saat halaman dimuat
    var initialStatus = $('#statusText').data('status');
    if (initialStatus === 1) {
        $('.btn-custom-simpan').hide();
    } else {
        $('.btn-custom-simpan').show();
    }
    
    // Fungsi untuk mengubah teks status berdasarkan nilai status
    function updateStatusText(status) {
        var statusText = $('#statusText');
        var downloadLink = $('[data-download-link]');

        if (status !== null) {
            statusText.text(status === 1 ? 'Sudah disetujui' : 'Belum disetujui');

            // Menonaktifkan input dan memberikan kelas "approved" jika status == 1
            if (status === 1) {
                $('#nilai, #filepkl').prop('disabled', true).addClass('approved');
            } else {
                $('#nilai, #filepkl').prop('disabled', false).removeClass('approved');
            }

            // Menampilkan atau menyembunyikan link berdasarkan status
            if (status !== null) {
                downloadLink.show();
            } else {
                downloadLink.hide();
            }
        } else {
            statusText.text('Belum upload');
            $('#nilai, #filepkl').prop('disabled', false).removeClass('approved');
            
            // Menyembunyikan link jika data PKL tidak ditemukan
            downloadLink.hide();
        }
    }

    // Hapus pesan kesalahan saat membuka modal
    $('#simpan').on('show.bs.modal', function () {
        clearValidationErrors();
    });

    // Fungsi untuk menghapus pesan kesalahan
    function clearValidationErrors() {
        console.log('Clearing validation errors');
        var parentDiv = $('.grid-m-pkl');
        parentDiv.find('.text-danger').html('');
    }

    // Anda mungkin perlu menyesuaikan cara mendapatkan nilai status pada elemen ini
    // Sesuaikan dengan cara Anda mendapatkan data status pada halaman Anda
    var status = $('#statusText').data('status');

    // Panggil fungsi updateStatusText dengan nilai status yang dimuat
    updateStatusText(status);
});