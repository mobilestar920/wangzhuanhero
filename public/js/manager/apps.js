$(document).ready(function() {

    $('#dataTable').DataTable( {
        responsive: true
    } );

    $('#btn_new_app').click(e => {
        $('#dlg_new_app').modal('show');
    })

    $('#dataTable').on("click", '.btn_edit_app', function(event) {
        var appId = $(this).attr("data-id");
        var version = $(this).attr("data-version");
        var package_name = $(this).attr("data-package");
        var name = $(this).attr("data-name");
        $('#update_app_id').val(appId);
        $('#update_app_name').val(name);
        $('#update_package_name').val(package_name);
        $('#update_app_version').val(version);

        $('#dlg_edit_app').modal('show');
    })

    $('#dataTable').on("click", '.btn_delete_app', function(event) {
        var appId = $(this).attr("data-id");
        $('#delete_id').val(appId);

        $('#dlg_delete_app').modal('show');
    })
})