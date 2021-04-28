$(document).ready(function() {

    $('#dataTable').DataTable( {
        responsive: true
    } );

    $('#btn_new_resource').click(e => {
        
        $('#dlg_new_script').modal('show');
    })

    // $(".btn .btn-sm .btn-tumblr .btn_upload_file").click(e => {
    //     console.log('clicked');
        
    //     var resource_id = $this.attr("data-id");
    //     $('#resource_id').val(resource_id);
        
    //     $('#dlg_update_script').modal('show');
    // })

    $('#dataTable tbody').on("click", '.btn .btn-sm .btn-tumblr', function(event) {
        console.log('clicked');
        
        var resource_id = $(this).attr("data-id");
        $('#resource_id').val(resource_id);

        $('#dlg_update_script').modal('show');
    });
})