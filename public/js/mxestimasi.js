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
})

