$(function () {

	bsCustomFileInput.init()

	let customerData;
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
		scrollX: true,
		initComplete: function () {},
	});

	$('form[name="form-caripartproduk"]').on('submit', function(e) {
		e.preventDefault();
		// $('.csc-form')[0].reset();
		// $('.csc-form').removeClass('show')
		// $('.csc-form .form-group.row-change-request').removeAttr('style')
		const keyword = $('input[name="caripartproduk"]').val();
		$.ajax({
			type: 'POST',
			url: `${HOST}/mfpartproduk/partProductSearch`,
			dataType: 'JSON',
			data: { keyword },
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					$('#dataList').DataTable().clear().rows.add(response.data).draw();
				} else {
					$('#dataList').DataTable().clear().draw();
				}
			},
			error: function () {},
			complete: function() {}
		})
	})

	// $('#dataList').DataTable().on( 'order.dt search.dt', function () {
	// 	let i = 1;
	// 	$('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
	// 		this.data(i++);
	// 	});
	// }).draw();

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
	// 				$('.tbl-data-partproduct').removeClass('show');
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
	// 				$('.tbl-data-partproduct').removeClass('show');
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
			$('.no-dok-mark').removeClass('d-none');
		} else {
			$('input[name="no_dokumen"]').attr('disabled', true)
			$('.no-dok-mark').addClass('d-none');
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
				$('.add-new-fgd input, .add-new-fgd select, .add-new-fgd textarea, .add-new-fgd button').attr('disabled', true)
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
				$('.add-new-fgd input, .add-new-fgd select, .add-new-fgd textarea, .add-new-fgd button').attr('disabled', false)
				setTimeout(() => {
					$('.floating-msg').removeClass('show');
				}, 3000);
			}
		})
	})

	// $('.add-new').on('click', function() {
	// 	$('.csc-form')[0].reset();
	// 	$('.csc-form').addClass('show add-new-fgd')
	// 	$('.tbl-data-partproduct').removeClass('show')
	// 	$('input[name="cariproduk"]').val('')
	// 	$('.csc-form input[name="fgd"]').val('(Auto)');
	// 	$('.csc-form .form-group.row-change-request').css('display', 'none')
	// 	$('.csc-form input[name="trevisi"]').val('0');
	// 	$('.frontside-selected').html('')
	// 	$('.backside-selected').html('')
	// 	$('.finishing-selected').html('')
	// 	$('.manual-selected').html('')
	// 	$('.khusus-selected').html('')
	// 	$('input[name="no_dokumen"]').attr('disabled', true)
	// })

	// $('form[name="partproduct-form"]').on('click', 'select[name="kertas"]', function (e) {
	// 	$.ajax({
	// 		type: 'GET',
	// 		url: `${HOST}/mfpartproduk/masters`,
	// 		beforeSend: function () {
	// 			$('select[name="kertas"]').append('<option value="loading">Loading...</option>')
	// 		},
	// 		success: function (response) {
	// 			console.log($('select[name="kertas"]').length)
	// 			if(response.success) {
	// 				for(let i = 0;i < response.data.length;i++) {
	// 					$('select[name="kertas"]').append(`<option value="${response.data[i].id}">${response.data[i].nama}</option>`)
	// 				}
	// 			}
	// 		},
	// 		complete: function () {
	// 			$('select[name="kertas"] option[value="loading"]').remove();
	// 		}
	// 	});
	// });

	const id_part_arr = location.pathname.split('/');
	const id_part = (id_part_arr.includes('rev')) ? id_part_arr[id_part_arr.length - 2] : id_part_arr[id_part_arr.length - 1];

	if(id_part_arr.includes('detail') || id_part_arr.includes('edit') || id_part_arr.includes('rev') || id_part_arr.includes('detailPartProduct') || id_part_arr.includes('editPartProduct')) {
		setTimeout(() => {
			loadDataSisi(id_part);

		}, 50)
	}

	$('form[name="partproduct-form"]').on('submit', function (e) {
		e.preventDefault();
		$('.msg').html('');
		const formData = new FormData(this);

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfpartproduk/apiAddProcess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('form[name="partproduct-form"] input, form[name="partproduct-form"] select, form[name="partproduct-form"] textarea, form[name="partproduct-form"] button').prop('disabled', true);
			},
			success: function (response) {
				if(response.success) {
					window.location.href = response.redirect_url
				} else {
					$('.msg').html(`<div class="alert alert-danger mb-4">${response.msg}</div>`);
				}
			},
			complete: function (res) {
				$('form[name="partproduct-form"] input:not(#trevisi), form[name="partproduct-form"] select, form[name="partproduct-form"] textarea, form[name="partproduct-form"] button').prop('disabled', false);
				const td = $('form[name="partproduct-form"] select[name="technical_draw"] option').filter(':selected').val();
				if(td === 'T') {
					$('form[name="partproduct-form"] input[name="no_dokumen"]').prop('disabled', true);
				}
				if( ! res.responseJSON.success ) {
					$('form[name="partproduct-form"], html, body').animate({
						scrollTop: $(".alert").offset().top + -90
					}, 500);
				}
			}
		});
	})

	$('form[name="partproduct-form_edit"]').on('submit', function (e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfpartproduk/apieditprocess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('form[name="partproduct-form_edit"] input, form[name="partproduct-form_edit"] select, form[name="partproduct-form_edit"] textarea, form[name="partproduct-form_edit"] button').prop('disabled', true);
			},
			success: function (response) {
				if(response.success) {
					location.reload();
				} else {
					$('.msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
				}
			},
			complete: function (res) {
				$('form[name="partproduct-form_edit"] input:not(#trevisi), form[name="partproduct-form_edit"] select, form[name="partproduct-form_edit"] textarea, form[name="partproduct-form_edit"] button').prop('disabled', false);
				const td = $('form[name="partproduct-form_edit"] select[name="technical_draw"] option').filter(':selected').val();
				if(td === 'T') {
					$('form[name="partproduct-form_edit"] input[name="no_dokumen"]').prop('disabled', true);
				}
				if( ! res.responseJSON.success ) {
					$('form[name="partproduct-form_edit"], html, body').animate({
						scrollTop: $(".alert").offset().top + -90
					}, 500);
				}
			}
		})
	});

	$('form[name="partproduct-form_rev"]').on('submit', function (e) {
		e.preventDefault();
		const formData = new FormData(this);

		formData.append('is_revision', '1');

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfpartproduk/apieditprocess`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('form[name="partproduct-form_rev"] input, form[name="partproduct-form_rev"] select, form[name="partproduct-form_rev"] textarea, form[name="partproduct-form_rev"] button').attr('disabled', true)
			},
			success: function (response) {
				if(response.success) {
					window.location.href = `${response.redirect_url}`
				} else {
					$('.msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
				}
			},
			complete: function (res) {
				$('form[name="partproduct-form_rev"] input, form[name="partproduct-form_rev"] select, form[name="partproduct-form_rev"] textarea, form[name="partproduct-form_rev"] button').attr('disabled', false)
				const td = $('form[name="partproduct-form_rev"] select[name="technical_draw"] option').filter(':selected').val();
				if(td === 'T') {
					$('form[name="partproduct-form_rev"] input[name="no_dokumen"]').prop('disabled', true);
				}
				if( ! res.responseJSON.success ) {
					$('form[name="partproduct-form_rev"], html, body').animate({
						scrollTop: $(".alert").offset().top + -90
					}, 500);
				}
			}
		})
	});

	$('.del-dokcr').on('click', function (e) {
		e.preventDefault();
		const confirmation = confirm('Hapus dokumen?')
		if(confirmation) {
			$('.dokcr-edit-wrap').addClass('hide');
			$('input[name="ex_file_dokcr"]').val('');
		}
	})

	$('.open-sisi-form').on('click', function (e) {
		e.preventDefault();
		$('#dataForm').modal({
			show: true,
			backdrop: 'static'
		});
		const id_part = $(this).attr('data-part');
		$.get(`${HOST}/MFPartProduk/actualNomorSisi/${id_part}`, function (response) {
			$('#dataForm input[name="sisi"]').val(response.no_sisi)
		})
		const part_name = $(this).attr('data-nama');
		$('.part-produk-title').html(part_name)
		$('#dataForm .sisi-form-modal').attr('name', 'add-sisi')
	})

	$('#dataForm, #dataDetail').on('hidden.bs.modal', function (event) {
		resetSisiModal();
	});

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

	$('#dataForm').on('submit', 'form[name="add-sisi"]', function (e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfpartproduk/apiaddsisi`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('.sisi-form-modal input:not(#frontside):not(#backside), .sisi-form-modal textarea, .sisi-form-modal select, .sisi-form-modal button').prop('disabled', true);
			},
			success: function (response) {
				if(response.success) {
					$('#dataForm').modal('hide');
					$('.floating-msg').html(`<div class="alert alert-success">${response.msg}</div>`).addClass('show');
					loadDataSisi(id_part)
				} else {
					$('.sisi-form-modal .msg').html(`<div class="alert alert-danger">${response.msg}</div>`);
				}
			},
			complete: function () {
				$('.sisi-form-modal input:not(#trevisi):not(#fgd), .sisi-form-modal textarea, .sisi-form-modal select, .sisi-form-modal button').prop('disabled', false);
				setTimeout(() => {
					$('.floating-msg').html('');
					$('.floating-msg').removeClass('show');
				}, 3000);
			}
		})
	});

	$('#dataForm').on('submit', 'form[name="edit-sisi"]', function (e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfpartproduk/apieditsisi`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				$('.sisi-form-modal input:not(#frontside):not(#backside), .sisi-form-modal textarea, .sisi-form-modal select, .sisi-form-modal button').prop('disabled', true);
			},
			success: function (response) {
				if(response.success) {
					$('#dataForm').modal('hide');
					$('.floating-msg').html(`<div class="alert alert-success">${response.msg}</div>`).addClass('show');
					loadDataSisi(id_part)
				} else {
					$('#dataForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`);
					$('#dataForm, html, body').animate({
						scrollTop: 0
					}, 500);
				}
			},
			complete: function () {
				$('.sisi-form-modal input:not(#trevisi):not(#fgd), .sisi-form-modal textarea, .sisi-form-modal select, .sisi-form-modal button').prop('disabled', false);
				setTimeout(() => {
					$('.floating-msg').html('');
					$('.floating-msg').removeClass('show');
				}, 3000);
			}
		})
	});

	$('#dataList').on('click', '.edit-sisi', function(e) {
		e.preventDefault();
		$('.sisi-form-modal').attr('name', 'edit-sisi')
		const id = $(this).attr('data-id');
		$('.sisi-form-modal input[name="id"]').val(id)
		$('#dataForm').modal({
			show: true,
			backdrop: 'static'
		});

		$.ajax({
			type: 'GET',
			url: `${HOST}/mfpartproduk/getSisiById/${id}`,
			beforeSend: function () {
				$('.sisi-form-modal input:not(#frontside):not(#backside):not(#trevisi), .sisi-form-modal textarea, .sisi-form-modal button').prop('disabled', true);
			},
			success: function (response) {
				const colors_el = ['fs_colors', 'bs_colors', 'manual_colors', 'finishing_colors', 'khusus_colors'];

				for(const prop in response.data) {
					if(colors_el.includes(prop)) {
						const spliter = prop.split('_')
						const prefix = spliter[0];
						let edited_array;
						if(prefix === 'fs') {
							edited_array = 'frontside';
						} else if(prefix === 'bs') {
							edited_array = 'backside';
						} else {
							edited_array = prefix;
						}
						let child_el = [];
						for(let i = 0;i < response.data[prop].length;i++) {
							let text;
							const item_class = `${prefix}color`;
							const value = response.data[prop][i].id;
							if(prefix == 'fs' || prefix == 'bs') {
								text = response.data[prop][i].nama
							} else {
								text = response.data[prop][i].proses
							}
							const add_el = (prefix == 'fs' || prefix == 'bs') ? `<label for="tinta" class="col-sm-2">&nbsp</label>` : '';
							child_el.push(`<div class="row mb-1 ${item_class}-${value}">
													${add_el}
													<div class="col-sm">${text}</div>
													<div class="col-sm">
														<input type="hidden" name="${item_class}[]" value="${value}" />
														<button type="button" class="btn-sm btn-danger del${prefix}" id="del${prefix}-${value}">
															<i class="fas fa-trash-alt text-light"></i>
														</button>
													</div>
											</div>`)
							color_tracker[edited_array].push(value.toString());
						}
						$(`.${prefix}-child`).html(child_el.join(''));
					}

					$(`.sisi-form-modal input[name="${prop}"]`).val(response.data[prop]);
					$(`.sisi-form-modal textarea[name="${prop}"]`).val(response.data[prop]);
				}
				console.log(color_tracker.frontside)
			},
			complete: function () {
				$('.sisi-form-modal input:not(#fgd):not(#trevisi), .sisi-form-modal textarea, .sisi-form-modal button').prop('disabled', false);
			}
		})
	})
		.on('click', '.view-sisi', function (e) {
			e.preventDefault();
			$('#dataDetail').modal({
				show: true,
				backdrop: 'static'
			})
			const id = $(this).attr('data-id');

			$.ajax({
				type: 'GET',
				url: `${HOST}/mfpartproduk/getSisiById/${id}`,
				beforeSend: function () {},
				success: function (response) {
					console.log(response)
					for(const prop in response.data) {

						const colors_el = ['fs_colors', 'bs_colors', 'manual_colors', 'finishing_colors', 'khusus_colors'];

						if(colors_el.includes(prop)) {
							const spliter = prop.split('_')
							const prefix = spliter[0];
							let child_el = [];
							for(let i = 0;i < response.data[prop].length;i++) {
								let text;
								if(prefix == 'fs' || prefix == 'bs') {
									text = response.data[prop][i].nama
								} else {
									text = response.data[prop][i].proses
								}
								child_el.push(text)
							}
							$(`.${prefix}-child`).html(child_el.join(', '));
						}

						$(`#dataDetail .${prop}`).html(response.data[prop])
					}
				},
			})
		})
});

