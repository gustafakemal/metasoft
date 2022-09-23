class Datatable {
	constructor(element, config, url) {
		this.element = element;
		this.config = config;
		this.url = url;
	}

	load() {
		this.init();
		this.timeout();
		this.stickNumbers();
	}

	init() {
		$(`${this.element}`).DataTable( this.configObj() )
	}

	timeout() {
		const { url, element } = this;
		setTimeout(() => {
			$.ajax({
				type: "POST",
				url,
				beforeSend: function () {
					$(`${element} .dataTables_empty`).html(`
											<div class="spinner-icon">
												<span class="spinner-grow text-info"></span>
												<span class="caption">Fetching data...</span>
												</div>
											`);
				},
				success: function (response) {
					$(`${element}`).DataTable().clear();
					$(`${element}`).DataTable().rows.add(response).draw();
				},
				error: function () {
					$(`${element} .dataTables_empty`).html('Data gagal di retrieve.')
				},
				complete: function() {}
			})
		}, 50);
	}

	stickNumbers() {
		const {element} = this;
		$(`${element}`).DataTable().on( 'order.dt search.dt', function () {
			let i = 1;
			$(`${element}`).DataTable().cells(null, 0, {
				search:'applied',
				order:'applied'
			}).every( function (cell) {
				this.data(i++);
			});
		}).draw();
	}

	configObj() {
		const {element} = this;
		let obj = {
			data: [],
			buttons: this.buttons(),
			columnDefs: this.columnDefs(),
			order: this.order(),
			createdRow: this.createdRow(),
			initComplete: function() {
				const dropdown = `<div class="dropdown d-inline mr-2">` +
								`<button class="btn btn-primary dropdown-toggle" type="button" id="dtDropdown" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></button>` +
								`<div class="dropdown-menu" aria-labelledby="dtDropdown">` +
								`<a class="dropdown-item data-reload" href="#">Reload data</a>` +
								`<a class="dropdown-item data-to-csv" href="#">Export to excel</a>` +
							`</div>` +
						`</div>`
				const add_btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-data_btn">Tambah data</a>`;
				$(`${element}_wrapper .dataTables_length`).prepend(dropdown + add_btn);
			}
		};

		if( this.config.hasOwnProperty('initComplete')) {
			obj.initComplete = this.config.initComplete
		}

		return obj;
	}

	createdRow() {
		const arr = this.config.createdRow
		const cr = this.cr;
		return function (row, data, dataIndex) {
			cr(row, arr);
		}
	}

	cr(row, array) {
		return array.map((item, key) => {
			return $(row).find(`td:eq(${key})`).attr("data-label", item)
		}).join('')
	}

	columnDefs() {
		let mainSettings = [{
				"searchable": false,
				"targets": [0]
			},
			{	
				"orderable": false,
				"targets": [0]
			}]
		if( this.config.hasOwnProperty('columnDefs') ) {
			if(this.config.columnDefs.hasOwnProperty('falseSearchable')) {
				mainSettings[0].targets = this.config.columnDefs.falseSearchable;
			}
			if(this.config.columnDefs.hasOwnProperty('falseOrderable')) {
				mainSettings[1].targets = this.config.columnDefs.falseOrderable;
			}
			if(this.config.columnDefs.hasOwnProperty('width')) {
				let widths = [];
				for(const property in this.config.columnDefs.width) {
					const target = property.split('-')
					const width = {
						"width": this.config.columnDefs.width[property],
						"targets": parseInt(target[1])
					};
					widths.push(width);
				}
				mainSettings = [...mainSettings, ...widths];
			}
			if(this.config.columnDefs.hasOwnProperty('falseVisibility')) {
				const visibility = {
					"visible": false,
					"targets": this.config.columnDefs.falseVisibility
				}
				mainSettings.push(visibility);
			}
			if(this.config.columnDefs.hasOwnProperty('custom')) {
				mainSettings = [...mainSettings, ...this.config.columnDefs.custom];
			}
		}

		return mainSettings;
	}

	buttons() {
		if( ! this.config.hasOwnProperty('buttons') ) {
			return [{
						extend: 'excelHtml5',
						exportOptions: {
							orthogonal: 'export'
						}
					}]
		}

		return this.config.buttons
	}

	order() {
		if( ! this.config.hasOwnProperty('order') ) {
			return [[1, 'desc']];
		}

		return this.config.order;
	}
}