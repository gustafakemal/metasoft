$(function () {

	bsCustomFileInput.init()

	let customerData;
	let partProduk;
	let fsval = [];
	let bsval = [];

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

	$("#dataPartProduk").DataTable({
		data: partProduk,
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

	setTimeout(() => {
		loadData(`${HOST}/mfproduk/apigetall`, '#dataList');
		loadData(`${HOST}/mfpartproduk/apigetall`, '#dataPartProduk');
		loadData(`${HOST}/mfpartproduk/apiallsisi`, '#dataSisi');
	}, 50);

	$('#dataList').on('click', '.edit-produk', function (e) {
		e.preventDefault();
		const id = parseInt($('.edit-produk').attr('data-id'));

		$('form[name="csc-form"] input[name="id"]').val(id);
		$('.tbl-data-product').removeClass('show');
		$('.csc-form').addClass('show edit-produk-form');

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfproduk/apiGetById`,
			dataType: 'JSON',
			data: {id},
			success: function (response) {
				if(response.success) {
					for(const prop in response.data) {
						$(`.edit-produk-form input[name="${prop}"]`).val(response.data[prop]);
					}
					loadSegmenOption(parseInt(response.data.segmen))
					loadSalesOption(response.data.sales);
					loadCustomerOption(response.data.customer)
					loadTujuanKirimOption(response.data.tujuan_kirim)
				}
			},
			error: function() {},
			complete: function() {}
		})
	});

	$('form[name="form-cariproduk"]').on('submit', function(e) {
		e.preventDefault();
		$('.csc-form')[0].reset();
		$('.csc-form').removeClass('show')
		$('.csc-form .form-group.row-change-request').removeAttr('style')
		const keyword = $('input[name="cariproduk"]').val();
		//alert(keyword);
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

	// $('#dataList tbody').on('click', '.edit-rev-item', function(e) {
	// 	const id = $(this).attr('data-id')
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: `${HOST}/mfproduk/apiGetById`,
	// 		dataType: 'JSON',
	// 		data: { id },
	// 		beforeSend: function () {},
	// 		success: function (response) {
	// 			console.log(response)
	// 			if(response.success) {
	// 				const fs_colors = response.data.frontside_colors;
	// 				const bs_colors = response.data.backside_colors;
	// 				$('.csc-form').addClass('show edit-revision-form');
	// 				$('.tbl-data-product').removeClass('show');
	// 				for(const property in response.data) {
	// 					$(`form[name="csc-form"] input[name="${property}"]`).val(response.data[property])
	// 					$(`form[name="csc-form"] select[name="${property}"] option[value="${response.data[property]}"]`).prop('selected', true)
	// 					$(`form[name="csc-form"] textarea[name="${property}"]`).html(response.data[property])
	// 				}
	// 				if(fs_colors.length > 0) {
	// 					let fs_elements = [];
	// 					for(let i = 0; i < fs_colors.length; i++) {
	// 						fsval.push(fs_colors[i].tinta)
	// 						fs_elements.push(`<div class="row mt-1" id="fs-row-${fs_colors[i].tinta}">
	// 											<div class="col-sm-9">${fs_colors[i].nama}</div>
	// 											<input type="hidden" value="${fs_colors[i].tinta}" name="frontside_colors[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${fs_colors[i].tinta}" id="del-frontside-btn"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.frontside-selected').html(fs_elements.join(''))
	// 				}
	// 				if(bs_colors.length > 0) {
	// 					let bs_elements = [];
	// 					for(let i = 0; i < bs_colors.length; i++) {
	// 						bsval.push(fs_colors[i].tinta)
	// 						bs_elements.push(`<div class="row mt-1" id="fs-row-${bs_colors[i].tinta}">
	// 											<div class="col-sm-9">${bs_colors[i].nama}</div>
	// 											<input type="hidden" value="${bs_colors[i].tinta}" name="backside_colors[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${bs_colors[i].tinta}" id="del-backside-btn"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.backside-selected').html(bs_elements.join(''))
	// 				}
	// 				if(response.data.finishing.length > 0) {
	// 					let finishing_elements = [];
	// 					for(let i = 0; i < response.data.finishing.length; i++) {
	// 						finishing_elements.push(`<div class="row mt-1" id="fs-row-${response.data.finishing[i].id}">
	// 											<div class="col-sm-9">${response.data.finishing[i].proses}</div>
	// 											<input type="hidden" value="${response.data.finishing[i].id}" name="finishing[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${response.data.finishing[i].id}"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.finishing-selected').html(finishing_elements.join(''))
	// 				}
	// 				if(response.data.manual.length > 0) {
	// 					let manual_elements = [];
	// 					for(let i = 0; i < response.data.manual.length; i++) {
	// 						manual_elements.push(`<div class="row mt-1" id="fs-row-${response.data.manual[i].id}">
	// 											<div class="col-sm-9">${response.data.manual[i].proses}</div>
	// 											<input type="hidden" value="${response.data.manual[i].id}" name="manual[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${response.data.manual[i].id}"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.manual-selected').html(manual_elements.join(''))
	// 				}
	// 				if(response.data.khusus.length > 0) {
	// 					let khusus_elements = [];
	// 					for(let i = 0; i < response.data.khusus.length; i++) {
	// 						khusus_elements.push(`<div class="row mt-1" id="fs-row-${response.data.khusus[i].id}">
	// 											<div class="col-sm-9">${response.data.khusus[i].proses}</div>
	// 											<input type="hidden" value="${response.data.khusus[i].id}" name="khusus[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${response.data.khusus[i].id}"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.khusus-selected').html(khusus_elements.join(''))
	// 				}
	// 				$(`form[name="csc-form"]`).prepend(`<input type="hidden" name="id" value="${response.data.id}" />`);
	// 				$('.csc-form input[name="tfgd"]').val(response.data.fgd);
	// 				$('.csc-form input[name="trevisi"]').val(response.data.revisi);
	// 			}
	// 		},
	// 		error: function () {},
	// 		complete: function() {}
	// 	})
	// });

	// $('#dataList tbody').on('click', '.rev-item', function(e) {
	// 	const id = $(this).attr('data-id')
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: `${HOST}/mfproduk/apiGetById`,
	// 		dataType: 'JSON',
	// 		data: { id },
	// 		beforeSend: function () {},
	// 		success: function (response) {
	// 			console.log(response.data.id)
	// 			if(response.success) {
	// 				const fs_colors = response.data.frontside_colors;
	// 				const bs_colors = response.data.backside_colors;
	// 				$('.csc-form').addClass('show add-revision-form');
	// 				$('.csc-form input[name="fgd"]').attr('readonly', 'readonly')
	// 				$('.tbl-data-product').removeClass('show');
	// 				for(const property in response.data) {
	// 					$(`form[name="csc-form"] input[name="${property}"]`).val(response.data[property])
	// 					$(`form[name="csc-form"] select[name="${property}"] option[value="${response.data[property]}"]`).prop('selected', true)
	// 					$(`form[name="csc-form"] textarea[name="${property}"]`).html(response.data[property])
	// 				}
	// 				if(fs_colors.length > 0) {
	// 					let fs_elements = [];
	// 					for(let i = 0; i < fs_colors.length; i++) {
	// 						fs_elements.push(`<div class="row mt-1" id="fs-row-${fs_colors[i].tinta}">
	// 											<div class="col-sm-9">${fs_colors[i].nama}</div>
	// 											<input type="hidden" value="${fs_colors[i].tinta}" name="frontside_colors[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${fs_colors[i].tinta}" id="del-frontside-btn"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.frontside-selected').html(fs_elements.join(''))
	// 				}
	// 				if(bs_colors.length > 0) {
	// 					let bs_elements = [];
	// 					for(let i = 0; i < bs_colors.length; i++) {
	// 						bs_elements.push(`<div class="row mt-1" id="fs-row-${bs_colors[i].tinta}">
	// 											<div class="col-sm-9">${bs_colors[i].nama}</div>
	// 											<input type="hidden" value="${bs_colors[i].tinta}" name="backside_colors[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${bs_colors[i].tinta}" id="del-backside-btn"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.backside-selected').html(bs_elements.join(''))
	// 				}
	// 				if(response.data.finishing.length > 0) {
	// 					let finishing_elements = [];
	// 					for(let i = 0; i < response.data.finishing.length; i++) {
	// 						finishing_elements.push(`<div class="row mt-1" id="fs-row-${response.data.finishing[i].id}">
	// 											<div class="col-sm-9">${response.data.finishing[i].proses}</div>
	// 											<input type="hidden" value="${response.data.finishing[i].id}" name="finishing[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${response.data.finishing[i].id}"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.finishing-selected').html(finishing_elements.join(''))
	// 				}
	// 				if(response.data.manual.length > 0) {
	// 					let manual_elements = [];
	// 					for(let i = 0; i < response.data.manual.length; i++) {
	// 						manual_elements.push(`<div class="row mt-1" id="fs-row-${response.data.manual[i].id}">
	// 											<div class="col-sm-9">${response.data.manual[i].proses}</div>
	// 											<input type="hidden" value="${response.data.manual[i].id}" name="manual[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${response.data.manual[i].id}"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.manual-selected').html(manual_elements.join(''))
	// 				}
	// 				if(response.data.khusus.length > 0) {
	// 					let khusus_elements = [];
	// 					for(let i = 0; i < response.data.khusus.length; i++) {
	// 						khusus_elements.push(`<div class="row mt-1" id="fs-row-${response.data.khusus[i].id}">
	// 											<div class="col-sm-9">${response.data.khusus[i].proses}</div>
	// 											<input type="hidden" value="${response.data.khusus[i].id}" name="khusus[]" />
	// 											<div class="col-sm-3">
	// 												<button class="btn btn-danger btn-sm" data-id="${response.data.khusus[i].id}"><i class="fas fa-minus"></i></button>
	// 											</div>
	// 										</div>`);
	// 					}
	// 					$('.khusus-selected').html(khusus_elements.join(''))
	// 				}
	// 				$(`form[name="csc-form"] input[name="fgd"]`).val(response.data.fgd)
	// 				$('.csc-form input[name="tfgd"]').val(response.data.fgd);
	// 				$('.csc-form input[name="trevisi"]').val('(Auto)');
	// 			}
	// 		},
	// 		error: function () {},
	// 		complete: function() {}
	// 	})
	// });

	$('#frontside-btn').on('click', function() {
		console.log(fsval)
		const fs = $('#warnafrontside').find(':selected').text();
		const fs_id = $('#warnafrontside').find(':selected').val();
		// const length = $('.frontside-selected').children().length

		if(fs_id !== '' && !fsval.includes(fs_id)) {
			fsval.push(fs_id)
			$('.frontside-selected').prepend(`
				<div class="row mt-1" id="fs-row-${fs_id}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="frontside_colors[]" />
					<div class="col-sm-3">
						<button class="btn btn-danger btn-sm" data-id="${fs_id}" id="del-frontside-btn"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#warnafrontside option:first').prop('selected', true)
		$('input[name="frontside"]').val(fsval.length)
	})

	$('#backside-btn').on('click', function() {
		const fs = $('#warnabackside').find(':selected').text();
		const fs_id = $('#warnabackside').find(':selected').val();
		// const length = $('.backside-selected').children().length

		if(fs_id !== '' && !bsval.includes(fs_id)) {
			bsval.push(fs_id)
			$('.backside-selected').prepend(`
				<div class="row mt-1" id="bs-row-${fs_id}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="backside_colors[]" />
					<div class="col-sm-3">
						<button class="btn btn-danger btn-sm" data-id="${fs_id}" id="del-backside-btn"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#warnabackside option:first').prop('selected', true)
		$('input[name="backside"]').val(bsval.length)
	})

	$('.frontside-selected').on('click', '#del-frontside-btn', function() {
		const id = $(this).attr('data-id');
		// const fsid = $(`.frontside-selected #fs-row-${id} input[name="frontside[]`).val()
		const idx = fsval.indexOf(id)
		if(idx > -1) {
			fsval.splice(idx, 1)
		}

		$(`.frontside-selected #fs-row-${id}`).remove()
		$('input[name="frontside"]').val(fsval.length)
	})

	$('.backside-selected').on('click', '#del-backside-btn', function() {
		const id = $(this).attr('data-id');
		// const bsid = $(`.backside-selected #bs-row-${id} input[name="backside[]`).val()
		const idx = bsval.indexOf(id)
		if(idx > -1) {
			bsval.splice(idx, 1)
		}

		$(`.backside-selected #bs-row-${id}`).remove()
		$('input[name="backside"]').val(bsval.length)
	})

	let fnsval = [];
	$('#finishing-btn').on('click', function() {
		const fs = $('#finishing').find(':selected').text();
		const fs_id = $('#finishing').find(':selected').val();
		// const length = $('.finishing-selected').children().length

		if(fs_id !== '' && !fnsval.includes(fs_id)) {
			fnsval.push(fs_id)
			$('.finishing-selected').prepend(`
				<div class="row mt-1" id="row-${fs_id}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="finishing[]" />
					<div class="col-sm-3">
						<button type="button" class="btn btn-danger btn-sm" data-id="${fs_id}"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#finishing option:first').prop('selected', true)
	})
	$('.finishing-selected').on('click', '.btn', function() {
		const id = $(this).attr('data-id');
		const idx = fnsval.indexOf(id)
		if(idx > -1) {
			fnsval.splice(idx, 1)
		}
		$(`.finishing-selected #row-${id}`).remove()
	})

	let mnval = []
	$('#manual-btn').on('click', function() {
		const fs = $('#manual').find(':selected').text();
		const fs_id = $('#manual').find(':selected').val();
		// const length = $('.manual-selected').children().length

		if(fs_id !== '' && !mnval.includes(fs_id)) {
			mnval.push(fs_id)
			$('.manual-selected').prepend(`
				<div class="row mt-1" id="row-${fs_id}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="manual[]" />
					<div class="col-sm-3">
						<button type="button" class="btn btn-danger btn-sm" data-id="${fs_id}"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#manual option:first').prop('selected', true)
	})
	$('.manual-selected').on('click', '.btn', function() {
		const id = $(this).attr('data-id');
		const idx = mnval.indexOf(id)
		if(idx > -1) {
			mnval.splice(idx, 1)
		}
		$(`.manual-selected #row-${id}`).remove()
	})

	let ksval = []
	$('#khusus-btn').on('click', function() {
		const fs = $('#khusus').find(':selected').text();
		const fs_id = $('#khusus').find(':selected').val();
		// const length = $('.khusus-selected').children().length

		if(fs_id !== '' && !ksval.includes(fs_id)) {
			ksval.push(fs_id)
			$('.khusus-selected').prepend(`
				<div class="row mt-1" id="row-${fs_id}">
					<div class="col-sm-9">${fs}</div>
					<input type="hidden" value="${fs_id}" name="khusus[]" />
					<div class="col-sm-3">
						<button type="button" class="btn btn-danger btn-sm" data-id="${fs_id}"><i class="fas fa-minus"></i></button>
					</div>
				</div>
			`)
		}
		$('#khusus option:first').prop('selected', true)
	})
	$('.khusus-selected').on('click', '.btn', function() {
		const id = $(this).attr('data-id');
		const idx = ksval.indexOf(id)
		if(idx > -1) {
			ksval.splice(idx, 1)
		}
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
			beforeSend: function () {
				$('.edit-revision-form input, .edit-revision-form select, .edit-revision-form textarea, .edit-revision-form button').attr('disabled', true)
			},
			success: function (response) {
				if(response.success) {
					$('.csc-form')[0].reset();
					$('.csc-form').removeClass('show edit-revision-form')
					$('input[name="cariproduk"]').val('')
					$('.csc-form input[name="id"]').remove()
					$('.floating-msg').html(`
						<div class="alert alert-success">${response.msg}</div>
						`)
				} else {
					$('.floating-msg').addClass('show')
					$('.floating-msg').html(`
						<div class="alert alert-danger">${response.msg}</div>
						`)
				}
			},
			error: function () {},
			complete: function() {
				$('.edit-revision-form input, .edit-revision-form select, .edit-revision-form textarea, .edit-revision-form button').attr('disabled', false)
				setTimeout(() => {
					$('.floating-msg').removeClass('show');
				}, 3000);
			}
		})
	})

	$('select[name="technical_draw"]').on('change', function() {
		if( $('option:selected', this).val() === 'Y' ) {
			$('input[name="no_dokumen"]').attr('disabled', false)
		} else {
			$('input[name="no_dokumen"]').attr('disabled', true)
		}
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
			beforeSend: function () {
				$('.add-revision-form input, .add-revision-form select, .add-revision-form textarea, .add-revision-form button').attr('disabled', true)
			},
			success: function (response) {
				if(response.success) {
					$('.csc-form')[0].reset();
					$('.csc-form').removeClass('show add-revision-form')
					$('input[name="cariproduk"]').val('')
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-success">${response.msg}</div>
						`)
				} else {
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-danger">${response.msg}</div>
						`)
				}
			},
			error: function () {},
			complete: function() {
				$('.add-revision-form input, .add-revision-form select, .add-revision-form textarea, .add-revision-form button').attr('disabled', false)
				setTimeout(() => {
					$('.floating-msg').removeClass('show');
				}, 3000);
			}
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
			beforeSend: function () {
				$('.add-new-fgd input, .add-new-fgd select, .add-new-fgd button').attr('disabled', true)
			},
			success: function (response) {
				if(response.success) {
					location.reload();
					// $('.tbl-data-product').addClass('show');
					// $('.csc-form').removeClass('show');
					// $('.floating-msg').addClass('show').html(`
					// 	<div class="alert alert-success">${response.msg}</div>
					// 	`)
				} else {
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-danger">${response.msg}</div>
						`)
				}
			},
			error: function () {},
			complete: function() {
				$('.add-new-fgd input, .add-new-fgd select, .add-new-fgd button').attr('disabled', false)
				setTimeout(() => {
					$('.floating-msg').removeClass('show');
				}, 3000);
			}
		})
	})

	$('.dynamic-content').on('submit', '.edit-produk-form', function(e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfproduk/apieditprocess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('.edit-produk-form input, .edit-produk-form select, .edit-produk-form button').attr('disabled', true)
			},
			success: function (response) {
				if(response.success) {
					location.reload();
				} else {
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-danger">${response.msg}</div>
						`)
				}
			},
			complete: function () {
				$('.edit-produk-form input, .edit-produk-form select, .edit-produk-form button').attr('disabled', false)
				setTimeout(() => {
					$('.floating-msg').removeClass('show');
				}, 3000);
			},
		})
	});

	$('.add-new').on('click', function() {
		loadSegmenOption();
		loadSalesOption();
		loadCustomerOption();
		loadTujuanKirimOption();
		$('.csc-form')[0].reset();
		$('.csc-form').addClass('show add-new-fgd')
		$('.tbl-data-product').removeClass('show')
		$('input[name="cariproduk"]').val('')
		$('.csc-form input[name="fgd"]').val('(Auto)');
		$('.csc-form .form-group.row-change-request').css('display', 'none')
		$('.csc-form input[name="trevisi"]').val('0');
		$('.frontside-selected').html('')
		$('.backside-selected').html('')
		$('.finishing-selected').html('')
		$('.manual-selected').html('')
		$('.khusus-selected').html('')
		$('input[name="no_dokumen"]').attr('disabled', true)
	})

	$('.add-sisi').on('click', function (e) {
		$('#dataFormSisi').modal({
			show: true,
			backdrop: 'static'
		})
		$.ajax({
			type: 'GET',
			url: `${HOST}/mfpartproduk/getdistinctivefgd`,
			success: function (response) {
				if(response.success) {
					const options = response.data.map((item) => {
						return `<option value="${item}">${item}</option>`
					})
					$('select[name="no_fgd"]').append(options.join(''));
				}
			}
		})
	})

	$('select[name="no_fgd"]').on('change', function () {
		const fgd = $(this).val();
		if(fgd !== '') {
			$('select[name="revisi"]').prop('disabled', false);
			$.ajax({
				type: 'GET',
				url: `${HOST}/mfpartproduk/getrevisibyfgd/${fgd}`,
				success: function (response) {
					if(response.success) {
						const options = response.data.map((item) => {
							return `<option value="${item}">${item}</option>`
						})
						$('select[name="revisi"]').html(`<option value="">-Pilih No Revisi-</option>${options.join('')}`);
					}
				}
			})
		} else {
			$('select[name="revisi"]').prop('disabled', true);
		}
	})

	let color_tracker = {
		frontside: [],
		backside: [],
		manual: [],
		finishing: [],
		khusus: []
	};
	const fs_params = {
		selectbox: 'fscolors',
		item_container: 'fs-child',
		item_class: 'fscolor',
		input_name: 'fscolor[]',
		del_class: 'delfs',
		group: 'frontside',
		tracker: color_tracker.frontside
	};
	const bs_params = {
		selectbox: 'bscolors',
		item_container: 'bs-child',
		item_class: 'bscolor',
		input_name: 'bscolor[]',
		del_class: 'delbs',
		group: 'backside',
		tracker: color_tracker.backside
	};
	const manual_params = {
		selectbox: 'manualcolors',
		item_container: 'manual-child',
		item_class: 'manualcolor',
		input_name: 'manualcolor[]',
		del_class: 'delmanual',
		group: 'manual',
		tracker: color_tracker.manual
	};
	const finishing_params = {
		selectbox: 'finishingcolors',
		item_container: 'finishing-child',
		item_class: 'finishingcolor',
		input_name: 'finishingcolor[]',
		del_class: 'delfinishing',
		group: 'finishing',
		tracker: color_tracker.finishing
	};
	const khusus_params = {
		selectbox: 'khususcolors',
		item_container: 'khusus-child',
		item_class: 'khususcolor',
		input_name: 'khususcolor[]',
		del_class: 'delkhusus',
		group: 'khusus',
		tracker: color_tracker.khusus
	};

	$('.add-fs').on('click', fs_params, colorAddItem);
	$('.fs-child').on('click', '.delfs', fs_params, colorDelItem)

	$('.add-bs').on('click', bs_params, colorAddItem);
	$('.bs-child').on('click', '.delbs', bs_params, colorDelItem)

	$('.add-manual').on('click', manual_params, colorAddItem);
	$('.manual-child').on('click', '.delmanual', manual_params, colorDelItem)

	$('.add-finishing').on('click', finishing_params, colorAddItem);
	$('.finishing-child').on('click', '.delfinishing', finishing_params, colorDelItem)

	$('.add-khusus').on('click', khusus_params, colorAddItem);
	$('.khusus-child').on('click', '.delkhusus', khusus_params, colorDelItem)
});

function selectionAddedBox(id, name) {

}

function loadData(url, element) {
	$.ajax({
		type: "GET",
		url,
		success: function (response) {
			if(response.success) {
				$(element).DataTable().clear().rows.add(response.data).draw();
			}
		},
		error: function () {
			$(`${element} .dataTables_empty`).html('Data gagal di retrieve.')
		},
		complete: function () {
		}
	})
}

function loadSegmenOption(defaultSelected = 0) {
	$.ajax({
		type: 'GET',
		url: `${HOST}/segmen/apiGetAll`,
		beforeSend: function () {
			$('select[name="segmen"]').append('<option value="-1">Loading...</option>')
		},
		success: function (response) {
			if(response.success) {
				const options = response.data.map((item) => {
					if(defaultSelected > 0 && parseInt(item.OpsiVal) === defaultSelected) {
						return `<option value="${item.OpsiVal}" selected>${item.OpsiTeks}</option>`
					}
					return `<option value="${item.OpsiVal}">${item.OpsiTeks}</option>`
				})
				if(defaultSelected > 0) {
					$('select[name="segmen"] option[value="0"]').prop('selected', false)
				}
				$('select[name="segmen"]').append(options.join(''));
			}
		},
		complete: function () {
			$('select[name="segmen"] option[value="-1"]').remove();
		}
	})
}

function loadSalesOption(defaultSelected = 0) {
	$.ajax({
		type: 'GET',
		url: `${HOST}/sales/apiGetAll`,
		beforeSend: function () {
			$('select[name="sales"]').append('<option value="-1">Loading...</option>')
		},
		success: function (response) {
			const options = response.map((item) => {
				if(defaultSelected > 0 && item[1] === defaultSelected) {
					return `<option value="${item[1]}" selected>${item[2]}</option>`
				}
				return `<option value="${item[1]}">${item[2]}</option>`
			})
			if(defaultSelected > 0) {
				$('select[name="sales"] option[value=""]').prop('selected', false)
			}
			$('select[name="sales"]').append(options.join(''));
		},
		complete: function () {
			$('select[name="sales"] option[value="-1"]').remove();
		}
	})
}

function loadCustomerOption(defaultSelected = 0) {
	$.ajax({
		type: 'GET',
		url: `${HOST}/customer/apiGetAll`,
		beforeSend: function () {
			$('select[name="customer"]').append('<option value="-1">Loading...</option>')
		},
		success: function (response) {
			const options = response.map((item) => {
				if(defaultSelected > 0 && item[1] === defaultSelected) {
					return `<option value="${item[1]}" selected>${item[3]}</option>`
				}
				return `<option value="${item[1]}">${item[3]}</option>`
			})
			$('select[name="customer"]').append(options.join(''));
		},
		complete: function () {
			$('select[name="customer"] option[value="-1"]').remove();
		}
	})
}

function loadTujuanKirimOption(defaultSelected = 0) {
	$.ajax({
		type: 'GET',
		url: `${HOST}/mftujuankirim/apiGetAll`,
		beforeSend: function () {
			$('select[name="tujuan_kirim"]').append('<option value="-1">Loading...</option>')
		},
		success: function (response) {
			const options = response.map((item) => {
				if(defaultSelected > 0 && item[1] === defaultSelected) {
					return `<option value="${item[1]}" selected>${item[3]}</option>`
				}
				return `<option value="${item[1]}">${item[3]}</option>`
			})
			$('select[name="tujuan_kirim"]').append(options.join(''));
		},
		complete: function () {
			$('select[name="tujuan_kirim"] option[value="-1"]').remove();
		}
	})
}

function colorAddItem(e)
{
	const {selectbox, item_container, item_class, input_name, del_class, group, tracker} = e.data;
	const select_box = `select[name="${selectbox}"]`;
	const text = $(`${select_box} option`).filter(':selected').text();
	const value = $(`${select_box} option`).filter(':selected').val();
	const add_el = (group == 'frontside' || group == 'backside') ? `<label for="tinta" class="col-sm-2">&nbsp</label>` : '';
	if(value != '0' && !tracker.includes(value)) {
		$(`.${item_container}`).prepend(`<div class="row mb-1 ${item_class}-${value}">
							${add_el}
							<div class="col-sm">${text}</div>
							<div class="col-sm">
								<input type="hidden" name="${input_name}" value="${value}" />
								<button type="button" class="btn-sm btn-danger ${del_class}" id="${del_class}-${value}">
									<i class="fas fa-trash-alt text-light"></i>
								</button>
							</div>
					</div>`)
		tracker.push(value)
		$(`#dataForm input[name="${group}"]`).val(tracker.length);
	}
	$(`${select_box} option[value="0"]`).prop('selected', true);
}

function colorDelItem(event)
{
	const {item_container, item_class, group, tracker} = event.data;
	const id = $(this).attr('id').split('-');
	const idx = tracker.indexOf(id[1]);
	if(idx > -1) {
		tracker.splice(idx, 1);
	}
	$(`.${item_container} .${item_class}-${id[1]}`).remove();
	$(`#dataForm input[name="${group}"]`).val(tracker.length);
}