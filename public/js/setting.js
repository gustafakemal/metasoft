$(function () {

    let mfJenisKertasData;

    $("#dataList").DataTable({
        data: mfJenisKertasData,
        buttons: [{
            extend: 'excelHtml5',
            exportOptions: { orthogonal: 'export' }
        }],
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [0]
        },
            {
                "width": 150,
                "targets": 2
            }],
        order: [[ 1, 'desc' ]],
        createdRow: function (row, data, dataIndex) {
            $(row).find("td:eq(0)").attr("data-label", "No");
            $(row).find("td:eq(1)").attr("data-label", "Tanggal dibuat");
            $(row).find("td:eq(2)").attr("data-label", "Jenis Kertas");
            $(row).find("td:eq(3)").attr("data-label", "Berat");
            $(row).find("td:eq(4)").attr("data-label", "Harga");
            $(row).find("td:eq(5)").attr("data-label", "Action");
        },
        initComplete: function () {
            const add_btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-data_btn">Tambah data</a>`;
            $("#dataList_wrapper .dataTables_length").prepend(add_btn);
        },
    });

    setTimeout(() => {
        const obj = {
            beforeSend: function () {
                $('#dataList .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
            },
            success: function (response) {
                $('#dataList').DataTable().clear().rows.add(response).draw();
            },
            error: function () {
                $('#dataList .dataTables_empty').html('Data gagal di retrieve.')
            },
            complete: function() {}
        }

        getAllData(obj);
    }, 50)

    $('#dataList').DataTable().on( 'order.dt search.dt', function () {
        let i = 1;
        $('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
            this.data(i++);
        });
    }).draw();

});

function getAllData(obj)
{
    $.ajax({
        type: "GET",
        url: `${HOST}/setting/modul/api`,
        beforeSend: obj.beforeSend,
        success: obj.success,
        error: obj.error,
        complete: obj.complete
    })
}