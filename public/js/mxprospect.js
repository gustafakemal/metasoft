import {Datatable} from './libs/Datatable.js'

$(function () {

    let dt;

    $(`form[name="form-cariprospek"]`).on('submit', function (e) {
        e.preventDefault();
        const keyword = $(`input[name="cariprospek"]`).val();

        const config = {
            columnDefs: {
                falseSearchable: [0],
                falseOrderable: [0],
                width: ['0(30)','1(120)','2(150)','3(90)','4(100)']
            },
            createdRow: ['No', 'Prospek', 'Alt', 'Nama Produk', 'Pemesan', 'Jumlah', 'Area', 'Diinput', 'Catatan', 'Status', 'Action'],
        }
        dt = new Datatable('#dataList', config, `${HOST}/listprospek`, 'POST', {keyword})
        dt.load()
    })

    $(`#dataList`).on('click', '.alt-item', function (e) {
        e.preventDefault();
        const NoProspek = $(this).attr('data-no-prospect')

        $.ajax({
            type: 'POST',
            url: `${HOST}/inputprospek/api`,
            dataType: 'JSON',
            data: {NoProspek},
            beforeSend: function() {},
            success: function (response) {
                if(response.success) {
                    dt.reload()
                }
            },

        })
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


})