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
        $('#dataForm .modal-title').html('Tambah modul');
    })
        .on('click', '.item-edit', function (e) {
            e.preventDefault();
            const id = $(this).attr('data-id');

            $.get(`${HOST}/setting/modul/${id}`, function (data) {
                console.log(data)
            })
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

    const config2 = {
        columnDefs: {
            falseSearchable: [0],
            falseOrderable: [0],
            width: ['0(30)','1(130)','3(120)','4(100)']
        },
        createdRow: ['No', 'Nama Modul', 'Route', 'Icon', 'Action'],
    }
    const datatable2 = new Datatable('#dataAccessRight', config2, `${HOST}/setting/hakakses/api`, 'GET')
    datatable2.load()

    let datatable3;
    $('#dataAccessRight').on('click', '.user-access', function (e) {
        e.preventDefault();
        $('#modalUserAccess').modal({
            show: true,
            backdrop: true
        })
        const uid = $(this).attr('data-uid')

        $('span.uid').html(uid)
        $('span.nama_peg').html($(this).attr('data-nama'))

        const config3 = {
            columnDefs: {
                falseSearchable: [0, 2, 3, 4],
                falseOrderable: [0, 2, 3, 4],
                falseVisibility: [5],
                width: ['0(30)', '2(40)','3(40)','4(40)'],
                custom: [
                    {
                        render: function (data, type, row) {
                            const checkbox1 = $('<div/>').append(row[2]).find('.access_check').attr('name')
                            const checkbox2 = $('<div/>').append(row[3]).find('.access_check').attr('name')

                            setTimeout(function () {
                                if( row[5][2] === 3) {
                                    $(`#modulPriv input[name="${checkbox1}"]`).prop('indeterminate', true)
                                    $(`#modulPriv input[name="${checkbox2}"]`).prop('indeterminate', true)
                                }
                                if( row[5][2] === 2) {
                                    $(`#modulPriv input[name="${checkbox1}"]`).prop('indeterminate', true)
                                }
                            }, 10)

                            return data
                        },
                        targets: 1,
                    }
                ]
            },
            createdRow: ['No', 'Nama Modul', 'R', 'R/W', 'R/W/D'],
        }
        datatable3 = new Datatable('#modulPriv', config3, `${HOST}/setting/hakakses/api/${uid}`, 'GET')
        datatable3.load()
    })

    $("#modalUserAccess").on("hidden.bs.modal", function () {
        $("#modulPriv").DataTable().destroy();
        $('span.uid').html('')
        $('span.nama_peg').html('')
    });

    $('#modulPriv').on('click', '.access_check', function (e) {
        const arr_value = $(this).val().split('_')
        const uid = arr_value[0]
        const modul = parseInt(arr_value[1])
        const access = parseInt(arr_value[2])
        const checked = $(this).prop('checked') ? 1 : 0;

        const data = { uid, modul, access, checked }

        $.ajax({
            type: 'POST',
            url: `${HOST}/setting/hakakses/edit/api`,
            dataType: 'JSON',
            data: data,
            beforeSend: function () {
                $('#modulPriv input[type="checkbox"]').prop('disabled', true)
            },
            success: function (response) {
                if(response.success) {
                    datatable3.reload()
                }
            },
            complete: function (response) {
                $('#modulPriv input[type="checkbox"]').prop('disabled', false)
            }
        })
    })

});

function checkbox(prop, checked = false)
{
    const isChecked = checked ? ' checked' : '';
    const checkbox = `<input name="${prop}" value="${prop}" type="checkbox"${isChecked} class="custom-control-input access_check" id="accessCheck_${prop}"/>`;
    const label = `<label class="custom-control-label" for="accessCheck_${prop}"></label>`;
    return `<div class="custom-control custom-checkbox">${checkbox}${label}</div>`;
}