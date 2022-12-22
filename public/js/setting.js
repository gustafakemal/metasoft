import {Datatable} from './libs/Datatable.js'

$(function () {

    const config = {
        columnDefs: {
            falseSearchable: [0,5],
            falseOrderable: [0,5],
            width: ['0(30)','4(150)','2(150)','3(120)','5(150)'],
            custom: [
                {
                    "targets": 3,
                    render: function ( data, type, row, meta ) {
                        if(data !== null || data !== '' || data !== 'null' || !empty(data)) {
                            const icon = `<i class="${data} fa-lg"></i>`
                            return `${icon}<br /><span class="small">${data}</span>`;
                        } else {
                            return data;
                        }
                    }
                }
            ]
        },
        createdRow: ['No', 'Nama Modul', 'Route', 'Icon', 'Parent/Group', 'Action'],
        initComplete: function () {
            const url = window.location.href;
            $.ajax({
                type: 'POST',
                url: `${HOST}/api/common/dt_navigation`,
                dataType: 'JSON',
                data: {url, buttons: ['add']},
                beforeSend: function (){},
                success: function (response) {
                    $("#dataList_wrapper .dataTables_length").prepend(response.data);
                }
            })
        },
    }
    const datatable = new Datatable('#dataList', config, `${HOST}/setting/modul/api`, 'GET')
    datatable.load()

    let dt_users;
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
            $('#dataForm').modal({
                show: true,
                backdrop: true
            })
            $('#dataForm form').attr('name', 'editModul');
            $('#dataForm .modal-title').html('Edit modul');

            $.ajax({
                type: 'GET',
                url: `${HOST}/setting/modul/api/${id}`,
                beforeSend: function () {
                    $(`form[name="editModul"] input, form[name="editModul"] button`).prop('disabled', true)
                },
                success: function (response) {
                    if(response.success) {
                        for(const property in response.data) {
                            $(`#dataForm input[name="${property}"]`).val(response.data[property])
                        }
                    }
                },
                complete: function () {
                    $(`form[name="editModul"] input, form[name="editModul"] button`).prop('disabled', false)
                }
            })
        })
        .on('click', '.item-detail', function(e) {
            e.preventDefault();
            $('#dataDetail').modal('show')
            const id = $(this).attr('data-id')
            $.ajax({
                type: "GET",
                url: `${HOST}/setting/modul/api/${id}`,
                beforeSend: function () {},
                success: function (response) {
                    if(response.success) {
                        for(const property in response.data) {
                            $(`#dataDetail .${property}`).html(response.data[property])
                        }
                    }
                },
                error: function () {},
                complete: function () {}
            })
        })
        .on('click', '.set-user-access', function (e) {
            e.preventDefault();
            $('#usersModal').modal({
                show: true,
                backdrop: 'static'
            })

            const mod_id = $(this).attr('data-id')

            $('#usersModal span.nama_modul').html($(this).attr('data-nama'))
            $('#usersModal span.id_modul').html(mod_id)
            $('#usersModal span.route').html($(this).attr('data-route'))

            const user_config = {
                columnDefs: {
                    falseSearchable: [0,4],
                    falseOrderable: [0,4],
                    width: ['0(30)','4(150)','2(150)','3(100)'],
                },
                createdRow: ['No', 'UserID', 'Nama', 'NIK', 'Akses'],
                initComplete: function () {}
            }

            dt_users = new Datatable('#dataUsers', user_config, `${HOST}/setting/modul/api/users/${mod_id}`, 'GET')
            if( ! $.fn.DataTable.isDataTable( '#dataUsers' ) ) {
                dt_users.load()
            } else {
                dt_users.reload()
            }
        })

    $('#usersModal').on('hidden.bs.modal', function (event) {
        $('#dataUsers').DataTable().clear().draw();
    })
        .on('click', '.opsi-level', function (e) {
            e.preventDefault();
            const access = $(this).attr('data-access')
            const nik = $(this).attr('data-nik')
            const modul = $(this).attr('data-modul')

            $.ajax({
                type: 'POST',
                url: `${HOST}/setting/modul/set/access`,
                dataType: 'JSON',
                data: {access, nik, modul},
                beforeSend: function () {
                    $('#dataUsers').css('opacity', '.5');
                },
                success: function (response) {
                    if(response.success) {
                        dt_users.reload();
                    }
                },
                complete: function () {
                    $('#dataUsers').css('opacity', '1');
                }
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
        .on('submit', 'form[name="editModul"]', function (e) {
            e.preventDefault();
            const formData = new FormData(this)

            $.ajax({
                type: 'POST',
                url: `${HOST}/setting/modul/edit/api`,
                dataType: 'JSON',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('form[name="editModul"] input, form[name="editModul"] button').prop('disabled', true)
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
                    $('#dataForm .modal-footer .loading-indicator').html('');
                    $('form[name="editModul"] input, form[name="editModul"] button').prop('disabled', false)
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
            backdrop: 'static'
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

                            if( row[5][2] != null) {

                                setTimeout(function () {
                                    if (row[5][2] === 3) {
                                        $(`#modulPriv input[name="${checkbox1}"]`).prop('indeterminate', true)
                                        $(`#modulPriv input[name="${checkbox2}"]`).prop('indeterminate', true)
                                    }
                                    if (row[5][2] === 2) {
                                        $(`#modulPriv input[name="${checkbox1}"]`).prop('indeterminate', true)
                                    }
                                }, 10)
                            }

                            return data
                        },
                        targets: 1,
                    }
                ]
            },
            createdRow: ['No', 'Nama Modul', 'R', 'R/W', 'R/W/D'],
        }

        if(datatable3 == null) {
            datatable3 = new Datatable('#modulPriv', config3, `${HOST}/setting/hakakses/api/${uid}`, 'GET')
            datatable3.load();
        } else {
            datatable3 = new Datatable('#modulPriv', config3, `${HOST}/setting/hakakses/api/${uid}`, 'GET')
            datatable3.reload();
        }
    })

    $("#modalUserAccess").on("hidden.bs.modal", function () {
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