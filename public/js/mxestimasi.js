import {Datatable} from './libs/Datatable.js'

$(function () {

    let dt;
    const config = {
        columnDefs: {
            falseSearchable: [0],
            falseOrderable: [0],
            width: ['0(30)'],
            
        },
        createdRow: ['No', 'Prospek', 'Alt', 'Nama Produk', 'Pemesan', 'Jumlah', 'Diinput', 'Catatan', 'Action'],
    }
    dt = new Datatable('#dataList', config, `${HOST}/queueestimasi/api`, 'GET')
    dt.load()

    $('.add-acc').on('click', function () {
        let last_id;
        let data_key
        if( $('.zero-record').length > 0) {
            last_id = 0;
            $('.zero-record').remove()
            data_key = parseInt(last_id);
        } else {
            last_id = $('.tbl-tinta tbody tr:last-child').attr('data-key')
            data_key = parseInt(last_id) + 1;
        }
        // const last_id = $('.tbl-tinta tbody tr:last-child').attr('data-key')
        const tr_elem = `<tr class="odd" data-key="${data_key}">
                            <td>
                                <button class="btn btn-sm btn-danger del-tinta" data-id="${data_key}" type="button">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                            <td>
                                <select id="warnatinta" name="warnatinta[]" class="form-control">
                                    <option value="">Pilih</option>
                                </select>
                            </td>
                            <td>
                                <input value="" id="coverage" name="coverage[]" type="number" class="form-control">
                            </td>
                        </tr>`
        $('.tbl-tinta tbody').append(tr_elem)

        if( $(`.tbl-tinta tbody tr:not(:has(.zero-record))`).length == 1) {
            getTinta(data_key);
        } else {
            const options = $(`.tbl-tinta tr:first-child select`).html();
            $(`.tbl-tinta tr[data-key="${data_key}"] select`).append(options);
        }
    })

    $('.tbl-tinta').on('click', '.del-tinta', function (e) {
        e.preventDefault();
        const id = $(this).attr('data-id');

        $(`.tbl-tinta tbody tr[data-key="${id}"]`).remove();
        if($(`.tbl-tinta tbody tr`).length == 0) {
            $(`.tbl-tinta tbody`).append('<tr class="odd zero-record">\n' +
                '                        <td colspan="3">\n' +
                '                            <div class="text-center font-italic text-muted">Belum ada tinta</div>\n' +
                '                        </td>\n' +
                '                    </tr>')
        }
    })

    // $('.open-kalkulasi').on('click', function (e) {
    //     $('#kalkulasiModal').modal({show: true});
    //     const jml_up = ($('input[name="JumlahUp"]').val() == '') ? '-' : $('input[name="JumlahUp"]').val()
    //     const lebar_film = ($('input[name="LebarFilm"]').val() == '') ? '-' : $('input[name="LebarFilm"]').val()
    //     $('#kalkulasiModal .jumlah_up').html(jml_up)
    //     $('#kalkulasiModal .lebar_film').html(lebar_film)
    // })

    $('form[name="kelengkapandata"]').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this)
        console.log($('select[name="warnatinta[]"]').val());
        // let formData = {
        //     JumlahUp: $('input[name="JumlahUp"]').val(),
        //     LebarFilm: $('input[name="LebarFilm"]').val(),
        //     ProspekTinta: $('select[name="warnatinta[]"]').val()
        // }
        // if($('.dynamic-satuan-field').length > 0) {
        //     const dynamic_name = $('.dynamic-satuan-field').attr('name');
        //     const newobj = {[dynamic_name]: $('.dynamic-satuan-field').val()}
        //     Object.assign(formData, newobj)
        // }
        // console.log(formData);
        $.ajax({
            type: 'POST',
            url: `${HOST}/queueestimasi/set`,
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.success) {
                    location.href = response.redirect_uri
                }
            },
            complete: function (res, stat, xhr) {
                console.log(res)
            }
        })
    });
})

function getTinta(data_key) {
    let data = []
    $.ajax({
        type: 'GET',
        url: `${HOST}/queueestimasi/api/tinta`,
        beforeSend: function() {
            $(`.tbl-tinta tr[data-key="${data_key}"] select, .tbl-tinta tr[data-key="${data_key}"] button, .tbl-tinta tr[data-key="${data_key}"] input`).prop('disabled', true)
        },
        success: function (response) {
            const data = response.map(item => {
                return `<option value="${item.id}">${item.nama} - ${item.merk}</option>`;
            })
            $(`.tbl-tinta tr[data-key="${data_key}"] select`).append(data.join(''))
        },
        complete: function () {
            $(`.tbl-tinta tr[data-key="${data_key}"] select, .tbl-tinta tr[data-key="${data_key}"] button, .tbl-tinta tr[data-key="${data_key}"] input`).prop('disabled', false)
        }
    })
}