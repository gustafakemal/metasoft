class CrudUI {
	constructor(btnAdd, modal, form) {
		this.btnAdd = btnAdd;
		this.modal = modal;
		this.form = form;
	}

	add() {
		const { btnAdd, modal } = this;
		$(`${btnAdd}`).on('click', function(e) {
			e.preventDefault();
			$(`${modal}`).modal({
				show: true,
				backdrop: 'static'
			})
			$(`${modal} form`).attr('name', 'addData')
			$(`${modal} .modal-title`).html('Tambah data')
		})
	}

	addProcess() {
		const url = `${HOST}/mfjenistinta/apiAddProcess`
		$(this.modal).on('submit', `form[name="${this.form}"]`, (e) => {
			e.preventDefault();
			const formData = new FormData($(`form[name="${this.form}"]`)[0]);
			formData.delete('id')

			const newObj = this.ajaxObj.bind(this, url, formData)

			$.ajax( newObj() )
		})
	}

	edit() {
		$('#dataList').on('click', '.item-edit', function(e) {
			e.preventDefault();
			$(this.modal).modal({
				show: true,
				backdrop: 'static'
			})
			$(`${this.modal} .modal-title`).html('Edit Data')
			$(`${this.modal} form`).attr('name', 'editData')

			const id = $(this).attr('data-id')
			$(`${this.modal} form input[name="id"]`).val(id)

			const newObj = this.ajaxObj.bind(this, url, formData)
			$.ajax();

			$.ajax({
				type: "POST",
				url: `${HOST}/mfjenistinta/apiGetById`,
				dataType: 'JSON',
				data: { id },
				beforeSend: function () {},
				success: function (response) {
					console.log(response)
					if(response.success) {
						for(const property in response.data) {
							$(`#dataForm input[name="${property}"], #dataForm textarea[name="${property}"]`).val(response.data[property])
						}
						$(`#dataForm select[name="aktif"] option`).removeAttr('selected')
						if(response.data['aktif'] == "Y") {
							$(`#dataForm select[name="aktif"] option[value="Y"]`).attr('selected', 'selected')
						} else {
							$(`#dataForm select[name="aktif"] option[value="T"]`).attr('selected', 'selected')
						}
					}
				},
				error: function () {},
				complete: function () {}
			})
		});
	}

	resetForm() {
		$(this.modal).on('hidden.bs.modal', function (event) {
			$(`${this.modal} form[name="${this.form}"], ${this.modal} form[name="editData"]`)[0].reset();
			$(`${this.modal} .msg`).html('')
		})
	}

	ajaxObj(url, formData, additionalObj = null) {
		const modal = this.modal;
		const form = this.form;
		let obj = {
			type: "POST",
			url: url,
			dataType: 'JSON',
			data: formData,
			beforeSend: () => {
				$(`${modal} .modal-footer .loading-indicator`).html(
						'<div class="spinner-icon">' +
						'<span class="spinner-border text-info"></span>' +
						'<span class="caption">Memproses data...</span>' +
				'</div>')
				$(`form[name="${form}"] input, form[name="${form}"] textarea, form[name="${form}"] button`).attr('disabled', true)
			},
			success: function (response) {
				console.log(response)
				if(response.success) {
					location.reload();
				} else {
					$(`${modal} .msg`).html(`<div class="alert alert-danger">${response.msg}</div>`)
					$(`${modal}, html, body`).animate({
						scrollTop: 0
					}, 500);
				}
			},
			error: function () {},
			complete: function () {
				$(`${modal} .modal-footer .loading-indicator`).html('');
				$(`form[name="${form}"] input, form[name="${form}"] textarea, form[name="${form}"] button`).attr('disabled', false)
			}
		};

		if( additionalObj != null && ! additionalObj.hasOwnProperty('contentType') ) {
			obj.contentType = false;
		}

		if( additionalObj != null && ! additionalObj.hasOwnProperty('processData') ) {
			obj.processData = false;
		}

		return obj;
	}
}