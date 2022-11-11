$(function () {

	let mfJenisFluteData;

	$("#dataList").DataTable({
		data: mfJenisFluteData,
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
			"width": 100,
			"targets": 5
		}],
		order: [[ 1, 'desc' ]],
		createdRow: function (row, data, dataIndex) {
			$(row).find("td:eq(0)").attr("data-label", "No");
			$(row).find("td:eq(1)").attr("data-label", "Tanggal dibuat");
			$(row).find("td:eq(2)").attr("data-label", "Jenis Flute");
			$(row).find("td:eq(3)").attr("data-label", "Harga");
			$(row).find("td:eq(4)").attr("data-label", "Status Aktif");
		},
		initComplete: function () {
			const dropdown = `<div class="dropdown d-inline mr-2">` +
								`<button class="btn btn-primary dropdown-toggle" type="button" id="dataTableDropdown" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></button>` +
								`<div class="dropdown-menu" aria-labelledby="dataTableDropdown">` +
								`<a class="dropdown-item data-reload" href="#">Reload data</a>` +
								`<a class="dropdown-item data-to-csv" href="#">Export to excel</a>` +
							`</div>` +
						`</div>`
			const add_btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-data_btn">Tambah data</a>`;
			$("#dataList_wrapper .dataTables_length").prepend(dropdown + add_btn);
		},
	});

	setTimeout(() => {
		$.ajax({
			type: 'GET',
			url: `${HOST}/setting/apiGetParent`,
			beforeSend: function () {
				$('#dataList .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
			},
			success: function (response) {
				console.log(response);
				$('#dataList').DataTable().clear().rows.add(response).draw();
			},
			error: function () {
				$('#dataList .dataTables_empty').html('Data gagal di retrieve.')
			},
			complete: function() {}
		})
	}, 50)

	$('#dataList').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();

	//-----------------------------------------------------------------------------------

	let routes;

	$("#dataRoutes").DataTable({
		data: routes,
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
				"width": 100,
				"targets": 5
			}],
		order: [[ 1, 'desc' ]],
		createdRow: function (row, data, dataIndex) {
			$(row).find("td:eq(0)").attr("data-label", "No");
			$(row).find("td:eq(1)").attr("data-label", "Tanggal dibuat");
			$(row).find("td:eq(2)").attr("data-label", "Jenis Flute");
			$(row).find("td:eq(3)").attr("data-label", "Harga");
			$(row).find("td:eq(4)").attr("data-label", "Status Aktif");
		},
		initComplete: function () {},
	});

	setTimeout(() => {
		$.ajax({
			type: 'GET',
			url: `${HOST}/setting/apiGetRoutes`,
			beforeSend: function () {
				$('#dataRoutes .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
			},
			success: function (response) {
				console.log(response);
				$('#dataRoutes').DataTable().clear().rows.add(response).draw();
			},
			error: function () {
				$('#dataRoutes .dataTables_empty').html('Data gagal di retrieve.')
			},
			complete: function() {}
		})
	}, 50)

	$('#dataRoutes').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#dataRoutes').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();
	
});