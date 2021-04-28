$(document).ready(function() {

    $('#dataTable').dataTable();

    var locations = location.href.split('/');    
    if (locations.length == 5) {
        $('#code_type').val(locations[4]);
    } else {
        $('#code_type').val(0);
    }

    $('#code_type').on('change', function() {
        location.replace('/generation/' + this.value);
    });

    $('#btn_code_generation').on('click', function() {
        $('#dlg_code_generation').modal('show');
    });
})