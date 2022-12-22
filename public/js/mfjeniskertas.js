import {Datatable} from './libs/Datatable.js'

$(function () {

	const config = {
		columnDefs: {
			falseSearchable: [0, 11],
			falseOrderable: [0, 11],
			falseVisibility: [1,7,8,9,10],
			width: ['2(150)','11(120)'],
			className: 11
		},
		createdRow: ['No', 'Tanggal dibuat', 'Jenis kertas', 'Berat', 'Harga', 'Status Aktif', 'Action'],
		initComplete: function () {
			const url = window.location.href;
			$.ajax({
				type: 'POST',
				url: `${HOST}/api/common/dt_navigation`,
				dataType: 'JSON',
				data: {url, buttons: ['reload-export', 'add']},
				beforeSend: function (){},
				success: function (response) {
					$("#dataList_wrapper .dataTables_length").prepend(response.data);
				}
			})
		}
	}
	const datatable = new Datatable('#dataList', config, `${HOST}/jeniskertas/api`, 'GET')
	datatable.load()

	$('#dataList_wrapper').on('click', '.add-data_btn', function(e) {
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
			url: `${HOST}/jeniskertas/add/api`,
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
			error: function (response) {
				if(response.status == 403) {
					$('#dataForm .msg').html(`<div class="alert alert-danger">${response.responseJSON.msg}</div>`)
					$('#dataForm, html, body').animate({
						scrollTop: 0
					}, 500);
				}
			},
			complete: function () {
				$('#dataForm .modal-footer .loading-indicator').html('');
				$('form[name="addData"] input, form[name="addData"] textarea, form[name="addData"] button').attr('disabled', false)
			}
		})
	})
		.on('hidden.bs.modal', function (event) {
			$('#dataForm form[name="addData"], #dataForm form[name="editData"]')[0].reset();
			$('#dataForm .msg').html('')
		})

	$('#dataList').on('click', '.item-detail', function(e) {
		e.preventDefault();
		$('#dataDetail').modal('show')
		const id = $(this).attr('data-id')
		$.ajax({
			type: "GET",
			url: `${HOST}/jeniskertas/api/${id}`,
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
		const berat = (!$(this).attr('data-berat') || Number.isNaN(parseInt($(this).attr('data-berat')))) ? 0 : $(this).attr('data-berat');
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
		$(`#dataList tbody tr:nth-child(${row})`).css('background-color', '#faecdc')
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
				$('#dataList').DataTable().clear().rows.add(response).draw();
			},
		}
		getAllData(obj);
	}

	$('body').on('click', '.click-to-close', reload_tr)
	$('#dataList').on('click', '.cancel-tr-submit', reload_tr)
		.on('click', 'tr#selected', function(e) {
		e.stopPropagation()
	})
		.on('click', '.save-tr-record', function() {
			const data = {
				id: $('#dataList input[name="id"]').val(),
				nama: $('input[name="nama"]').val(),
				harga: $('input[name="harga"]').val(),
				aktif: $('select[name="aktif"] option:selected').val(),
				berat: $('input[name="berat"]').val()
			};
			$.ajax({
				type: "PUT",
				url: `${HOST}/jeniskertas/edit/api`,
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				contentType: 'application/x-www-form-urlencoded; charset=utf-8',
				dataType: 'JSON',
				data: data,
				beforeSend: function () {},
				success: function (response) {
					let msgClass;
					if(response.success) {
						reload_tr();
						msgClass = 'success'
					} else {
						msgClass = 'danger'
					}
					$('.floating-msg').addClass('show').html(`<div class="alert alert-${msgClass}">${response.msg}</div>`)
				},
				error: function (response) {
					if(response.status == 403) {
						$('.floating-msg').addClass('show').html(`
								<div class="alert alert-danger">${response.responseJSON.msg}</div>
								`)
					}
				},
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
				$('#statusList').DataTable().clear().draw();
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
	})

	
});

function getAllData(obj)
{
	$.ajax({
		type: "GET",
		url: `${HOST}/jeniskertas/api`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}