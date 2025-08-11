$(document).ready(function () {
    $('#angkatanSelect').change(function () {
        var selectedAngkatan = $(this).val();

        if (selectedAngkatan === 'semua') {
            $('table tr').show();
            $('#mahasiswanull').hide();
        } else {
            $('table tr').hide();

            var data = $('table tr[data-angkatan="' + selectedAngkatan + '"]');
            if (data.length > 0) {
                $('table tr[data-list]').show();
                data.show();
                $('#mahasiswanull').hide();
            } else {
                $('#mahasiswanull').show();
            }
        }
    });
});

