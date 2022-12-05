export class Datatable {
	constructor(element, config, url, type, ajaxData = null, stickNumb = true, ajaxCustomSuccess = null) {
		this.element = element;
		this.config = config;
		this.url = url;
		this.type = type;
		this.ajaxData = ajaxData;
		this.stickNumb = stickNumb;
		this.ajaxCustomSuccess = ajaxCustomSuccess;
	}

	load() {
		this.init();
		this.timeout();
		if (this.stickNumb) {
			this.stickNumbers();
		}
	}

	reload() {
		this.timeout();
		if (this.stickNumb) {
			this.stickNumbers();
		}
	}

	init() {
		$(`${this.element}`).DataTable(this.configObj())
	}

	destroy() {
		$(`${this.element}`).DataTable().clear().draw().fnDestroy();
		setTimeout(function () {
			$(`${this.element}`).removeClass('dataTable')
		}, 1000)
	}

	timeout(param_obj = this.ajaxData) {
		const {url, element, type, ajaxCustomSuccess} = this;
		setTimeout(() => {
			const ajaxObj = {
				type,
				url,
				beforeSend: function () {
					$(`${element} .dataTables_empty`).html(`
											<div class="spinner-icon">
												<span class="spinner-grow text-info"></span>
												<span class="caption">Fetching data...</span>
												</div>
											`);
				},
				error: function () {
					$(`${element} .dataTables_empty`).html('Data gagal di retrieve.')
				},
				complete: function () {
				}
			};

			if (param_obj != null) {
				ajaxObj.dataType = "JSON";
				ajaxObj.data = param_obj;
			}

			if (ajaxCustomSuccess == null) {
				ajaxObj.success = function (response) {
					$(`${element}`).DataTable().clear().rows.add(response).draw()
				};
			} else {
				ajaxObj.success = ajaxCustomSuccess;
			}

			$.ajax(ajaxObj);

		}, 50);
	}

	stickNumbers() {
		const {element} = this;
		$(`${element}`).DataTable().on('order.dt search.dt', function () {
			let i = 1;
			$(`${element}`).DataTable().cells(null, 0, {
				search: 'applied',
				order: 'applied'
			}).every(function (cell) {
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
		};

		if (this.config.hasOwnProperty('initComplete')) {
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
			"targets": []
		},
			{
				"orderable": false,
				"targets": []
			}]
		if (this.config.hasOwnProperty('columnDefs')) {
			if (this.config.columnDefs.hasOwnProperty('falseSearchable')) {
				mainSettings[0].targets = this.config.columnDefs.falseSearchable;
			}
			if (this.config.columnDefs.hasOwnProperty('falseOrderable')) {
				mainSettings[1].targets = this.config.columnDefs.falseOrderable;
			}
			if (this.config.columnDefs.hasOwnProperty('className')) {
				mainSettings.push({
					className: 'dt-body-wrap',
					targets: this.config.columnDefs.className
				})
			}
			if (this.config.columnDefs.hasOwnProperty('width')) {
				let widths = [];
				for (const property in this.config.columnDefs.width) {
					// ambil string diluar parenthesis
					const width_props = /\(([^)]+)\)/.exec(this.config.columnDefs.width[property])
					// ambil kuota masing2 array def
					const targets_props = /([^\(]+)/.exec(this.config.columnDefs.width[property])
					const width = {
						"width": parseInt(width_props[1]),
						"targets": parseInt(targets_props[1])
					};
					widths.push(width);
				}
				mainSettings = [...mainSettings, ...widths];
			}
			if (this.config.columnDefs.hasOwnProperty('falseVisibility')) {
				const visibility = {
					"visible": false,
					"targets": this.config.columnDefs.falseVisibility
				}
				mainSettings.push(visibility);
			}
			if (this.config.columnDefs.hasOwnProperty('custom')) {
				mainSettings = [...mainSettings, ...this.config.columnDefs.custom];
			}
		}

		return mainSettings;
	}

	buttons() {
		if (!this.config.hasOwnProperty('buttons')) {
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
		if (!this.config.hasOwnProperty('order')) {
			return [[1, 'desc']];
		}

		return this.config.order;
	}
}