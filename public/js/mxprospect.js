import {Datatable} from './libs/Datatable.js'

$(function () {

    let dt;
    const config = {
        columnDefs: {
            falseSearchable: [0, 10, 11, 12],
            falseOrderable: [0, 10, 11, 12],
            falseVisibility: [13],
            width: ['0(30)', '1(100)', '2(90)', '3(120)', '4(120)', '10(120)'],
            custom: [
                {
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if (rowData[13] === 1) {
                            $(td).css('font-weight', 700).css('font-style', 'italic')
                        }
                    },
                }
            ]
        },
        createdRow: ['No', 'Prospek', 'Alt', 'Nama Produk', 'Pemesan', 'Jumlah', 'Area', 'Diinput', 'Catatan', 'Status', 'Proses', 'Prioritas', 'Action'],
        ajaxComplete: function () {
            setTimeout(() => {
                $('.chbx').bootstrapToggle({
                    on: 'Ya',
                    off: 'Tidak'
                })
            }, 100)
        }
    }

    dt = new Datatable('#dataList', config, `${HOST}/listprospek/api`, 'GET')
    dt.load();

    $('#dataList').on('page.dt', function () {
        setTimeout(() => {
            $('.chbx').bootstrapToggle({
                on: 'Ya',
                off: 'Tidak'
            })
        }, 100)
    })

    $('#dataList').on('change', 'input.chbx', function (e) {
        const confirmation = confirm('Yakin mengubah ?')
        if (confirmation) {
            const priority = ($(this).is(':checked')) ? 1 : 0;
            const NoProspek = $(this).attr('data-no-prospek')
            $.ajax({
                type: 'POST',
                url: `${HOST}/listprospek/set/priority`,
                dataType: 'JSON',
                data: {NoProspek, priority},
                beforeSend: function () {
                },
                success: function (response) {
                    if (response.success) {
                        dt.reload();
                    }
                },
                complete: function (response) {
                    if (response.responseJSON.success) {
                        setTimeout(() => {
                            $('.chbx').bootstrapToggle({
                                on: 'Ya',
                                off: 'Tidak'
                            })
                        }, 1000)
                    }
                }
            })
        } else {
            $(this).bootstrapToggle('off', true)
            // $(this).prop('checked', !$(this).is(':checked'))
        }
    })

    $('button.add-acc').on('click', function () {
        const val = parseInt($('select[name="aksesoris"] option:selected').val())

        let accessor = []
        if( $('.bs-child').length > 0 ) {
            $('.bs-child').each(function (idx) {
                const ord = $(this).find('input[name="aksesori[]"]')
                for(let x = 0;x < ord.length;x++) {
                    const df = parseInt(ord[x].defaultValue);
                    if(!accessor.includes(df)) {
                        accessor.push(df)
                    }
                }
            })
        }

        if (val !== '0' && !accessor.includes(val)) {
            const label = $('select[name="aksesoris"] option:selected').text()

            const elem = `<div class="row mb-1 bscolor" id="bscolor-${val}">
                        <div class="col-sm col-form-label">${label}</div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn-sm btn-danger delbs" id="delbs-${val}">
                                <i class="fas fa-trash-alt text-light"></i>
                            </button>
                        </div>
                        <input type="hidden" name="aksesori[]" value="${val}" />
                        </div>`

            $('.bs-child').append(elem)
            accessor.push(val)
        }
        $(`select[name="aksesoris"] option[value="0"]`).prop('selected', true);
    })

    const objAddJumlah = {
        childClass: 'jml-item-val',
        childID: 'item',
        captionClass: 'val',
        delClass: 'del-jml',
        delID: 'jml',
        hiddenInputName: 'jml[]'
    };
    const objAddMoq = {
        childClass: 'moq-item-val',
        childID: 'm-item',
        captionClass: 'm-val',
        delClass: 'del-moq',
        delID: 'moq',
        hiddenInputName: 'moq[]'
    };
    $(`.add-jml`).on(
        'click',
        addJumlahItem('Jumlah', 'prospek_jumlah-order', objAddJumlah)
    );
    $(`.add-moq`).on(
        'click',
        addJumlahItem('Moq', 'prospek_moq', objAddMoq)
    );

    $('.prospek_jumlah-order').on(
        'click',
        '.del-jml',
        delItemJumlah('prospek_jumlah-order', 'item')
    );
    $('.prospek_moq').on(
        'click',
        '.del-moq',
        delItemJumlah('prospek_moq', 'm-item')
    );

    $('select[name="BagMaking"]').on('change', function () {
        const val = $(this).val();
        if (val === '1') {
            $('select[name="Bottom"]').prop('disabled', false);
        } else {
            $('select[name="Bottom"]').prop('disabled', true);
        }
    })

    $('.bs-child').on('click', '.delbs', function (e) {
        const id = $(this).attr('id').split('-')[1];
        $(`.bs-child #bscolor-${id}`).remove()
    })

    $('#dataList').on('click', '.del-prospek', function (e) {
        e.preventDefault();

        const confirmation = confirm('Hapus prospek?')
        if (confirmation) {
            const NoProspek = $(this).attr('data-no-prospek');
            const Alt = $(this).attr('data-alt');
            const Status = $(this).attr('data-status');

            $.ajax({
                type: 'POST',
                url: `${HOST}/listprospek/delete`,
                dataType: 'JSON',
                data: {NoProspek, Alt, Status},
                beforeSend: function () {
                },
                success: function (response) {
                    let msgClass;
                    if (response.success) {
                        dt.reload()
                        msgClass = 'success'
                    } else {
                        msgClass = 'danger'
                    }
                    $('.floating-msg').addClass('show').html(`<div class="alert alert-${msgClass}">${response.msg}</div>`)
                },
                complete: function () {
                    setTimeout(() => {
                        $('.floating-msg').removeClass('show').html('');
                    }, 3000);
                }
            })
        }
    })

    $('#dataList').on('click', '.alt-item', function (e) {
        e.preventDefault();
        const NoProspek = $(this).attr('data-no-prospek')
        const Alt = $(this).attr('data-alt')

        $('#altChoice .no-prospek').html(NoProspek)
        $('#altChoice .alt').html(Alt)
        $('#altChoice a.copy-prospek').attr('href', `${HOST}/listprospek/add/${NoProspek}/${Alt}?copyprospek=1`)
        $('#altChoice a.copy-alt').attr('href', `${HOST}/listprospek/add/${NoProspek}/${Alt}`)

        $('#altChoice').modal({
            show: true,
            backdrop: 'static'
        })
    })

    $('#pemesan').select2({
        theme: "bootstrap",
        allowClear: true,
        placeholder: 'Pemesan',
        width: null,
        containerCssClass: ':all:'
    })

    $('select[name="Roll_Pcs"]').on('change', function (e) {
        const val = $(this).val();
        $('select[name="Finishing"]').prop('disabled', true);
        if(val === 'R') {
            $('.sat-dym-label').html('Meter Roll')
            $('.sat-dym-input').html(`<input type="number" step="any" class="form-control" id="meterroll" name="MeterRoll" placeholder="Meter Roll">`)
            $('select[name="Finishing"] option[value=""]').prop('selected', true)
        } else {
            $('.sat-dym-label').html('')
            $('.sat-dym-input').html('')
            if (val === 'P') {
                $('select[name="Finishing"]').prop('disabled', false);
            }
        }
    })
    $('select[name="Finishing"]').on('change', function (e) {
        const val = $(this).val();
        const vars = {
            'CS': {
                'label': 'Centre Seal',
                'field_name': 'CentreSeal'
            },
            'STP': {
                'label': 'Bottom',
                'field_name': 'UkuranBottom'
            },
            'CS Gusset': {
                'label': 'Gusset',
                'field_name': 'Gusset'
            }
        }
        if(vars.hasOwnProperty(val)) {
            $('.sat-dym-label').html(vars[val].label)
            $('.sat-dym-input').html(`<input type="number" step="any" class="form-control" id="${vars[val].field_name.lower}" name="${vars[val].field_name}" placeholder="${vars[val].label}">`)
        } else {
            $('.sat-dym-label').html('')
            $('.sat-dym-input').html(``)
        }
    })

    $('.custom-file-input').on('change', function (e) {
        if( $('input[name="attachment"]').get(0).files[0] != undefined ) {
            const filename = $('input[name="attachment"]').get(0).files[0].name;
            const nextSibling = e.target.nextElementSibling
            nextSibling.innerText = filename
        }
    })

    $('form[name="input_proses"]').on('submit', function (e) {
        e.preventDefault();
        $(`input, select`).removeClass('border-danger')
        const attachment = $('input[name="attachment"]').get(0).files[0];
        const formData = new FormData(this);
        formData.append("attachment", attachment)

        $.ajax({
            type: 'POST',
            url: `${HOST}/inputprospek`,
            dataType: 'JSON',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $('form[name="input_proses"] button:not(.show-produk)').prop('disabled', true)
                $('form[name="input_proses"] input').prop('readonly', true)
                $('form[name="input_proses"] select').attr('readonly', true)
                $('form[name="input_proses"] .custom-file-label').addClass('readonly')
            },
            success: function (response) {
                if(response.success) {
                    // $('.form_msg').html(`<div class="alert alert-success">${response.msg}</div>`);
                    window.location.href = response.redirect_url
                } else {
                    for(const property in response.dataError) {
                        $(`input[name="${property}"], select[name="${property}"]`).addClass('border-danger')
                        if(property === 'jml') {
                            $(`input[name="Jumlah"]`).addClass('border-danger');
                        }
                        if(property === 'Pemesan') {
                            $(`.select2-container--bootstrap .select2-selection`).addClass('border-danger');
                        }
                        if(property === 'attachment') {
                            $(`.custom-file-label`).addClass('border-danger');
                        }
                    }
                    $('.form_msg').html(`<div class="alert alert-danger">${response.msg}</div>`);
                    $('.form_msg, html, body').animate({
                        scrollTop: 0
                    }, 500);
                }
            },
            complete: function () {
                $('form[name="input_proses"] button:not(.show-produk)').prop('disabled', false)
                // $('form[name="input_proses"] input, form[name="input_proses"] select').prop('readonly', false)
                $('form[name="input_proses"] input').prop('readonly', false)
                $('form[name="input_proses"] select').attr('readonly', false)
                $('form[name="input_proses"] .custom-file-label').removeClass('readonly')
            }
        })
    })

    $('.show-produk').on('click', function (e) {
        const jenisproduk = $('select[name="JenisProduk"] option:selected').val();
        $('#dbProduk').modal({
            show: true,
            backdrop: 'static'
        })

        let dtProduk;
        const dtConfigProduk = {
            columnDefs: {
                falseSearchable: [0],
                falseOrderable: [0],
                width: ['0(30)'],
            },
            createdRow: ['No', 'Prospek', 'Alt', 'Nama Produk', 'Material1 1', 'Material1 2', 'Material1 3', 'Material1 4', 'Tinta', 'Tinta Khusus', 'Adhesive', 'Action'],
            scrollX: true
        }

        dtProduk = new Datatable('#dataDbProduk', dtConfigProduk, `${HOST}/mxbankdata/api`, 'POST', {jenisproduk})
        //dtProduk.load();

        if( ! $.fn.DataTable.isDataTable( '#dataDbProduk' ) ) {
            dtProduk.load()
        } else {
            dtProduk.reload()
        }
    })

    $('#dbProduk').on('click', '.load-produk-btn', function (e) {
        const id = $(this).attr('data-id')

        $('#dbProduk').modal('hide')

        $.ajax({
            type: 'GET',
            url: `${HOST}/mxbankdata/api/${id}`,
            beforeSend: function () {
                $('form[name="input_proses"] button').prop('disabled', true)
                $('form[name="input_proses"] input').prop('readonly', true)
                $('form[name="input_proses"] select').attr('readonly', true)
                $('form[name="input_proses"] .custom-file-label').addClass('readonly')
            },
            success: function (response) {
                if(response.success) {
                    console.log($(`select[name="Pemesan"] option[value="5"]`).text())
                    for(const property in response.data) {
                        // console.log(property)
                        $(`input[name="${property}"]`).val(response.data[property])
                        $(`select[name="${property}"] option[value="${response.data[property]}"]`).prop('selected', true)
                        if(property === 'Pemesan') {
                            $(`select[name="${property}"] option[value="${response.data[property]}"]`).attr('selected', 'selected').trigger('change')
                        }
                    }
                }
            },
            complete: function () {
                $('form[name="input_proses"] button').prop('disabled', false)
                $('form[name="input_proses"] input').prop('readonly', false)
                $('form[name="input_proses"] select').attr('readonly', false)
                $('form[name="input_proses"] .custom-file-label').removeClass('readonly')
            }
        })
    })

    $('select[name="JenisProduk"]').on('change', function (e) {
        const val = $(this).val()

        if( val === '' ) {
            $('.show-produk').prop('disabled', true)
        } else {
            $('.show-produk').prop('disabled', false)
        }
    })

    $('#dbProduk').on('hidden.bs.modal', function (event) {
        $('#dataDbProduk').DataTable().clear().draw().fnDestroy();
    })

})

