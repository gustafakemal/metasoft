$(function () {

	let customerData;
	let partProduk;

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
		createdRow: function (row, data, dataIndex) {
			$(row).find("td:eq(0)").attr("data-label", "No");
			$(row).find("td:eq(1)").attr("data-label", "Action");
			$(row).find("td:eq(2)").attr("data-label", "Nama Produk");
			$(row).find("td:eq(3)").attr("data-label", "Segmen");
			$(row).find("td:eq(4)").attr("data-label", "Pemesan");
			$(row).find("td:eq(5)").attr("data-label", "Sales");
			$(row).find("td:eq(6)").attr("data-label", "Dibuat");
			$(row).find("td:eq(7)").attr("data-label", "Dibuat oleh");
			$(row).find("td:eq(8)").attr("data-label", "Update");
			$(row).find("td:eq(9)").attr("data-label", "Diupdate oleh");
		},
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
		createdRow: function (row, data, dataIndex) {
			$(row).find("td:eq(0)").attr("data-label", "No");
			$(row).find("td:eq(1)").attr("data-label", "FGD");
			$(row).find("td:eq(2)").attr("data-label", "Revisi");
			$(row).find("td:eq(3)").attr("data-label", "Nama Part Produk");
			$(row).find("td:eq(4)").attr("data-label", "Kertas");
			$(row).find("td:eq(5)").attr("data-label", "Flute");
			$(row).find("td:eq(6)").attr("data-label", "Metalize");
			$(row).find("td:eq(7)").attr("data-label", "Ukuran");
			$(row).find("td:eq(8)").attr("data-label", "Dibuat");
			$(row).find("td:eq(9)").attr("data-label", "Dibuat oleh");
			$(row).find("td:eq(8)").attr("data-label", "Update");
			$(row).find("td:eq(9)").attr("data-label", "Diupdate oleh");
			$(row).find("td:eq(9)").attr("data-label", "Action");
		},
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
			loadData(`${HOST}/partproduk/api/${id_produk}`, '#dataPartProduk');
		}, 50);
	}

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
				url: `${HOST}/produk/delete`,
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
				error: function (response) {
					if(response.status == 403) {
						$('.floating-msg').addClass('show').html(`
								<div class="alert alert-danger">${response.responseJSON.msg}</div>
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
				url: `${HOST}/partproduk`,
				dataType: 'JSON',
				data: { keyword, full: false, id_produk },
				beforeSend: function () {},
				success: function (response) {
					if(response.success) {
						$('#dataPartHasilCari').DataTable().clear().rows.add(response.data).draw();
					} else {
						$('#dataPartHasilCari').DataTable().clear().draw();
						$('.floating-msg').addClass('show').html(`
							<div class="alert alert-danger">${response.msg}</div>
							`)
					}
				},
				error: function () {},
				complete: function(res) {
					if(!res.success) {
						setTimeout(() => {
							$('.floating-msg').removeClass('show').html('');
						}, 3000)
					}
				}
			})
		})
	})

	$('#cariPart').on('click', '.add-to-product', function(e) {
		e.preventDefault();
		const id_part = $(this).attr('data-idpart');
		const id_produk = $(this).attr('data-idproduk');

		$.ajax({
			type: 'POST',
			//url: `${HOST}/MFPartProduk/apiAddToProduct`,
			url: `${HOST}/partproduk/add/toproduk`,
			dataType: 'JSON',
			data: {id_produk, id_part},
			beforeSend: function() {
				$(`#dataPartHasilCari button.add-to-product[data-idpart="${id_part}"]`).html('Loading...').prop('disabled', true);
			},
			success: function (response) {
				if(response.success) {
					loadData(`${HOST}/partproduk/api/${id_produk}`, '#dataPartProduk');
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-success">${response.msg}</div>
						`)
				} else {
					$('.floating-msg').addClass('show').html(`
						<div class="alert alert-success">${response.msg}</div>
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
			complete: function () {
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
						loadData(`${HOST}/partproduk/api/${id_produk}`, '#dataPartProduk');
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

	$('.dynamic-content').on('submit', '.add-new-fgd', function(e) {
		e.preventDefault();
		$('.csc-form .msg').html('')
		const formData = new FormData(this)

		$.ajax({
			type: 'POST',
			url: `${HOST}/produk/add`,
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
				} else {
					$('.csc-form .msg').html(`<div class="alert alert-danger">${response.msg}</div>`);
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
				$('.add-new-fgd input, .add-new-fgd select, .add-new-fgd button').attr('disabled', false)
				setTimeout(() => {
					$('.floating-msg').removeClass('show').html('');
				}, 3000)
			}
		})
	})

	$('.dynamic-content').on('submit', '.edit-produk-form', function(e) {
		e.preventDefault();
		const formData = new FormData(this);
		$('.csc-form .msg').html('');

		$.ajax({
			type: 'POST',
			url: `${HOST}/produk/edit`,
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
			error: function (response) {
				if(response.status == 403) {
					$('.floating-msg').addClass('show').html(`
								<div class="alert alert-danger">${response.responseJSON.msg}</div>
								`)
				}
			},
			complete: function () {
				$('.edit-produk-form input, .edit-produk-form select, .edit-produk-form button').attr('disabled', false)
			},
		})
	});

	$('.edit-produk-form').on('click', 'select[name="segmen"]', function (e) {
		const val = $('.edit-produk-form select[name="segmen"] option').filter(':selected').val();
		loadSelectOptions({select_element_name: 'segmen', url: `${HOST}/segmen/getSelectOptions`, defaultSelected: val, add_form: false});
	})
		.on('click', 'select[name="sales"]', function (e) {
			const val = $('.edit-produk-form select[name="sales"] option').filter(':selected').val();
			loadSelectOptions({select_element_name: 'sales', url: `${HOST}/sales/getSelectOptions`, defaultSelected: parseInt(val), add_form: false});
		})
		.on('click', 'select[name="customer"]', function (e) {
			const val = $('.edit-produk-form select[name="customer"] option').filter(':selected').val();
			loadSelectOptions({select_element_name: 'customer', url: `${HOST}/customer/getSelectOptions`, defaultSelected: parseInt(val), add_form: false});
		})
		.on('click', 'select[name="tujuan_kirim"]', function (e) {
			const val = $('.edit-produk-form select[name="tujuan_kirim"] option').filter(':selected').val();
			loadSelectOptions({select_element_name: 'tujuan_kirim', url: `${HOST}/mftujuankirim/getSelectOptions`, defaultSelected: parseInt(val), add_form: false});
		})

	$('.add-new').on('click', function() {
		loadSelectOptions({select_element_name: 'segmen', url: `${HOST}/segmen/getSelectOptions`});
		loadSelectOptions({select_element_name: 'sales', url: `${HOST}/sales/getSelectOptions`});
		loadSelectOptions({select_element_name: 'customer', url: `${HOST}/customer/getSelectOptions`});
		loadSelectOptions({select_element_name: 'tujuan_kirim', url: `${HOST}/mftujuankirim/getSelectOptions`});

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

});

function selectionAddedBox(id, name) {

}

function searchProduct(keyword)
{
	$.ajax({
		type: 'POST',
		url: `${HOST}/produk`,
		dataType: 'JSON',
		data: { keyword },
		beforeSend: function () {},
		success: function (response) {
			if(response.success) {
				$('#dataList').DataTable().clear().rows.add(response.data).draw();
			} else {
				$('#dataList').DataTable().clear().draw();
				$('.floating-msg').addClass('show').html(`
							<div class="alert alert-danger">${response.msg}</div>
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

function loadSelectOptions(objParam) {

	const defaultSelected = (objParam.hasOwnProperty('defaultSelected')) ? objParam.defaultSelected : 0;
	const add_form = (objParam.hasOwnProperty('add_form')) ? objParam.add_form : true;

	const select = $(`select[name="${objParam.select_element_name}"] option`)
	const existing_count = (add_form) ? 1 : 2;
	if(select.length <= existing_count) {
		const last_item = select.last();
		$.ajax({
			type: 'GET',
			url: objParam.url,
			beforeSend: function () {
				if(!add_form) {
					last_item.remove()
				}
				$(`select[name="${objParam.select_element_name}"]`).append('<option value="-1">Loading...</option>')
			},
			success: function (response) {
				const options = response.data.map((item) => {
					if (defaultSelected > 0 && item.id === defaultSelected) {
						return `<option value="${item.id}" selected>${item.name}</option>`
					}
					return `<option value="${item.id}">${item.name}</option>`
				})
				if (defaultSelected > 0) {
					$(`select[name="${objParam.select_element_name}"] option[value=""]`).prop('selected', false)
				}
				$(`select[name="${objParam.select_element_name}"]`).append(options.join(''));
			},
			complete: function () {
				$(`select[name="${objParam.select_element_name}"] option[value="-1"]`).remove();
			}
		})
	}
}