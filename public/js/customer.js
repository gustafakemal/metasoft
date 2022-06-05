$(function () {

	let customerData;

	$("#customerList").DataTable({
		data: customerData,
		columnDefs: [{
			"searchable": false,
			"orderable": false,
			"targets": [0, 5]
		},{
			"width": 60,
			"targets": 5
		},{
			"width": 150,
			"targets": 1
		}],
		order: [[ 1, 'desc' ]],
		createdRow: function (row, data, dataIndex) {
			$(row).find("td:eq(0)").attr("data-label", "No");
			$(row).find("td:eq(1)").attr("data-label", "SPMB");
			$(row).find("td:eq(2)").attr("data-label", "Site");
			$(row).find("td:eq(3)").attr("data-label", "Step1");
			$(row).find("td:eq(4)").attr("data-label", "Step2");
			$(row).find("td:eq(5)").attr("data-label", "Step3");
		},
		initComplete: function () {
			const btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-customer-btn">Add customer</a>`;
			$("#customerList_wrapper .dataTables_length").prepend(btn);
		},
	});

	setTimeout(() => {
		$.ajax({
			type: "POST",
			url: `${HOST}/customer/apiGetAll`,
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
			complete: function () {}
		})
	}, 50)

	$('#customerList').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#customerList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();

	$('.add-customer-btn').on('click', function(e) {
		e.preventDefault();
		$('#customerForm').modal('show')
	})

	$('#customerForm').on('submit', 'form[name="addCustomer"]', function(e) {
		e.preventDefault();
		const formObj = new FormData(this);

		$.ajax({
			type: "POST",
			url: `${HOST}/customer/apiAddProcess`,
			dataType: 'JSON',
			data: formObj,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('#customerForm .modal-footer .loading-indicator').html(
					'<div class="spinner-icon">' +
						'<span class="spinner-border text-info"></span>' +
						'<span class="caption">Memproses data...</span>' +
					'</div>')
				$('form[name="addCustomer"] input, form[name="addCustomer"] button').attr('disabled', true)
			},
			success: function (response) {
				console.log(response)
			},
			error: function () {},
			complete: function () {
				$('#customerForm .modal-footer .loading-indicator').html('');
				$('form[name="addCustomer"] input, form[name="addCustomer"] button').attr('disabled', false)
			}
		})
	})

	$('#customerList').on('click', '.customer-detail', function(e) {
		e.preventDefault();
		$('#customerDetail').modal('show')
		const noPemesan = $(this).attr('data-id')
		$.ajax({
			type: "POST",
			url: `${HOST}/customer/apiGetById`,
			dataType: 'JSON',
			data: { noPemesan },
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

});