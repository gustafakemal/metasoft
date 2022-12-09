import {Datatable} from './libs/Datatable.js'

$(function () {

    let dt;

    const config = {
        columnDefs: {
            falseSearchable: [0, 10],
            falseOrderable: [0, 10],
            width: ['0(30)','1(100)','2(90)','3(120)','4(120)', '10(120)']
        },
        createdRow: ['No', 'Prospek', 'Alt', 'Nama Produk', 'Pemesan', 'Jumlah', 'Area', 'Diinput', 'Catatan', 'Status', 'Action'],
    }
    dt = new Datatable('#dataList', config, `${HOST}/listprospek`, 'POST', {})
    dt.init();

    $(`form[name="form-cariprospek"]`).on('submit', function (e) {
        e.preventDefault();
        const keyword = $(`input[name="cariprospek"]`).val();

        dt.timeout({keyword})
        dt.stickNumbers()
    })

    // $(`#dataList`).on('click', '.alt-item', function (e) {
    //     e.preventDefault();
    //     const confirmation = confirm('Menambahkan Alternatif?')
    //     if(confirmation) {
    //         const NoProspek = $(this).attr('data-no-prospect')
    //
    //         $.ajax({
    //             type: 'POST',
    //             url: `${HOST}/inputprospek/api`,
    //             dataType: 'JSON',
    //             data: {NoProspek},
    //             beforeSend: function () {
    //             },
    //             success: function (response) {
    //                 if (response.success) {
    //                     dt.reload()
    //                 }
    //             },
    //
    //         })
    //     }
    // })

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

})