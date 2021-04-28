$(document).ready(function() {

    $('#dataTable').DataTable( {
        responsive: true
    });

    $('#dataTable tbody tr').on('click', function (event) {
        let number = $(this).children[0].textContent;
        console.log(number);
        let type = parseInt(number) - 1;
        location.replace('/sellings/' + type);
    });
});