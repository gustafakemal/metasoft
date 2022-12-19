import {Datatable} from './libs/Datatable.js'

$(function () {

    let dt;
    const config = {
        columnDefs: {
            falseSearchable: [0, 10, 11, 12],
            falseOrderable: [0, 10, 11, 12],
            falseVisibility: [13],
            width: ['0(30)','1(100)','2(90)','3(120)','4(120)', '10(120)'],
            custom: [
                {
                    "targets": [0,1,2,3,4,5, 6, 7, 8, 9],
                    "createdCell": function (td, cellData, rowData, row, col) {
                        if ( rowData[13] === 1 ) {
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
        if(confirmation) {
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
                    if(response.success) {
                        dt.reload();
                    }
                },
                complete: function (response) {
                    if(response.responseJSON.success) {
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

    let aksesories = [];
    $('button.add-acc').on('click', function() {
        const val = $('select[name="aksesoris"] option:selected').val()

        if( val !== '0' && ! aksesories.includes(val) ) {
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
            aksesories.push(val)
        }
        $(`select[name="aksesoris"] option[value="0"]`).prop('selected', true);
    })

    $('select[name="BagMaking"]').on('change', function () {
        const val = $(this).val();
        if(val === '1') {
            $('select[name="Bottom"]').prop('disabled', false);
        } else {
            $('select[name="Bottom"]').prop('disabled', true);
        }
    })

    $('select[name="Roll_Pcs"]').on('change', function () {
        const val = $(this).val();
        if(val === 'P') {
            $('select[name="Finishing"]').prop('disabled', false);
        } else {
            $('select[name="Finishing"]').prop('disabled', true);
        }
    })

    $('.bs-child').on('click', '.delbs', function (e) {
        const split_el = $(this).attr('id').split('-')
        const idx = aksesories.indexOf(split_el[1]);
        if (idx !== -1) {
            aksesories.splice(idx, 1);
        }
        $(`.bs-child #bscolor-${split_el[1]}`).remove()
    })

    $('#dataList').on('click', '.del-prospek', function (e) {
        e.preventDefault();

        const confirmation = confirm('Hapus prospek?')
        if(confirmation) {
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

})