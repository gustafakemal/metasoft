import {Datatable} from './libs/Datatable.js'

$(function () {

	const config = {
		columnDefs: {
			falseSearchable: [0],
			falseOrderable: [0],
			//falseVisibility: [1,7,8,9,10],
			//width: ['1(100)','2(300)','3(100)','4(80)'],
			//className: 10
		},
		createdRow: ['No', 'Nama','Status Aktif', 'Action'],
		initComplete: function () {
			const url = window.location.pathname.replace(/\//,'')
			$.get(`${HOST}/api/common/addButton?url=${url}`, function (response) {
				if(response.success) {
					$("#dataList_wrapper .dataTables_length").prepend(response.data);
				}
			})
			$.get(`${HOST}/api/common/reloadExportButton?url=${url}`, function (response) {
				if(response.success) {
					$("#dataList_wrapper .dataTables_length").prepend(response.data);
				}
			})
		}
	}
	const datatable = new Datatable('#dataList', config, `${HOST}/mxsegmen/api`, 'GET')
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
		//alert("cek");
		e.preventDefault();
		const formData = new FormData(this);
		formData.delete('ID')

		$.ajax({
			type: "POST",
			url: `${HOST}/mxsegmen/add/api`,
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

	$('#dataForm').on('hidden.bs.modal', function (event) {
		$('#dataForm form[name="addData"], #dataForm form[name="editData"]')[0].reset();
		$('#dataForm .msg').html('')
	})

	$('#dataList').on('click', '.item-detail', function(e) {
		e.preventDefault();
		$('#dataDetail').modal('show')
		const ID = $(this).attr('data-ID')
		$.ajax({
			type: "GET",
			url: `${HOST}/mxsegmen/api/${ID}`,
			dataType: 'JSON',
			// data: { id, modified: true },
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
		const ID = $(this).attr('data-ID');
		const Nama = $(this).attr('data-Nama');
		//const beratjenis = $(this).attr('data-beratjenis');
		//const harga = $(this).attr('data-harga');
		//const create_date = $(this).attr('data-added');
		const aktif_arr = $(this).attr('data-Aktif').split('|');
		const aktif_opt_arr = aktif_arr[1].split(',');
		const aktif_opt = [];
		for(let i = 0;i < aktif_opt_arr.length; i++) {
			aktif_opt.push(`<option${aktif_opt_arr[i] == aktif_arr[0] ? ' selected' : ''} value="${aktif_opt_arr[i]}">${aktif_opt_arr[i]}</option>`)
		}
		const Aktif = `<select name="Aktif" class="form-control">${aktif_opt.join('')}</select>`
		const btn = `<button type="button" class="btn btn-sm btn-success save-tr-record"><i class="fas fa-check"></i></button> <button type="button" class="btn btn-sm btn-secondary cancel-tr-submit"><i class="fas fa-times"></i></button>`
		$(`#dataList tbody tr:nth-child(${row})`).css('background-color', '#faecdc')
		$(`#dataList tr:nth-child(${row}) td:nth-child(2)`).html(`<input type="text"  class="form-control" placeholder="Segmen" value="${Nama}" name="Nama" /><input type="hidden" value="${ID}" name="ID" />`)
		$(`#dataList tr:nth-child(${row}) td:nth-child(3)`).html(`${Aktif}`)
		$(`#dataList tr:nth-child(${row}) td:nth-child(4)`).html(`${btn}`)
		$(`#dataList tr:nth-child(${row}`).attr('ID', 'selected')
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
				ID: $('input[name="ID"]').val(),
				Nama: $('input[name="Nama"]').val().toUpperCase(),
				Aktif: $('select[name="Aktif"] option:selected').val()
			};
			//console.log(data);
			$.ajax({
				type: "PUT",
				url: `${HOST}/mxsegmen/edit/api`,
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				contentType: 'application/x-www-form-urlencoded; charset=utf-8',
				dataType: 'JSON',
				data: data,
				beforeSend: function () {},
				success: function (response) {
					//alert(response);
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
			type: "PUT",
			url: `${HOST}/mxsegmen/edit/api`,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			contentType: 'application/x-www-form-urlencoded; charset=utf-8',
			dataType: 'JSON',
			data: formData,
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
		url: `${HOST}/mxsegmen/api`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}