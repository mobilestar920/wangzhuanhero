$(document).ready(function() {

    $('#user_table').DataTable( {
        responsive: true
    } );

    $("#user_table").on("click", '#block_status', function(event) {
        var user_id = $(this).attr("data-userId");
        var blocked = (this.checked) ? 0 : 1

        $.ajax({
            type: "POST",
            url: "http://121.40.156.156/sellers/block",
            dataType: "json",
            data: {is_block: blocked, user_id: user_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });
});