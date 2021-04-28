$(document).ready(function() {

    $('#dataTable').DataTable( {
        responsive: true
    } );

    $('#btn_new_resource').click(e => {
        
        $('#dlg_new_script').modal('show');
    })

    $('#dataTable').on("click", '.btn_upload_file', function(event) {
        var resource_id = $(this).attr("data-id");
        console.log(resource_id);
        $('#resource_id').val(resource_id);

        $('#dlg_update_script').modal('show');
    });
})