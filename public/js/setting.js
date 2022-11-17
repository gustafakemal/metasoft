import {Datatable} from './libs/Datatable.js'

$(function () {

    const config = {
        columnDefs: {
            falseSearchable: [0],
            falseOrderable: [0],
            width: ['0(30)','4(120)','2(150)','3(90)','5(100)']
        },
        createdRow: ['No', 'Nama Modul', 'Route', 'Icon', 'Parent/Group', 'Action'],
        initComplete: function () {
            const add_btn = `<a href="#" class="btn btn-primary btn-add mr-2 add-data_btn">Tambah data</a>`;
            $("#dataList_wrapper .dataTables_length").prepend(add_btn);
        },
    }
    const datatable = new Datatable('#dataList', config, `${HOST}/setting/modul/api`, 'GET')
    datatable.load()

    $('#dataList_wrapper').on('click', '.add-data_btn', function (e) {
        e.preventDefault();
        $('#dataForm').modal({
            show: true,
            backdrop: true
        })
        $('#dataForm form').attr('name', 'addModul');
    })

    $('#dataForm').on('submit', 'form[name="addModul"]', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: `${HOST}/setting/modul/add/api`,
            dataType: 'JSON',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('form[name="addModul"] input, form[name="addModul"] textarea, form[name="addModul"] button').attr('disabled', true)
            },
            success: function (response) {
                if(response.success) {
                    location.reload();
                } else {
                    $('#dataForm .msg').html(`<div class="alert alert-danger">${response.msg}</div>`)
                    $('#dataForm, html, body').animate({
                        scrollTop: 0
                    }, 500);
                }
            },
            complete: function () {
                $('form[name="addModul"] input, form[name="addModul"] textarea, form[name="addModul"] button').attr('disabled', false)
            }
        })
    })

    $('#dataForm').on('hidden.bs.modal', function (event) {
        $('#dataForm form[name="addModul"], #dataForm form[name="editModul"]')[0].reset();
        $('#dataForm .msg').html('');
        $('#dataForm form').removeAttr('name');
    })

});