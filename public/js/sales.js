$(function () {

	let salesData;
	$("#dataList").DataTable({
		data: salesData,
        buttons: [{
                extend: 'excelHtml5',
                exportOptions: { orthogonal: 'export' }
            }],
		columnDefs: [{
			"searchable": false,
			"orderable": false,
			"targets": [0,5]
		},
		{
			"width": 250,
			"targets": 2
		},
		{
			"width": 100,
			"targets": 3
		},{
			"targets": 4,
			render: function ( data, type, row, meta ) {
				if(type === 'export') {
					return data;
				} else {
					return (data == 'A') ? 'Ya' : 'Tidak';
				}
			}
		},
		{
			className: 'dt-body-nowrap',
			"targets": 5
		},
		{
			 "visible": false,
			 "targets": 1
		},
		],
		order: [[ 1, 'desc' ]],
		createdRow: function (row, data, dataIndex) {
			$(row).find("td:eq(0)").attr("data-label", "No");
			$(row).find("td:eq(1)").attr("data-label", "ID Sales");
			$(row).find("td:eq(2)").attr("data-label", "Nama Sales");
			$(row).find("td:eq(3)").attr("data-label", "NIK Sales");
			$(row).find("td:eq(4)").attr("data-label", "Status Aktif");
			$(row).find("td:eq(5)").attr("data-label", "&nbsp;");
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
		const obj = {
			beforeSend: function () {
				
				$('#dataList .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
			},
			success: function (response) {
				$('#dataList').DataTable().clear();
				$('#dataList').DataTable().rows.add(response);
				$('#dataList').DataTable().draw();
				
			},
			error: function () {
				$('#dataList .dataTables_empty').html('Data gagal di retrieve.')
			},
			complete: function() {}
		}
		console.log("test");
		getAllData(obj);
		
	}, 50)

	$('#dataList').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();

	$('.add-data_btn').on('click', function(e) {
		e.preventDefault();
		$('#dataForm').modal({
			show: true,
			backdrop: 'static'
		})
		$('#dataForm form').attr('name', 'addData')
		$('#dataForm .modal-title').html('Tambah data')
	})

	$('#dataForm').on('submit', 'form[name="addData"]', function(e) {
		e.preventDefault();
		const formData = new FormData(this);
		formData.delete('id')

		$.ajax({
			type: "POST",
			url: `${HOST}/sales/apiAddProcess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('#dataForm .modal-footer .loading-indicator').html(
					'<div class="spinner-icon">' +
						'<span class="spinner-border text-info"></span>' +
						'<span class="caption">Memproses data...</span>' +
					'</div>')
				$('form[name="addData"] input, form[name="addData"] textarea, form[name="addData"] button').attr('disabled', true)
			},
			success: function (response) {
				if(response.success) {
					location.reload();
				} else {
					$('#dataForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
					$('#dataForm, html, body').animate({
						scrollTop: 0
					}, 500);
				}
			},
			error: function () {},
			complete: function () {
				$('#dataForm .modal-footer .loading-indicator').html('');
				$('form[name="addData"] input, form[name="addData"] textarea, form[name="addData"] button').attr('disabled', false)
			}
		})
	})

	$('#dataForm').on('hidden.bs.modal', function (event) {
		$('#dataForm form[name="addData"], #dataForm form[name="editData"]')[0].reset();
		$('#dataForm .msg').html('')
	})

	$('#dataList').on('click', '.item-detail', function(e) {
		e.preventDefault();
		$('#dataDetail').modal('show')
		const id = $(this).attr('data-id')
		$.ajax({
			type: "POST",
			url: `${HOST}/sales/apiGetById`,
			dataType: 'JSON',
			data: { id, modified: true },
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					for(const property in response.data) {
						$(`#dataDetail .${property}`).html(response.data[property])
					}
				}
			},
			error: function () {},
			complete: function () {}
		})
	})
	$('input[name="NIK"]').keyup(function() {
		var nik=$(this).val();
		var panjang = nik.length;
		console.log(nik);
		if(panjang==6){
		$.ajax({
		  type: 'POST',
		  url: `${HOST}/users/apiGetNamaById`,
		  dataType: 'JSON',
		  data: {nik},
		  beforeSend: function() {},
		  success: function(response) {
			console.log(response);
			var nama=response.Nama;
			$('input[name="SalesName"]').val(nama);
		  }
	  })
		}
	})

	$('#dataList').on('click', '.item-edit', function(e) {
		e.preventDefault();
		$('#dataForm').modal({
			show: true,
			backdrop: 'static'
		})
		$('#dataForm .modal-title').html('Edit Data')
		$('#dataForm form').attr('name', 'editData')

		const id = $(this).attr('data-id')
		$('#dataForm form input[name="id"]').val(id)
		//alert("cek")
		$.ajax({
			type: "POST",
			url: `${HOST}/sales/apiGetById`,
			dataType: 'JSON',
			data: { id },
			beforeSend: function () {},
			success: function (response) {
				console.log(response)
				if(response.success) {
					for(const property in response.data) {
						$(`#dataForm input[name="${property}"], #dataForm textarea[name="${property}"]`).val(response.data[property])
					}
					$(`#dataForm select[name="FlagAktif"] option`).removeAttr('selected')
					if(response.data['FlagAktif'] == "A") {
						$(`#dataForm select[name="FlagAktif"] option[value="A"]`).attr('selected', 'selected')
					} else {
						$(`#dataForm select[name="FlagAktif"] option[value="N"]`).attr('selected', 'selected')
					}
					
				}
			},
			error: function () {},
			complete: function () {}
		})
	});
	$('#dataForm').on('submit', 'form[name="editData"]', function(e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: "POST",
			url: `${HOST}/sales/apiEditProcess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('#dataForm .modal-footer .loading-indicator').html(
					'<div class="spinner-icon">' +
						'<span class="spinner-border text-info"></span>' +
						'<span class="caption">Memproses data...</span>' +
					'</div>')
				$('form[name="editData"] input, form[name="editData"] textarea, form[name="editData"] button').attr('disabled', true)
			},
			success: function (response) {
				//console.log(response)
				if(response.success) {
					location.reload();
				} else {
					$('#dataForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
					$('#dataForm, html, body').animate({
						scrollTop: 0
					}, 500);
				}
			},
			error: function () {},
			complete: function () {
				$('#dataForm .modal-footer .loading-indicator').html('');
				$('form[name="editData"] input, form[name="editData"] textarea, form[name="editData"] button').attr('disabled', false)
			}
		})
	})

	$('.data-to-csv').on('click', function(e) {
		e.preventDefault();
		$("#dataList").DataTable().button( '.buttons-excel' ).trigger();
	})

	$('.data-reload').on('click', function(e) {
		e.preventDefault();
		const obj = {
			beforeSend: function () {
				$('#statusList').DataTable().clear();
				$('#statusList').DataTable().draw();
				$('#dataList .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
			},
			success: function (response) {
				$('#dataList').DataTable().clear();
				$('#dataList').DataTable().rows.add(response);
				$('#dataList').DataTable().draw();
			},
			error: function () {
				$('#dataList .dataTables_empty').html('Data gagal di retrieve.')
			},
			complete: function() {}
		}
		getAllData(obj);
	})

	
});

function getAllData(obj)
{
	console.log("test");
	$.ajax({
		type: "POST",
		url: `${HOST}/sales/apiGetAll`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}