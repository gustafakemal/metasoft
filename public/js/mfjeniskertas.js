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
			"targets": [0, 11]
		},
		{
			"width": 150,
			"targets": 2
		},
		{
			"width": 100,
			"targets": 6
		},
		{
			className: 'dt-body-nowrap',
			"targets": 11
		},
		{
			 "visible": false,
			 "targets": [1,7,8,9,10]
		}],
		order: [[ 1, 'desc' ]],
		createdRow: function (row, data, dataIndex) {
			$(row).find("td:eq(0)").attr("data-label", "No");
			$(row).find("td:eq(1)").attr("data-label", "Tanggal dibuat");
			$(row).find("td:eq(2)").attr("data-label", "Jenis Kertas");
			$(row).find("td:eq(3)").attr("data-label", "Berat");
			$(row).find("td:eq(4)").attr("data-label", "Harga");
			$(row).find("td:eq(5)").attr("data-label", "Status Aktif");
			$(row).find("td:eq(6)").attr("data-label", "&nbsp;");
		},
		initComplete: function () {
			const dropdown = `<div class="dropdown d-inline mr-2">` +
								`<button class="btn btn-primary dropdown-toggle" type="button" id="customersDropdown" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></button>` +
								`<div class="dropdown-menu" aria-labelledby="customersDropdown">` +
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
			url: `${HOST}/mfjeniskertas/apiAddProcess`,
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
					// location.reload();
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
			url: `${HOST}/mfjeniskertas/apiGetById`,
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

	let dataListRow = null;
	$('#dataList').on('click', '.item-edit', function(e) {
		e.preventDefault();
		const tr = $(this).closest('tr');
		const row = $("#dataList tr").index(tr);
		dataListRow = $(`#dataList tr:nth-child(${row+1})`)
		const objstring = $(this).attr('data-obj')
		const id = $(this).attr('data-id');
		const berat = $(this).attr('data-berat');
		const nama = $(this).attr('data-nama');
		const harga = $(this).attr('data-harga');
		const create_date = $(this).attr('data-added');
		const aktif_arr = $(this).attr('data-aktif').split('|')
		const aktif_opt_arr = aktif_arr[1].split(',');
		const aktif_opt = []
		for(let i = 0;i < aktif_opt_arr.length; i++) {
			aktif_opt.push(`<option${aktif_opt_arr[i] == aktif_arr[0] ? ' selected' : ''} value="${aktif_opt_arr[i]}">${aktif_opt_arr[i]}</option>`)
		}
		const aktif = `<select name="aktif" class="form-control">${aktif_opt.join('')}</select>`
		const btn = `<button type="button" class="btn btn-sm btn-success save-tr-record"><i class="fas fa-check"></i></button> <button type="button" class="btn btn-sm btn-secondary cancel-tr-submit"><i class="fas fa-times"></i></button>`
		$(`#dataList tr:nth-child(${row})`).css('background-color', '#faecdc')
		$(`#dataList tr:nth-child(${row}) td:nth-child(2)`).html(`<input type="text" class="form-control" value="${create_date}" readonly />`)
		$(`#dataList tr:nth-child(${row}) td:nth-child(3)`).html(`<input type="text" class="form-control" placeholder="Jenis kertas" value="${nama}" name="nama" />`)
		$(`#dataList tr:nth-child(${row}) td:nth-child(4)`).html(`<input type="number" class="form-control" placeholder="Berat" value="${parseInt(berat)}" name="berat" />`)
		$(`#dataList tr:nth-child(${row}) td:nth-child(5)`).html(`<input type="number" class="form-control" placeholder="Harga" value="${parseInt(harga)}" name="harga" /><input type="hidden" value="${id}" name="id" />`)
		$(`#dataList tr:nth-child(${row}) td:nth-child(6)`).html(`${aktif}`)
		$(`#dataList tr:nth-child(${row}) td:nth-child(7)`).html(`${btn}`)

		$(`#dataList tr:nth-child(${row}`).attr('id', 'selected')

		$('#page').addClass('click-to-close')
	});

	const reload_tr = function() {
		const obj = {
			success: function (response) {
				$('#dataList').DataTable().clear();
				$('#dataList').DataTable().rows.add(response);
				$('#dataList').DataTable().draw();
			},
		}
		getAllData(obj);
	}

	$('body').on('click', '.click-to-close', reload_tr)
	$('#dataList').on('click', '.cancel-tr-submit', reload_tr)
	$('#dataList').on('click', 'tr#selected', function(e) {
		console.log('ok de')
		e.stopPropagation()
	})
	$('#dataList').on('click', '.save-tr-record', function() {
		const formData = new FormData();
		formData.append('id', $('input[name="id"]').val())
		formData.append('nama', $('input[name="nama"]').val())
		formData.append('harga', $('input[name="harga"]').val())
		formData.append('aktif', $('select[name="aktif"] option:selected').val())
		formData.append('berat', $('input[name="berat"]').val())
		$.ajax({
			type: "POST",
			url: `${HOST}/mfjeniskertas/apiEditProcess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					reload_tr();
					console.log('ok')
				} else {
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-danger">${response.msg}</div>
						`)
				}
			},
			error: function () {},
			complete: function() {
				setTimeout(() => {
					$('.floating-msg').removeClass('show').html('');
				}, 3000);
			}
		})
	})

	$('#dataForm').on('submit', 'form[name="editData"]', function(e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: "POST",
			url: `${HOST}/mfjeniskertas/apiEditProcess`,
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
				console.log(response)
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
	$.ajax({
		type: "POST",
		url: `${HOST}/mfjeniskertas/apiGetAll`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}