import {Datatable} from './libs/Datatable.js'

$(function () {

	const config = {
		columnDefs: {
			falseSearchable: [0, 10],
			falseOrderable: [0, 10],
			falseVisibility: [1,6,7,8,9],
			width: ['2(150)','10(120)'],
			className: 10
		},
		createdRow: ['No', 'Tanggal dibuat', 'Proses Khusus', 'Harga', 'Status Aktif', 'Action'],
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
	const datatable = new Datatable('#dataList', config, `${HOST}/proseskhusus/api`, 'GET')
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
			url: `${HOST}/proseskhusus/add/api`,
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
		const id = $(this).attr('data-id')
		$.ajax({
			type: "GET",
			url: `${HOST}/api/master/khusus/${id}?modified=yes`,
			dataType: 'JSON',
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
		.on('click', '.item-edit', function(e) {
			e.preventDefault();
			const tr = $(this).closest('tr');
			const row = $("#dataList tr").index(tr);
			dataListRow = $(`#dataList tr:nth-child(${row+1})`)
			const objstring = $(this).attr('data-obj')
			const id = $(this).attr('data-id');
			const proses = $(this).attr('data-proses');
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
			$(`#dataList tr:nth-child(${row}) td:nth-child(3)`).html(`<input type="text" class="form-control" placeholder="Nama Proses" value="${proses}" name="proses" />`)
			$(`#dataList tr:nth-child(${row}) td:nth-child(4)`).html(`<input type="number" class="form-control" placeholder="Harga" value="${parseInt(harga)}" name="harga" /><input type="hidden" value="${id}" name="id" />`)
			$(`#dataList tr:nth-child(${row}) td:nth-child(5)`).html(`${aktif}`)
			$(`#dataList tr:nth-child(${row}) td:nth-child(6)`).html(`${btn}`)

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
		e.stopPropagation()
	})
	$('#dataList').on('click', '.save-tr-record', function() {
		const data = {
			id: $('input[name="id"]').val(),
			proses: $('input[name="proses"]').val(),
			harga: $('input[name="harga"]').val(),
			aktif: $('select[name="aktif"] option:selected').val()
		};
		$.ajax({
			type: "PUT",
			url: `${HOST}/proseskhusus/edit/api`,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			contentType: 'application/x-www-form-urlencoded; charset=utf-8',
			dataType: 'JSON',
			data: data,
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
			url: `${HOST}/mfproseskhusus/apiEditProcess`,
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
		url: `${HOST}/proseskhusus/api`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}