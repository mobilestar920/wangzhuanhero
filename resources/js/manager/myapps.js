$(document).ready(function() {

    $('#dataTable').DataTable( {
        responsive: true
    } );

    $('#btn_new_version').click(e => {
    
        $('#dlg_new_version').modal('show');
    })
})