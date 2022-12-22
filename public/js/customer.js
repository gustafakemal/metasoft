import {Datatable} from "./libs/Datatable.js";

$(function () {

	const config = {
		columnDefs: {
			falseSearchable: [0, 18],
			falseOrderable: [0, 18],
			falseVisibility: [1,4, 5, 6, 8, 9, 10, 11, 12, 13, 15, 16, 17],
			width: ['2(150)','18(120)'],
			className: 5,
			custom: [
				{
					"targets": 14,
					render: function ( data, type, row, meta ) {
						if(type === 'export') {
							return data;
						} else {
							return (data == 'A') ? 'Ya' : 'Tidak';
						}
					}
				}
			]
		},
		createdRow: ['No', 'Tanggal dibuat', 'Nama Pemesan', 'Contact Person', 'Status Aktif', 'Action'],
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
	const datatable = new Datatable('#dataList', config, `${HOST}/pelanggan/api`, 'GET')
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

		$.ajax({
			type: "POST",
			url: `${HOST}/pelanggan/add/api`,
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
		const noPemesan = $(this).attr('data-id')
		$.ajax({
			type: "GET",
			url: `${HOST}/pelanggan/api/${noPemesan}?modified=yes`,
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

	$('#dataList').on('click', '.item-edit', function(e) {
		e.preventDefault();
		$('#dataForm').modal({
			show: true,
			backdrop: 'static'
		})
		$('#dataForm .modal-title').html('Edit Data')
		$('#dataForm form').attr('name', 'editData')

		const noPemesan = $(this).attr('data-id')
		$('#dataForm form input[name="NoPemesan"]').val(noPemesan)

		$.ajax({
			type: "GET",
			url: `${HOST}/pelanggan/api/${noPemesan}`,
			dataType: 'JSON',
			beforeSend: function () {},
			success: function (response) {
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
					$(`#dataForm select[name="WajibPajak"] option`).removeAttr('selected')
					if(response.data['WajibPajak'] == "Y") {
						$(`#dataForm select[name="WajibPajak"] option[value="Y"`).attr('selected', 'selected')
					} else {
						$(`#dataForm select[name="WajibPajak"] option[value="T"`).attr('selected', 'selected')
					}
					$(`#dataForm select[name="InternEkstern"] option`).removeAttr('selected')
					if(response.data['InternEkstern'] == "E") {
						$(`#dataForm select[name="InternEkstern"] option[value="E"`).attr('selected', 'selected')
					} else {
						$(`#dataForm select[name="InternEkstern"] option[value="I"`).attr('selected', 'selected')
					}
				}
				//console.log(response.data['InternEkstern'])
			},
			error: function () {},
			complete: function () {}
		})
	});

	$('#dataForm').on('submit', 'form[name="editData"]', function(e) {
		e.preventDefault();
		const formData = new FormData(this);
		formData.append('_method', 'PUT');

		$.ajax({
			type: "POST",
			url: `${HOST}/pelanggan/edit/api`,
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
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
			error: function (response) {
				if(response.status == 403) {
					$('.floating-msg').addClass('show').html(`
								<div class="alert alert-danger">${response.responseJSON.msg}</div>
								`)
				}
			},
			complete: function () {
				$('#dataForm .modal-footer .loading-indicator').html('');
				$('form[name="editData"] input, form[name="editData"] textarea, form[name="editData"] button').attr('disabled', false)
			}
		})
	})

	$('.customers-to-csv').on('click', function(e) {
		e.preventDefault();
		$("#dataList").DataTable().button( '.buttons-excel' ).trigger();
	})

	$('.customers-reload').on('click', function(e) {
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
		getAllCustomers(obj);
	})

	// $('textarea[name=AlamatPengiriman1]').on('keyup', function() {
	// 	const maxlength = $(this).attr('maxlength');
	// 	const characterCount = $(this).val().length;
	// 	const current = $('#current');
	// 	const maximum = parseInt(maxlength) - parseInt(characterCount);
	// 	current.text(maximum);
	// 	if(maximum == 0) {
	// 		$('textarea[name=AlamatPengiriman2]').attr('disabled', false).focus();
	// 	}
	// });
});

function getAllCustomers(obj)
{
	$.ajax({
		type: "GET",
		url: `${HOST}/pelanggan/api`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}