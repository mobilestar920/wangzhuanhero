$(document).ready(function() {

    $('#dataTable').DataTable( {
        responsive: true
    } );

    $('#btn_new_resource').click(e => {
        
        $('#dlg_new_script').modal('show');
    })

    $('#btn_upload_file').click(e => {
        var resource_id = $('#btn_upload_file').attr("data-id");
        $('#resource_id').val(resource_id);
        
        $('#dlg_update_script').modal('show');
    })
})