function selectionAddedBox(id, name) {

}

function loadDataSisi(id_part)
{
	$.ajax({
		type: "POST",
		url: `${HOST}/mfpartproduk/apiAllSisiByPart`,
		dataType: 'JSON',
		data: {id: id_part},
		beforeSend: function () {},
		success: function (response) {
			if(response.success) {
				$('#dataList').DataTable().clear().rows.add(response.data).draw();
			}
		},
		error: function () {
			$('#dataList .dataTables_empty').html('Data gagal di retrieve.')
		},
	})
}

function resetSisiModal()
{
	$('.sisi-form-modal').removeAttr('name');
	$('.sisi-form-modal input[type="number"]:not(disabled)').val('0');
	$('.sisi-form-modal input[type="text"]:not([disabled])').val('');
	$('.sisi-form-modal textarea').val('');
	$('.sisi-form-modal input[name="id"]').val('')
	$('.sisi-view').html('')
	$('.fs-child, .bs-child, .manual-child, .finishing-child, .khusus-child').html('');
}

function colorAddItem(e)
{
	const {selectbox, item_container, item_class, input_name, del_class, group, tracker} = e.data;
	const select_box = `select[name="${selectbox}"]`;
	const option = $(`${select_box} option`).filter(':selected');
	const text = option.text();
	const value = option.val();
	const add_el = (group === 'frontside' || group === 'backside') ? `<label for="tinta" class="col-sm-2">&nbsp</label>` : '';
	if(value !== '0' && !tracker.includes(value)) {
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
	}
	$(`${select_box} option[value="0"]`).prop('selected', true);
}

function colorDelItem(event)
{
	const {item_container, item_class, group, tracker} = event.data;
	const id = $(this).attr('id').split('-');
	$(`.${item_container} .${item_class}-${id[1]}`).remove();;
}