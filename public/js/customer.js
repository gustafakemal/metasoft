$(function () {

	let customerData;

	$("#customerList").DataTable({
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
					return (data == 'A') ? 'Aktif' : 'Nonaktif';
				}
			}
		},{
			"width": 150,
			"targets": 2
		},{
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
								`<button class="btn btn-primary dropdown-toggle" type="button" id="customersDropdown" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></button>` +
								`<div class="dropdown-menu" aria-labelledby="customersDropdown">` +
								`<a class="dropdown-item customers-reload" href="#">Reload data</a>` +
								`<a class="dropdown-item customers-to-csv" href="#">Export to excel</a>` +
							`</div>` +
						`</div>`
			const add_btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-customer-btn">Add customer</a>`;
			$("#customerList_wrapper .dataTables_length").prepend(dropdown + add_btn);
		},
	});

	setTimeout(() => {
		const obj = {
			beforeSend: function () {
				$('#customerList .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
			},
			success: function (response) {
				$('#customerList').DataTable().clear();
				$('#customerList').DataTable().rows.add(response);
				$('#customerList').DataTable().draw();
			},
			error: function () {
				$('#customerList .dataTables_empty').html('Data gagal di retrieve.')
			},
			complete: function() {}
		}

		getAllCustomers(obj);
	}, 50)

	$('#customerList').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#customerList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();

	$('.add-customer-btn').on('click', function(e) {
		e.preventDefault();
		$('#customerForm').modal({
			show: true,
			backdrop: 'static'
		})
		$('#customerForm form').attr('name', 'addCustomer')
		$('#customerForm .modal-title').html('Add customer')
	})

	$('#customerForm').on('submit', 'form[name="addCustomer"]', function(e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: "POST",
			url: `${HOST}/customer/apiAddProcess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('#customerForm .modal-footer .loading-indicator').html(
					'<div class="spinner-icon">' +
						'<span class="spinner-border text-info"></span>' +
						'<span class="caption">Memproses data...</span>' +
					'</div>')
				$('form[name="addCustomer"] input, form[name="addCustomer"] textarea, form[name="addCustomer"] button').attr('disabled', true)
			},
			success: function (response) {
				if(response.success) {
					location.reload();
				} else {
					$('#customerForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
					$('#customerForm, html, body').animate({
						scrollTop: 0
					}, 500);
				}
			},
			error: function () {},
			complete: function () {
				$('#customerForm .modal-footer .loading-indicator').html('');
				$('form[name="addCustomer"] input, form[name="addCustomer"] textarea, form[name="addCustomer"] button').attr('disabled', false)
			}
		})
	})

	$('#customerForm').on('hidden.bs.modal', function (event) {
		$('#customerForm form[name="addCustomer"], #customerForm form[name="editCustomer"]')[0].reset();
		$('#customerForm .msg').html('')
	})

	$('#customerList').on('click', '.item-detail', function(e) {
		e.preventDefault();
		$('#customerDetail').modal('show')
		const noPemesan = $(this).attr('data-id')
		$.ajax({
			type: "POST",
			url: `${HOST}/customer/apiGetById`,
			dataType: 'JSON',
			data: { noPemesan, modified: true },
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					for(const property in response.data) {
						$(`#customerDetail .${property}`).html(response.data[property])
					}
				}
			},
			error: function () {},
			complete: function () {}
		})
	})

	$('#customerList').on('click', '.item-edit', function(e) {
		e.preventDefault();
		$('#customerForm').modal({
			show: true,
			backdrop: 'static'
		})
		$('#customerForm .modal-title').html('Edit customer')
		$('#customerForm form').attr('name', 'editCustomer')

		const noPemesan = $(this).attr('data-id')
		$('#customerForm form input[name="NoPemesan"]').val(noPemesan)

		$.ajax({
			type: "POST",
			url: `${HOST}/customer/apiGetById`,
			dataType: 'JSON',
			data: { noPemesan },
			beforeSend: function () {},
			success: function (response) {
				console.log(response)
				if(response.success) {
					for(const property in response.data) {
						$(`#customerForm input[name="${property}"], #customerForm textarea[name="${property}"]`).val(response.data[property])
					}
				}
			},
			error: function () {},
			complete: function () {}
		})
	});

	$('#customerForm').on('submit', 'form[name="editCustomer"]', function(e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: "POST",
			url: `${HOST}/customer/apiEditProcess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('#customerForm .modal-footer .loading-indicator').html(
					'<div class="spinner-icon">' +
						'<span class="spinner-border text-info"></span>' +
						'<span class="caption">Memproses data...</span>' +
					'</div>')
				$('form[name="editCustomer"] input, form[name="editCustomer"] textarea, form[name="editCustomer"] button').attr('disabled', true)
			},
			success: function (response) {
				console.log(response)
				if(response.success) {
					location.reload();
				} else {
					$('#customerForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
					$('#customerForm, html, body').animate({
						scrollTop: 0
					}, 500);
				}
			},
			error: function () {},
			complete: function () {
				$('#customerForm .modal-footer .loading-indicator').html('');
				$('form[name="editCustomer"] input, form[name="editCustomer"] textarea, form[name="editCustomer"] button').attr('disabled', false)
			}
		})
	})

	$('.customers-to-csv').on('click', function(e) {
		e.preventDefault();
		$("#customerList").DataTable().button( '.buttons-excel' ).trigger();
	})

	$('.customers-reload').on('click', function(e) {
		e.preventDefault();
		const obj = {
			beforeSend: function () {
				$('#statusList').DataTable().clear();
				$('#statusList').DataTable().draw();
				$('#customerList .dataTables_empty').html('<div class="spinner-icon"><span class="spinner-grow text-info"></span><span class="caption">Fetching data...</span></div>')
			},
			success: function (response) {
				$('#customerList').DataTable().clear();
				$('#customerList').DataTable().rows.add(response);
				$('#customerList').DataTable().draw();
			},
			error: function () {
				$('#customerList .dataTables_empty').html('Data gagal di retrieve.')
			},
			complete: function() {}
		}
		getAllCustomers(obj);
	})

	$('textarea[name=AlamatPengiriman1]').on('keyup', function() {
		const maxlength = $(this).attr('maxlength');
		const characterCount = $(this).val().length;
		const current = $('#current');
		const maximum = parseInt(maxlength) - parseInt(characterCount);
		current.text(maximum);
		if(maximum == 0) {
			$('textarea[name=AlamatPengiriman2]').attr('disabled', false).focus();
		}
	});
});

function getAllCustomers(obj)
{
	$.ajax({
		type: "POST",
		url: `${HOST}/customer/apiGetAll`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}