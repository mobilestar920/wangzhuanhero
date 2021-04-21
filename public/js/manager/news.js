$(document).ready(function() {

    $('#dataTable').DataTable({
        responsive: true
    });

    // $("#dataTable").on("click", '#edit_app', function(event) {
        
    //     var appId = $(this).attr("data-id");
    //     var version = $(this).attr("data-version");
    //     var package_name = $(this).attr("data-package");
    //     var name = $(this).attr("data-name");
        
    //     $('#app_id').val(appId);
    //     $('#app_name').val(name);
    //     $('#package_name').val(package_name);
    //     $('#app_version').val(version);
    //     $('#update_app').modal('show');
    // });

    $("#dataTable").on("click", '#delete_news', function(event) {
        var newsId = $(this).attr("news_id");

        alert(newsId)

        $('#news_id').val(newsId);

        $('#delete_dialog').modal('show');
    });

    $('#btn_add_news').click(e => {
        
        $('#news_add_dialog').modal('show');
    })
})