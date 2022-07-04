$(function () {

	let customerData;

	$("#dataList").DataTable({
		data: customerData,
		paging: false,
		searching: false,
        buttons: [{
                extend: 'excelHtml5',
                exportOptions: { orthogonal: 'export' }
            }],
		columnDefs: [],
		order: [[ 2, 'desc' ]],
		initComplete: function () {},
	});

	$('form[name="form-cariproduk"]').on('submit', function(e) {
		e.preventDefault();
		$('.csc-form')[0].reset();
		$('.csc-form').removeClass('show')
		const keyword = $('input[name="cariproduk"]').val();

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfproduk/productSearch`,
			dataType: 'JSON',
			data: { keyword },
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					$('#dataList').DataTable().clear();
					$('#dataList').DataTable().rows.add(response.data);
					$('#dataList').DataTable().draw();
					$('.tbl-data-product').addClass('show');
				}
			},
			error: function () {},
			complete: function() {}
		})
	})

	$('#dataList').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();

	$('#dataList tbody').on('click', '.edit-rev-item', function(e) {
		const id = $(this).attr('data-id')
		$.ajax({
			type: 'POST',
			url: `${HOST}/mfproduk/apiGetById`,
			dataType: 'JSON',
			data: { id },
			beforeSend: function () {},
			success: function (response) {
				console.log(response.data.id)
				if(response.success) {
					$('.csc-form').addClass('show edit-revision-form');
					$('.tbl-data-product').removeClass('show');
					for(const property in response.data) {
						$(`form[name="csc-form"] input[name="${property}"]`).val(response.data[property])
						$(`form[name="csc-form"] select[name="${property}"] option[value="${response.data[property]}"]`).prop('selected', true)						
						$(`form[name="csc-form"] textarea[name="${property}"]`).html(response.data[property])
					}
					$(`form[name="csc-form"]`).prepend(`<input type="hidden" name="id" value="${response.data.id}" />`);
				}
			},
			error: function () {},
			complete: function() {}
		})
	});

	$('#dataList tbody').on('click', '.rev-item', function(e) {
		const id = $(this).attr('data-id')
		$.ajax({
			type: 'POST',
			url: `${HOST}/mfproduk/apiGetById`,
			dataType: 'JSON',
			data: { id },
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					$('.csc-form').addClass('show add-revision-form');
					$('.csc-form input[name="fgd"]').attr('readonly', 'readonly')
					$('.tbl-data-product').removeClass('show');
					$(`form[name="csc-form"] input[name="fgd"]`).val(response.data.fgd)
				}
			},
			error: function () {},
			complete: function() {}
		})
	});

	$('#frontside-btn').on('click', function() {
		const fs = $('#warnafrontside').find(':selected').text();
		const fs_id = $('#warnafrontside').find(':selected').val();
		const length = $('.frontside-selected').children().length

		if(fs_id !== '') {
			$('.frontside-selected').prepend(`
				<div class="row mt-1" id="fs-row-${length}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="frontside[]" />
					<div class="col-sm-3">
						<button class="btn btn-danger btn-sm" data-id="${length}" id="del-frontside-btn"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#warnafrontside option:first').prop('selected', true)
	})

	$('#backside-btn').on('click', function() {
		const fs = $('#warnabackside').find(':selected').text();
		const fs_id = $('#warnabackside').find(':selected').val();
		const length = $('.backside-selected').children().length

		if(fs_id !== '') {
			$('.backside-selected').prepend(`
				<div class="row mt-1" id="bs-row-${length}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="backside[]" />
					<div class="col-sm-3">
						<button class="btn btn-danger btn-sm" data-id="${length}" id="del-backside-btn"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#warnabackside option:first').prop('selected', true)
	})

	$('.frontside-selected').on('click', '#del-frontside-btn', function() {
		const id = $(this).attr('data-id');

		$(`.frontside-selected #fs-row-${id}`).remove()
	})

	$('.backside-selected').on('click', '#del-backside-btn', function() {
		const id = $(this).attr('data-id');

		$(`.backside-selected #bs-row-${id}`).remove()
	})

	$('#finishing-btn').on('click', function() {
		const fs = $('#finishing').find(':selected').text();
		const fs_id = $('#finishing').find(':selected').val();
		const length = $('.finishing-selected').children().length

		if(fs_id !== '') {
			$('.finishing-selected').prepend(`
				<div class="row mt-1" id="row-${length}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="finishing[]" />
					<div class="col-sm-3">
						<button type="button" class="btn btn-danger btn-sm" data-id="${length}"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#finishing option:first').prop('selected', true)
	})
	$('.finishing-selected').on('click', '.btn', function() {
		const id = $(this).attr('data-id');
		$(`.frontside-selected #row-${id}`).remove()
	})

	$('#manual-btn').on('click', function() {
		const fs = $('#manual').find(':selected').text();
		const fs_id = $('#manual').find(':selected').val();
		const length = $('.manual-selected').children().length

		if(fs_id !== '') {
			$('.manual-selected').prepend(`
				<div class="row mt-1" id="row-${length}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="manual[]" />
					<div class="col-sm-3">
						<button type="button" class="btn btn-danger btn-sm" data-id="${length}"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#manual option:first').prop('selected', true)
	})
	$('.manual-selected').on('click', '.btn', function() {
		const id = $(this).attr('data-id');
		$(`.manual-selected #row-${id}`).remove()
	})

	$('#khusus-btn').on('click', function() {
		const fs = $('#khusus').find(':selected').text();
		const fs_id = $('#khusus').find(':selected').val();
		const length = $('.khusus-selected').children().length

		if(fs_id !== '') {
			$('.khusus-selected').prepend(`
				<div class="row mt-1" id="row-${length}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="khusus[]" />
					<div class="col-sm-3">
						<button type="button" class="btn btn-danger btn-sm" data-id="${length}"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#khusus option:first').prop('selected', true)
	})
	$('.khusus-selected').on('click', '.btn', function() {
		const id = $(this).attr('data-id');
		$(`.khusus-selected #row-${id}`).remove()
	})

	$('.dynamic-content').on('submit', '.edit-revision-form', function(e) {
		e.preventDefault();
		const formData = new FormData(this)

		// for (var pair of formData.entries()) {
		// 	console.log(pair[0]+ ', ' + pair[1]);
		// }

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfproduk/apiEditRevision`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {},
			success: function (response) {
				console.log(response)
				if(response.success) {
					$('.csc-form')[0].reset();
					$('.csc-form').removeClass('show edit-revision-form')
					$('input[name="cariproduk"]').val('')
					$('.csc-form input[name="id"]').remove()
					$('.msg_success').html(`
						<div class="alert alert-success">${response.msg}</div>
						`)
				}
			},
			error: function () {},
			complete: function() {}
		})
	})

	$('.dynamic-content').on('submit', '.add-revision-form', function(e) {
		e.preventDefault();
		const formData = new FormData(this)

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfproduk/apiAddRevision`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					$('.csc-form')[0].reset();
					$('.csc-form').removeClass('show add-revision-form')
					$('input[name="cariproduk"]').val('')
					$('.msg_success').html(`
						<div class="alert alert-success">${response.msg}</div>
						`)
				}
			},
			error: function () {},
			complete: function() {}
		})
	})

	$('.dynamic-content').on('submit', '.add-new-fgd', function(e) {
		e.preventDefault();
		const formData = new FormData(this)

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfproduk/apiAddProcess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					$('.csc-form')[0].reset();
					$('.csc-form').removeClass('show add-revision-form')
					$('input[name="cariproduk"]').val('')
					$('.msg_success').html(`
						<div class="alert alert-success">${response.msg}</div>
						`)
				}
			},
			error: function () {},
			complete: function() {}
		})
	})

	$('.add-new').on('click', function() {
		$('.csc-form')[0].reset();
		$('.csc-form').addClass('show add-new-fgd')
		$('.tbl-data-product').removeClass('show')
		$('input[name="cariproduk"]').val('')
	})
});