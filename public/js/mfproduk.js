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

	if (new URL(location.href).searchParams.get('keyword') && location.pathname == '/mfproduk') {
		const keyword = new URL(location.href).searchParams.get('keyword');
		searchProduct(keyword);
	}

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
				$(`#dataPartHasilCari button.add-to-product[data-idpart="${id_part}"]`).html('Loading...').prop('disabled', true);
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
				$(`#dataPartHasilCari button.add-to-product[data-idpart="${id_part}"]`).html('Batalkan')
					.removeClass('btn-primary add-to-product')
					.addClass('btn-danger del-from-product')
					.prop('disabled', false);
			}
		})
	})
		.on('click', '.del-from-product', function(e) {
			e.preventDefault();
			const id_part = $(this).attr('data-idpart');
			const id_produk = $(this).attr('data-idproduk');

			$.ajax({
				type: 'POST',
				url: `${HOST}/MFPartProduk/apiDelFromProduct`,
				dataType: 'JSON',
				data: {id_produk, id_part},
				beforeSend: function() {
					$(`#dataPartHasilCari button.del-from-product[data-idpart="${id_part}"]`).html('Loading...').prop('disabled', true);
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
					$(`#dataPartHasilCari button.del-from-product[data-idpart="${id_part}"]`).removeClass('btn-danger del-from-product')
						.addClass('btn-primary add-to-product')
																					.html('Tambahkan')
																					.prop('disabled', false);
				}
			})
		})

	$('#dataList').DataTable().on( 'order.dt search.dt', function () {
		let i = 1;
		$('#dataList').DataTable().cells(null, 0, {search:'applied', order:'applied'}).every( function (cell) {
			this.data(i++);
		});
	}).draw();

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
		$('.csc-form .msg').html('')
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
					window.location.href = response.redirect_url;
					// location.reload();
					// $('.tbl-data-product').addClass('show');
					// $('.csc-form').removeClass('show');
					// $('.floating-msg').addClass('show').html(`
					// 	<div class="alert alert-success">${response.msg}</div>
					// 	`)
				} else {
					$('.csc-form .msg').html(`<div class="alert alert-danger">${response.msg}</div>`);
				}
			},
			error: function () {},
			complete: function() {
				$('.add-new-fgd input, .add-new-fgd select, .add-new-fgd button').attr('disabled', false)
			}
		})
	})

	$('.dynamic-content').on('submit', '.edit-produk-form', function(e) {
		e.preventDefault();
		const formData = new FormData(this);
		$('.csc-form .msg').html('');

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
					$('.csc-form .msg').html(`<div class="alert alert-danger">${response.msg}</div>`);
				}
			},
			complete: function () {
				$('.edit-produk-form input, .edit-produk-form select, .edit-produk-form button').attr('disabled', false)
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

		$('.csc-form .msg').html('');

		if(cariproduk.val() !== '') {
			cariproduk.val('')
			$('#dataList').DataTable().clear().draw();
			$('.tbl-data-product').removeClass('show')
		}
		const btn = $('form[name="form-cariproduk"] button[type="submit"]');
		cariproduk.prop('disabled', (!btn.prop('disabled')))
		btn.prop('disabled', (!btn.prop('disabled')))
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

	$('#cariPart').on('hidden.bs.modal', function (event) {
		$('#cariPart input[name="caripartproduk"]').val('');
		$('#dataPartHasilCari').DataTable().clear().draw();
	});

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
				$('.floating-msg').addClass('show').html(`
							<div class="alert alert-danger">Data tidak ditemukan.</div>
							`)
			}
		},
		complete: function (res) {
			if(!res.success) {
				setTimeout(() => {
					$('.floating-msg').removeClass('show').html('');
				}, 3000)
			}
		}
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
