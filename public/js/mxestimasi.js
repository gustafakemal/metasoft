import {Datatable} from './libs/Datatable.js'

$(function () {

    let dt;
    const config = {
        columnDefs: {
            falseSearchable: [0, 5, 6, 8],
            falseOrderable: [0, 5, 8],
            width: ['0(30)', '1(100)', '2(90)', '3(120)', '4(120)', '8(30)'],
            
        },
        createdRow: ['No', 'Prospek', 'Alt', 'Nama Produk', 'Pemesan', 'Jumlah', 'Diinput', 'Catatan', 'Action'],
        
        //
        //

    }

})

