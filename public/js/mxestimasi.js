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
        const last_id = $('.tbl-tinta tbody tr:last-child').attr('data-key')
        const data_key = parseInt(last_id) + 1;
        const tr_elem = `<tr class="odd" data-key="${data_key}">
                            <td>
                                <button class="btn btn-sm btn-danger del-tinta" data-id="${data_key}" type="button">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>                    
                            <td>
                                <select id="warnatinta" name="warnatinta" class="form-control">
                                    <option value="">Pilih</option>
                                </select>
                            </td>
                            <td>
                                <input value="" id="coverage" name="coverage" type="number" class="form-control">
                            </td>
                        </tr>`
        $('.tbl-tinta tbody').append(tr_elem)
    })

    $('.tbl-tinta').on('click', '.del-tinta', function (e) {
        e.preventDefault();
        const id = $(this).attr('data-id');

        $(`.tbl-tinta tbody tr[data-key="${id}"]`).remove();
    })
})

