$(document).ready(function () {
    function updateTableDisplay(selectedAngkatan, selectedMenu) {
        $('table tr[data-list]').hide();
        $('div.table-responsive table tr').hide();

        var data1 = $('div.table-responsive[data-menu="' + selectedMenu + '"] table tr');
        var data2 = $('div.table-responsive[data-menu="' + selectedMenu + '"] table tr[data-angkatan="' + selectedAngkatan + '"]');
        var datalist1 = $('table tr[data-list="' + selectedMenu + '"]'); 
        var datalist2 = $('table tr[data-list="' + selectedMenu + '"]');

        if (selectedAngkatan === 'semua') {
            if (data1.length > 0) {
                datalist2.hide();
                data2.hide();
                datalist1.show();
                data1.show();
                $('#mahasiswanull').hide();
            } else {
                datalist2.hide();
                data2.hide();
                datalist1.hide();
                data1.hide();
                $('#mahasiswanull').show();
            }
        } else {
            if (data2.length > 0) {
                $('#mahasiswanull').hide();
                datalist1.hide();
                data1.hide();
                datalist2.show();
                data2.show();
            } else {
                datalist1.hide();
                data1.hide();
                datalist2.hide();
                data2.hide();
                $('#mahasiswanull').show();
            }
        }
    }

    // Initial display based on the selected values
    var initialAngkatan = $('#angkatanSelect').val();
    var initialMenu = $('#pilihmenuSelect').val();
    updateTableDisplay(initialAngkatan, initialMenu);

    // On change event for the selects
    $('#angkatanSelect, #pilihmenuSelect').change(function () {
        var selectedAngkatan = $('#angkatanSelect').val();
        var selectedMenu = $('#pilihmenuSelect').val();
        updateTableDisplay(selectedAngkatan, selectedMenu);
    });
});
