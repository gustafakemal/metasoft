$(function () {

	bsCustomFileInput.init()

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
		order: [[ 1, 'desc' ]],
		scrollX: true,
		initComplete: function () {},
	});

	$('form[name="form-caripartproduk"]').on('submit', function(e) {
		e.preventDefault();
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

	$('select[name="technical_draw"]').on('change', function() {
		if( $('option:selected', this).val() === 'Y' ) {
			$('input[name="no_dokumen"]').attr('disabled', false)
			$('.no-dok-mark').removeClass('d-none');
		} else {
			$('input[name="no_dokumen"]').attr('disabled', true)
			$('.no-dok-mark').addClass('d-none');
		}
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
		.on('click', 'select[name="kertas"]', function (e) {
			loadSelectOptions({select_element_name: 'kertas', url: `${HOST}/MFJenisKertas/getSelectOptions`})
		})
		.on('click', 'select[name="flute"]', function (e) {
			loadSelectOptions({select_element_name: 'flute', url: `${HOST}/MFJenisFlute/getSelectOptions`})
		})
		.on('click', 'select[name="inner_pack"]', function (e) {
			loadSelectOptions({select_element_name: 'inner_pack', url: `${HOST}/MFPacking/getSelectOptions/Inner`})
		})
		.on('click', 'select[name="outer_pack"]', function (e) {
			loadSelectOptions({select_element_name: 'outer_pack', url: `${HOST}/MFPacking/getSelectOptions/Outer`})
		})
		.on('click', 'select[name="deliver_pack"]', function (e) {
			loadSelectOptions({select_element_name: 'deliver_pack', url: `${HOST}/MFPacking/getSelectOptions/Delivery`})
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
	})

	$('form[name="partproduct-form_edit"], form[name="partproduct-form_rev"]')
		.on('click', 'select[name="kertas"]', function (e) {
			const val = $('form[name="partproduct-form_edit"] select[name="kertas"] option').filter(':selected').val();
			loadSelectOptions({select_element_name: 'kertas', url: `${HOST}/MFJenisKertas/getSelectOptions`, defaultSelected: parseInt(val), add_form: false})
		})
		.on('click', 'select[name="flute"]', function (e) {
			const val = $('form[name="partproduct-form_edit"] select[name="flute"] option').filter(':selected').val();
			loadSelectOptions({select_element_name: 'flute', url: `${HOST}/MFJenisFlute/getSelectOptions`, defaultSelected: parseInt(val), add_form: false})
		})
		.on('click', 'select[name="inner_pack"]', function (e) {
			const val = $('form[name="partproduct-form_edit"] select[name="inner_pack"] option').filter(':selected').val();
			loadSelectOptions({select_element_name: 'inner_pack', url: `${HOST}/MFPacking/getSelectOptions/Inner`, defaultSelected: parseInt(val), add_form: false})
		})
		.on('click', 'select[name="outer_pack"]', function (e) {
			const val = $('form[name="partproduct-form_edit"] select[name="outer_pack"] option').filter(':selected').val();
			loadSelectOptions({select_element_name: 'outer_pack', url: `${HOST}/MFPacking/getSelectOptions/Outer`, defaultSelected: parseInt(val), add_form: false})
		})
		.on('click', 'select[name="deliver_pack"]', function (e) {
			const val = $('form[name="partproduct-form_edit"] select[name="deliver_pack"] option').filter(':selected').val();
			loadSelectOptions({select_element_name: 'deliver_pack', url: `${HOST}/MFPacking/getSelectOptions/Delivery`, defaultSelected: parseInt(val), add_form: false})
		})

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

	// $('.open-sisi-form').on('click', function (e) {
	// 	e.preventDefault();
	// 	$('#dataForm').modal({
	// 		show: true,
	// 		backdrop: 'static'
	// 	});
	// 	const id_part = $(this).attr('data-part');
	// 	$.get(`${HOST}/MFPartProduk/actualNomorSisi/${id_part}`, function (response) {
	// 		$('#dataForm input[name="sisi"]').val(response.no_sisi)
	// 	})
	//
	// 	const part_name = $(this).attr('data-nama');
	// 	$('.part-produk-title').html(part_name)
	// 	$('#dataForm .sisi-form-modal').attr('name', 'add-sisi')
	// })

	$('.add-copy-sisi').on('click', function (e) {
		e.preventDefault();
		const id_part = $(this).attr('data-part');
		const sisi_num = parseInt($(`#dataList tbody tr:last-child td:first-child`).text()) + 1;

		if(confirm(`Menambah sisi ${sisi_num} ?`)) {
			$.ajax({
				type: 'POST',
				url: `${HOST}/partproduk/addcopysisi`,
				dataType: 'JSON',
				data: {id_part},
				beforeSend: function () {},
				success: function (response) {
					if(response.success) {
						$('.floating-msg').html(`<div class="alert alert-success">${response.msg}</div>`).addClass('show');
						loadDataSisi(id_part)
						startBlinking(`#dataList tbody tr:last-child`)
					} else {
						$('.floating-msg').html(`<div class="alert alert-danger">${response.msg}</div>`).addClass('show');
					}
				},
				complete: function () {
					$([document.documentElement, document.body]).animate({
						scrollTop: $("#dataList").offset().top
					}, 500);
					setTimeout(() => {
						$('.floating-msg').html('').removeClass('show');
						stopBlinking()
					}, 5000);
				}
			})
		}
	})

	let color_tracker = {
		frontside: [],
		backside: [],
		manual: [],
		finishing: [],
		khusus: []
	};
	let fs_params = {
		selectbox: 'fscolors',
		item_container: 'fs-child',
		item_class: 'fscolor',
		input_name: 'fscolor[]',
		del_class: 'delfs',
		group: 'frontside',
		tracker: []
	};
	let bs_params = {
		selectbox: 'bscolors',
		item_container: 'bs-child',
		item_class: 'bscolor',
		input_name: 'bscolor[]',
		del_class: 'delbs',
		group: 'backside',
		tracker: []
	};
	let manual_params = {
		selectbox: 'manualcolors',
		item_container: 'manual-child',
		item_class: 'manualcolor',
		input_name: 'manualcolor[]',
		del_class: 'delmanual',
		group: 'manual',
		tracker: []
	};
	let finishing_params = {
		selectbox: 'finishingcolors',
		item_container: 'finishing-child',
		item_class: 'finishingcolor',
		input_name: 'finishingcolor[]',
		del_class: 'delfinishing',
		group: 'finishing',
		tracker: []
	};
	let khusus_params = {
		selectbox: 'khususcolors',
		item_container: 'khusus-child',
		item_class: 'khususcolor',
		input_name: 'khususcolor[]',
		del_class: 'delkhusus',
		group: 'khusus',
		tracker: []
	};

	$('#dataForm, #dataDetail').on('hidden.bs.modal', function (event) {
		resetSisiModal();
		// color_tracker = {
		// 	frontside: [],
		// 	backside: [],
		// 	manual: [],
		// 	finishing: [],
		// 	khusus: []
		// }
		fs_params.tracker = [];
		bs_params.tracker = [];
		manual_params.tracker = [];
		finishing_params.tracker = [];
		khusus_params.tracker = [];
	});

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
	}).on('submit', 'form[name="edit-sisi"]', function (e) {
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
	})
		.on('click', 'select[name="fscolors"]', function (e) {
			loadSelectOptions({select_element_name: 'fscolors', url: `${HOST}/MFJenisTinta/getSelectOptions`})
		})
		.on('click', 'select[name="bscolors"]', function (e) {
			loadSelectOptions({select_element_name: 'bscolors', url: `${HOST}/MFJenisTinta/getSelectOptions`})
		})
		.on('click', 'select[name="manualcolors"]', function (e) {
			loadSelectOptions({select_element_name: 'manualcolors', url: `${HOST}/MFProsesManual/getSelectOptions`})
		})
		.on('click', 'select[name="finishingcolors"]', function (e) {
			loadSelectOptions({select_element_name: 'finishingcolors', url: `${HOST}/MFProsesFinishing/getSelectOptions`})
		})
		.on('click', 'select[name="khususcolors"]', function (e) {
			loadSelectOptions({select_element_name: 'khususcolors', url: `${HOST}/MFProsesKhusus/getSelectOptions`})
		})

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
				console.log(response)
				const colors_el = ['fs_colors', 'bs_colors', 'manual_colors', 'finishing_colors', 'khusus_colors'];

				for(const prop in response.data) {
					if(colors_el.includes(prop)) {
						const spliter = prop.split('_')
						const prefix = spliter[0];
						let edited_array = `${prefix}_params`;
						// if(prefix === 'fs') {
						// 	edited_array = 'frontside';
						// } else if(prefix === 'bs') {
						// 	edited_array = 'backside';
						// } else {
						// 	edited_array = prefix;
						// }
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
							eval(edited_array).tracker.push(value.toString());
						}
						$(`.${prefix}-child`).html(child_el.join(''));
					}

					$(`.sisi-form-modal input[name="${prop}"]`).val(response.data[prop]);
					$(`.sisi-form-modal textarea[name="${prop}"]`).val(response.data[prop]);
				}
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

let blinkInterval = null;
function startBlinking(element)
{
	if (!blinkInterval) {
		blinkInterval = setInterval(function () {
			blink(element)
		}, 1000);
	}
	return blinkInterval;
}

function stopBlinking()
{
	if (blinkInterval) clearInterval(blinkInterval);
	blinkInterval = null;
}

function blink(element)
{
	$(element).css('background-color', '#fce8de');
	setTimeout(function () {
		$(element).css('background-color', 'rgba(0,0,0,.05)');
	}, 500);
}