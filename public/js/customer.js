$(function () {

	let customerData;

	$("#dataList").DataTable({
		data: customerData,
        buttons: [{
                extend: 'excelHtml5',
                exportOptions: { orthogonal: 'export' }
            }],
		columnDefs: [{
			"searchable": false,
			"orderable": false,
			"targets": [0, 18]
		},{
			"width": 60,
			"targets": 18
		},{
			"targets": 14,
			render: function ( data, type, row, meta ) {
				if(type === 'export') {
					return data;
				} else {
					return (data == 'A') ? 'Ya' : 'Tidak';
				}
			}
		},{
			"width": 150,
			"targets": 2
		},
		{
			className: 'dt-body-nowrap',
			"targets": 18
		},
		{
			"visible": false,
			"targets": [1,4, 5, 6, 8, 9, 10, 11, 12, 13, 15, 16, 17]
		}],
		order: [[ 1, 'desc' ]],
		createdRow: function (row, data, dataIndex) {
			$(row).find("td:eq(0)").attr("data-label", "No");
			$(row).find("td:eq(1)").attr("data-label", "Tanggal dibuat");
			$(row).find("td:eq(2)").attr("data-label", "Nama Pemesan");
			$(row).find("td:eq(3)").attr("data-label", "Contact person");
			$(row).find("td:eq(4)").attr("data-label", "Wajib pajak");
			$(row).find("td:eq(5)").attr("data-label", "&nbsp;");
		},
		initComplete: function () {
			const dropdown = `<div class="dropdown d-inline mr-2">` +
								`<button class="btn btn-primary dropdown-toggle" type="button" id="dataTableDropdown" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></button>` +
								`<div class="dropdown-menu" aria-labelledby="dataTableDropdown">` +
								`<a class="dropdown-item customers-reload" href="#">Reload data</a>` +
								`<a class="dropdown-item customers-to-csv" href="#">Export to excel</a>` +
							`</div>` +
						`</div>`
			const add_btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-customer-btn">Tambah data</a>`;
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

		getAllCustomers(obj);
	}, 50)

	$('#dataList').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();

	$('.add-customer-btn').on('click', function(e) {
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
			url: `${HOST}/api/master/customer`,
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
		const noPemesan = $(this).attr('data-id')
		$.ajax({
			type: "GET",
			url: `${HOST}/api/master/customer/${noPemesan}?modified=yes`,
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
			url: `${HOST}/api/master/customer/${noPemesan}`,
			dataType: 'JSON',
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
		// formData.append('_method', 'POST');
		// console.log(...formData)

		$.ajax({
			type: "PUT",
			url: `${HOST}/api/master/customer`,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			// contentType: 'application/x-www-form-urlencoded; charset=utf-8',
			dataType: 'JSON',
			data: formData,
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
		url: `${HOST}/api/master/customer`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}