$(function () {

	const config = {
		columnDefs: {
			falseSearchable: [0, 10],
			falseOrderable: [0, 10],
			width: {
				"col-2": 150,
				"col-5": 100,
			},
			falseVisibility: [1,6,7,8,9],
			custom: [{
				className: 'dt-body-nowrap',
				"targets": 10
			}]
		},
		createdRow: ['No', 'Tanggal dibuat', 'Jenis tinta', 'Harga', 'Status Aktif', '&nbsp;'],
	}

	const datatable = new Datatable('#dataList', config, `${HOST}/mfjenistinta/apiGetAll`)
	datatable.load()

	const crud = new CrudUI('.add-data_btn', '#dataForm', 'addData');
	crud.add();
	crud.addProcess();

	// $('.add-data_btn').on('click', function(e) {
	// 	e.preventDefault();
	// 	$('#dataForm').modal({
	// 		show: true,
	// 		backdrop: 'static'
	// 	})
	// 	$('#dataForm form').attr('name', 'addData')
	// 	$('#dataForm .modal-title').html('Tambah data')
	// })

	// $('#dataForm').on('submit', 'form[name="addData"]', function(e) {
	// 	e.preventDefault();
	// 	const formData = new FormData(this);
	// 	console.log(this)
	// 	console.log($('form[name="addData"]').html())
	// 	formData.delete('id')

	// 	$.ajax({
	// 		type: "POST",
	// 		url: `${HOST}/mfjenistinta/apiAddProcess`,
	// 		dataType: 'JSON',
	// 		data: formData,
	// 		contentType: false,
	// 		processData: false,
	// 		beforeSend: function () {
	// 			$('#dataForm .modal-footer .loading-indicator').html(
	// 				'<div class="spinner-icon">' +
	// 					'<span class="spinner-border text-info"></span>' +
	// 					'<span class="caption">Memproses data...</span>' +
	// 				'</div>')
	// 			$('form[name="addData"] input, form[name="addData"] textarea, form[name="addData"] button').attr('disabled', true)
	// 		},
	// 		success: function (response) {
	// 			if(response.success) {
	// 				location.reload();
	// 			} else {
	// 				$('#dataForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
	// 				$('#dataForm, html, body').animate({
	// 					scrollTop: 0
	// 				}, 500);
	// 			}
	// 		},
	// 		error: function () {},
	// 		complete: function () {
	// 			$('#dataForm .modal-footer .loading-indicator').html('');
	// 			$('form[name="addData"] input, form[name="addData"] textarea, form[name="addData"] button').attr('disabled', false)
	// 		}
	// 	})
	// })

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
			url: `${HOST}/mfjenistinta/apiGetById`,
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

		$.ajax({
			type: "POST",
			url: `${HOST}/mfjenistinta/apiGetById`,
			dataType: 'JSON',
			data: { id },
			beforeSend: function () {},
			success: function (response) {
				console.log(response)
				if(response.success) {
					for(const property in response.data) {
						$(`#dataForm input[name="${property}"], #dataForm textarea[name="${property}"]`).val(response.data[property])
					}
					$(`#dataForm select[name="aktif"] option`).removeAttr('selected')
					if(response.data['aktif'] == "Y") {
						$(`#dataForm select[name="aktif"] option[value="Y"]`).attr('selected', 'selected')
					} else {
						$(`#dataForm select[name="aktif"] option[value="T"]`).attr('selected', 'selected')
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
			url: `${HOST}/mfjenistinta/apiEditProcess`,
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
		url: `${HOST}/mfjenistinta/apiGetAll`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}