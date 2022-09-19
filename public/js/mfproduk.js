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
		order: [[ 1, 'desc' ]],
		scrollX: true,
		initComplete: function () {},
	});

	$("#dataPartHasilCari").DataTable({
		data: customerData,
		paging: false,
		searching: false,
		columnDefs: [],
		order: [[ 2, 'desc' ]],
		initComplete: function () {},
	});

	const id_produk_arr = location.pathname.split('/');
	let id_produk;
	if(id_produk_arr[id_produk_arr.length - 1] === '') {
		id_produk = id_produk_arr[id_produk_arr.length - 2];
	} else {
		id_produk = id_produk_arr[id_produk_arr.length - 1];
	}

	if(checkURLWithParam('edit')) {
		setTimeout(() => {
			loadData(`${HOST}/mfpartproduk/apiGetByProduct/${id_produk}`, '#dataPartProduk');
		}, 50);
	}

	$('#dataList').on('click', '.edit-produk', function (e) {
		e.preventDefault();
		const id = parseInt($('.edit-produk').attr('data-id'));

		$('form[name="csc-form"] input[name="id"]').val(id);
		$('.tbl-data-product').removeClass('show');
		$('.csc-form').addClass('show edit-produk-form');
		$('form[name="form-cariproduk"] input, form[name="form-cariproduk"] button[type="submit"]').prop('disabled', true)
		$('form[name="form-cariproduk"] button[type="button"]').text('Batal')

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
		const keyword = $('input[name="cariproduk"]').val();

		$('.tbl-data-product').addClass('show')

		searchProduct(keyword);
	});

	$('#dataList').on('click', '.del-item-product', function (e) {
		e.preventDefault();
		if(confirm('Yakin menghapus?')) {
			const id = $(this).attr('data-id');
			const keyword = $(this).attr('data-keyword');

			$.ajax({
				type: 'POST',
				url: `${HOST}/MFProduk/delItemProduct`,
				dataType: 'JSON',
				data: {id},
				beforeSend: function () {},
				success: function (response) {
					console.log(response);
					if (response.success) {
						searchProduct(keyword);
						$('.floating-msg').addClass('show').html(`
							<div class="alert alert-success">${response.msg}</div>
							`)
					} else {
						$('.floating-msg').addClass('show').html(`
							<div class="alert alert-danger">${response.msg}</div>
							`)
					}
				},
				complete: function () {
					setTimeout(() => {
						$('.floating-msg').removeClass('show').html('');
					}, 3000)
				}
			})
		}
	})

	$('.open-search').on('click', function (e) {
		e.preventDefault();
		const id_produk = $(this).attr('data-id');
		$('#cariPart').modal({
			show: true,
			backdrop: 'static'
		})

		$('form[name="form-caripartproduk"]').on('submit', function(e) {
			e.preventDefault();
			const keyword = $('input[name="caripartproduk"]').val();
			$.ajax({
				type: 'POST',
				url: `${HOST}/mfpartproduk/partProductSearch`,
				dataType: 'JSON',
				data: { keyword, full: false, id_produk },
				beforeSend: function () {},
				success: function (response) {
					if(response.success) {
						$('#dataPartHasilCari').DataTable().clear().rows.add(response.data).draw();
					} else {
						$('#dataPartHasilCari').DataTable().clear().draw();
					}
				},
				error: function () {},
				complete: function() {}
			})
		})
	})

	$('#cariPart').on('click', '.add-to-product', function(e) {
		e.preventDefault();
		const id_part = $(this).attr('data-idpart');
		const id_produk = $(this).attr('data-idproduk');

		$.ajax({
			type: 'POST',
			url: `${HOST}/MFPartProduk/apiAddToProduct`,
			dataType: 'JSON',
			data: {id_produk, id_part},
			beforeSend: function() {
				$(`#dataPartHasilCari button[data-idpart="${id_part}"]`).html('Loading...').prop('disabled', true);
			},
			success: function (response) {
				if(response.success) {
					loadData(`${HOST}/mfpartproduk/apiGetByProduct/${id_produk}`, '#dataPartProduk');
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-success">${response.msg}</div>
						`)
				} else {
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-success">${response.msg}</div>
						`)
				}
			},
			complete: function () {
				// $('#cariPart .add-to-product').prop('disabled', false);
				setTimeout(() => {
					$('.floating-msg').removeClass('show').html('');
				}, 3000)
				$(`#dataPartHasilCari button[data-idpart="${id_part}"]`).html('Tambahkan')
			}
		})
	})

	$('#dataList').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();



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

	$('.edit-produk-form').on('click', 'select[name="segmen"]', function (e) {
		const val = $('.edit-produk-form select[name="segmen"] option').filter(':selected').val();
		loadSegmenOption(parseInt(val), false);
	})
		.on('click', 'select[name="sales"]', function (e) {
			const val = $('.edit-produk-form select[name="sales"] option').filter(':selected').val();
			loadSalesOption(parseInt(val), false);
		})
		.on('click', 'select[name="customer"]', function (e) {
			const val = $('.edit-produk-form select[name="customer"] option').filter(':selected').val();
			loadCustomerOption(parseInt(val), false);
		})
		.on('click', 'select[name="tujuan_kirim"]', function (e) {
			const val = $('.edit-produk-form select[name="tujuan_kirim"] option').filter(':selected').val();
			loadTujuanKirimOption(parseInt(val), false);
		})

	$('.add-new').on('click', function() {
		loadSegmenOption();
		loadSalesOption();
		loadCustomerOption();
		loadTujuanKirimOption();

		const cariproduk = $('input[name="cariproduk"]');
		const teks = ($(this).text() === 'Buat Baru') ? 'Batal' : 'Buat Baru';
		$(this).text(teks)
		$('.csc-form').toggleClass('show add-new-fgd')[0].reset()

		if(cariproduk.val() !== '') {
			cariproduk.val('')
			$('#dataList').DataTable().clear().draw();
			$('.tbl-data-product').removeClass('show')
		}
		const btn = $('form[name="form-cariproduk"] button[type="submit"]');
		cariproduk.prop('disabled', (!btn.prop('disabled')))
		btn.prop('disabled', (!btn.prop('disabled')))
	})

	$('.add-sisi').on('click', function (e) {
		$('#dataFormSisi').modal({
			show: true,
			backdrop: 'static'
		})
		$('.sisi-form-modal').attr('name', 'add-sisi');

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

	$('#dataFormSisi').on('hidden.bs.modal', function (event) {
		resetSisiModal();
	});

	$('#cariPart').on('hidden.bs.modal', function (event) {
		$('#cariPart input[name="caripartproduk"]').val('');
		$('#dataPartHasilCari').DataTable().clear().draw();
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

	$('#dataFormSisi').on('submit', 'form[name="add-sisi"]', function (e) {
		e.preventDefault();
		const formData = new FormData(this);

		$.ajax({
			type: 'POST',
			url: `${HOST}/mfpartproduk/apiaddsisi/1`,
			dataType: 'JSON',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {},
			success: function (response) {
				if(response.success) {
					$('#dataFormSisi').modal('hide');
					$('.floating-msg').html(`<div class="alert alert-success">${response.msg}</div>`).addClass('show');
					loadData(`${HOST}/mfpartproduk/apiallsisi`, '#dataSisi');
				} else {
					$('#dataFormSisi .msg').html(`<div class="alert alert-danger">${response.msg}</div>`);
					$('#dataFormSisi, html, body').animate({
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
	})

	$('#dataFormSisi').on('submit', 'form[name="edit-sisi"]', function (e) {
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
				// if(response.success) {
				// 	$('#dataForm').modal('hide');
				// 	$('.floating-msg').html(`<div class="alert alert-success">${response.msg}</div>`).addClass('show');
				// 	loadDataSisi(id_part)
				// } else {
				// 	$('#dataForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`);
				// 	$('#dataForm, html, body').animate({
				// 		scrollTop: 0
				// 	}, 500);
				// }
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

	$('#dataSisi').on('click', '.edit-sisi', function(e) {
		e.preventDefault();
		$('.sisi-form-modal').attr('name', 'edit-sisi')
		const id = $(this).attr('data-id');
		const fgd = $(this).attr('data-fgd');
		const revisi = $(this).attr('data-revisi');
		$('.sisi-form-modal input[name="id"]').val(id)
		$('input[name="fgd"]').val($('input[name="src_fgd"]').val())
		$('input[name="trevisi"]').val($('input[name="src_revisi"]').val())
		$('#dataFormSisi').modal({
			show: true,
			backdrop: 'static'
		});

		$.get(`${HOST}/mfpartproduk/getdistinctivefgd`, function (response) {
			for(let i = 0;i < response.data.length;i++) {
				const selected = (fgd == response.data[i]) ? ' selected' : '';
				$('select[name="no_fgd"]').append(`<option${selected} value="${response.data[i]}">${response.data[i]}</option>`);
			}
		})

		$.get(`${HOST}/mfpartproduk/getrevisibyfgd/${fgd}`, function (response) {
			$('select[name="revisi"]').prop('disabled', false);
			for(let i = 0;i < response.data.length;i++) {
				const selected = (revisi == response.data[i]) ? ' selected' : '';
				$('select[name="revisi"]').append(`<option${selected} value="${response.data[i]}">${response.data[i]}</option>`);
			}
		})

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
						let child_el = [];
						for(let i = 0;i < response.data[prop].length;i++) {
							const item_class = `${prefix}color`;
							const value = response.data[prop][i].id;
							const text = response.data[prop][i].nama
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
						}
						$(`.${prefix}-child`).html(child_el.join(''));
					}

					$(`.sisi-form-modal input[name="${prop}"]`).val(response.data[prop]);
					$(`.sisi-form-modal textarea[name="${prop}"]`).val(response.data[prop]);
				}
			},
			complete: function () {
				$('.sisi-form-modal input:not(#frontside):not(#backside):not(#fgd), .sisi-form-modal textarea, .sisi-form-modal button').prop('disabled', false);
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
								const text = response.data[prop][i].nama
								child_el.push(`<li>${text}</li>`)
							}
							$(`.${prefix}-child`).html(`<ul>${child_el.join('')}</ul>`);
						}

						$(`#dataDetail .${prop}`).html(response.data[prop])
					}
				},
			})
		})
});

function selectionAddedBox(id, name) {

}

function searchProduct(keyword)
{
	$.ajax({
		type: 'POST',
		url: `${HOST}/mfproduk/productSearch`,
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
	})
}

function checkURLWithParam(itemPath)
{
	const pathname = window.location.pathname;
	const path_arr = pathname.split('/');
	let last_arr = path_arr[path_arr.length - 1];

	if(last_arr === '') {
		last_arr = path_arr[path_arr.length - 2];
	}

	return (pathname.includes(itemPath) && parseInt(last_arr) > 0);
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

function loadSegmenOption(defaultSelected = 0, add_form = true) {
	const select = $(`select[name="segmen"] option`).length
	const existing_count = (add_form) ? 1 : 2;

	if(select <= existing_count) {
		const last_item = $(`select[name="segmen"] option`).last();
		$.ajax({
			type: 'GET',
			url: `${HOST}/segmen/apiGetAll`,
			beforeSend: function () {
				if(!add_form) {
					last_item.remove()
				}
				$('select[name="segmen"]').append('<option value="-1">Loading...</option>')
			},
			success: function (response) {
				if (response.success) {
					const options = response.data.map((item) => {
						if (defaultSelected > 0 && parseInt(item.OpsiVal) === defaultSelected) {
							return `<option value="${item.OpsiVal}" selected>${item.OpsiTeks}</option>`
						}
						return `<option value="${item.OpsiVal}">${item.OpsiTeks}</option>`
					})
					if (defaultSelected > 0) {
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
}

function loadSalesOption(defaultSelected = 0, add_form = true) {
	const select = $(`select[name="sales"] option`).length
	const existing_count = (add_form) ? 1 : 2;
	if(select <= existing_count) {
		const last_item = $(`select[name="sales"] option`).last();
		$.ajax({
			type: 'GET',
			url: `${HOST}/sales/apiGetAll`,
			beforeSend: function () {
				if(!add_form) {
					last_item.remove()
				}
				$('select[name="sales"]').append('<option value="-1">Loading...</option>')
			},
			success: function (response) {
				const options = response.map((item) => {
					if (defaultSelected > 0 && item[1] === defaultSelected) {
						return `<option value="${item[1]}" selected>${item[2]}</option>`
					}
					return `<option value="${item[1]}">${item[2]}</option>`
				})
				if (defaultSelected > 0) {
					$('select[name="sales"] option[value=""]').prop('selected', false)
				}
				$('select[name="sales"]').append(options.join(''));
			},
			complete: function () {
				$('select[name="sales"] option[value="-1"]').remove();
			}
		})
	}
}

function loadCustomerOption(defaultSelected = 0, add_form = true) {
	const select = $(`select[name="customer"] option`).length
	const existing_count = (add_form) ? 1 : 2;
	if(select <= existing_count) {
		const last_item = $(`select[name="customer"] option`).last();
		$.ajax({
			type: 'GET',
			url: `${HOST}/customer/apiGetAll`,
			beforeSend: function () {
				if(!add_form) {
					last_item.remove()
				}
				$('select[name="customer"]').append('<option value="-1">Loading...</option>')
			},
			success: function (response) {
				const options = response.map((item) => {
					if (defaultSelected > 0 && item[1] === defaultSelected) {
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
}

function loadTujuanKirimOption(defaultSelected = 0, add_form = true) {
	const select = $(`select[name="tujuan_kirim"] option`).length
	const existing_count = (add_form) ? 1 : 2;
	if(select <= existing_count) {
		const last_item = $(`select[name="tujuan_kirim"] option`).last();
		$.ajax({
			type: 'GET',
			url: `${HOST}/mftujuankirim/apiGetAll`,
			beforeSend: function () {
				if(!add_form) {
					last_item.remove()
				}
				$('select[name="tujuan_kirim"]').append('<option value="-1">Loading...</option>')
			},
			success: function (response) {
				const options = response.map((item) => {
					if (defaultSelected > 0 && item[1] === defaultSelected) {
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
		$(`#dataFormSisi input[name="${group}"]`).val(tracker.length);
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
	$(`#dataFormSisi input[name="${group}"]`).val(tracker.length);
}

function resetSisiModal()
{
	$('.sisi-form-modal').removeAttr('name');
	$('.sisi-form-modal input[type="number"]').val('0');
	$('.sisi-form-modal input[type="text"]').val('');
	$('.sisi-form-modal textarea').val('');
	$('.sisi-form-modal input[name="id"]').val('')
	$('.sisi-form-modal select[name="no_fgd"] option:not([value=""])').remove()
	$('.sisi-form-modal select[name="revisi"] option:not([value=""])').remove()
	$('.sisi-form-modal select[name="revisi"]').prop('disabled', true)
	$('.sisi-view').html('')
	$('.fs-child, .bs-child, .manual-child, .finishing-child, .khusus-child').html('');
}