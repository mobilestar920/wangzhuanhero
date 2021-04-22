$(document).ready(function() {

    $('#dataTable').DataTable( {
        responsive: true
    } );

    $('#btn_new_app').click(e => {
        $('#dlg_new_app').modal('show');
    })

    $('#btn_edit_app').click(e => {
        var appId = $("#btn_edit_app").attr("data-id");
        var version = $("#btn_edit_app").attr("data-version");
        var package_name = $("#btn_edit_app").attr("data-package");
        var name = $("#btn_edit_app").attr("data-name");
        
        $('#update_app_id').val(appId);
        $('#update_app_name').val(name);
        $('#update_package_name').val(package_name);
        $('#update_app_version').val(version);

        $('#dlg_edit_app').modal('show');
    })

    $('#btn_delete_app').click(e => {
        var appId = $("#btn_delete_app").attr("data-id");
        $('#delete_id').val(appId);

        $('#dlg_delete_app').modal('show');
    })

    $("#dataTable").on("click", '#edit_app', function(event) {
        
        var appId = $(this).attr("data-id");
        var version = $(this).attr("data-version");
        var package_name = $(this).attr("data-package");
        var name = $(this).attr("data-name");
        
        $('#app_id').val(appId);
        $('#app_name').val(name);
        $('#package_name').val(package_name);
        $('#app_version').val(version);
        $('#update_app').modal('show');
    });

    $("#dataTable").on("click", '#delete_app', function(event) {
        var appId = $(this).attr("data-id");

        // alert(appId)

        $('#delete_id').val(appId);

        $('#delete_dialog').modal('show');
    });

    $('#btn_new_resource').click(e => {
        
        $('#new_resource').modal('show');
    })
})