let blinkInterval = null;
function startBlinking(element)
{
    if (!blinkInterval) {
        blinkInterval = setInterval(function () {
            blink(element)
        }, 100);
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
    $(element).css('background-color', '#f7e8b5');
    setTimeout(function () {
        $(element).css('background-color', '#f9f9f9');
    }, 500);
}

function addJumlahItem(inputName, parentClass, obj) {
    return function (e) {
        e.preventDefault();

        let jml_order = [];
        if( $(`.${obj.childClass}`).length > 0 ) {
            $(`.${obj.childClass}`).each(function (idx) {
                const ord = parseInt($(this).find(`.${obj.captionClass}`).text());
                jml_order.push(ord)
            })
        }
        const val = $(`input[name="${inputName}"]`).val();

        if(val === '' || val === '0' || jml_order.includes(parseInt(val))) {
            $(`input[name="${inputName}"]`).val('');
            return false;
        }

        const elem_val = `<div class="${obj.childClass}" id="${obj.childID}-${val}">
                            <input type="hidden" name="${obj.hiddenInputName}" value="${val}" />
                            <span class="${obj.captionClass}">${val}</span>
                            <button type="button" class="btn btn-danger btn-sm ${obj.delClass}" id="${obj.delID}-${val}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                           </div>`;

        jml_order.push(parseInt(val))
        $(`.${parentClass}`).append(elem_val);

        startBlinking(`.${parentClass} #${obj.childID}-${val} .${obj.captionClass}`)
        setTimeout(() => {
            stopBlinking()
        }, 500)
        $(`input[name="${inputName}"]`).val('');
    }
}

function delItemJumlah(parentElement, idItem) {
    return function(e) {
        e.preventDefault();
        const id = $(this).attr('id').split('-')[1]
        $(`.${parentElement} #${idItem}-${id}`).remove();
    }
}