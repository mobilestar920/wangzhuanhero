$(document).ready(function() {

    $('#dataTable').DataTable( {
        responsive: true,
        dom: 'Bfrtlp',
        buttons: ['csv']
    } );

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

    // $('#btn_export_excel').on('click', function() {
    //     var codeType = $('#code_type').val();
    //     $.ajax({
    //         type: "POST",
    //         url: "http://192.168.101.2:8001/books/download",
    //         dataType: "json",
    //         data: {code_type: codeType, _token: $('meta[name="csrf-token"]').attr('content')},
    //         success: function (response) {
    //             console.log(response);
    //             location.back();
    //         },
    //         error: function(error) {
    //             console.log(error);
    //             alert('Can not set data');
    //         }
    //     })
    // });

    $('#btn_blocking').on('click', function() {
        var block_name = $('#block_name').val();
        var phone_number = $('#phone_number').val();

        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://192.168.101.17:8003/manage/blocks/add",
            dataType: "json",
            data: {team_id: team_id, name: block_name, phone: phone_number, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $("#dataTable").on("click", '#block_status', function(event) {
        var block_id = $(this).attr("data-id");

        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://192.168.101.17:8003/manage/blocks/status",
            dataType: "json",
            data: {status: this.checked, block_id: block_id, team_id: team_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $("#dataTable").on("click", '#delete_block', function(event) {
        var block_id = $(this).attr("data-id");

        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://192.168.101.17:8003/manage/blacklist/delete",
            dataType: "json",
            data: {block_id: block_id, team_id: team_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });
})