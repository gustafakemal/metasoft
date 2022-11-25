$(function () {

    const el_success = $('.hidden-success-el');

    if(el_success.length > 0) {
        const float_msg = el_success.text();
        $('.floating-msg').addClass('show').html(`<div class="alert alert-success">${float_msg}</div>`)
        setTimeout(() => {
            $('.floating-msg').removeClass('show');
        }, 3000);
    }

      $('.sidebar-nav .burger-icon').tooltip({
        title: function() {
          return ($(this).hasClass('active')) ? 'Hilangkan sidebar' : 'Tampilkan sidebar'
        },
      });

    $('.sidebar-nav').on('click', '.burger-icon', function() {
        $(this).tooltip('hide')
		$(this).toggleClass('active');
		$('.sidebar').toggleClass('hide');
		$('.content-wrapper').toggleClass('wide')
	})

    $('.sidebar-mob').on('click', '.burger-icon', function() {
        $('.sidebar').addClass('mob-show');
        $('.overlay').addClass('show menu');
    })

    $('#page').on('click', '.overlay.show.menu', function() {
        $('.sidebar').removeClass('mob-show');
        $('.overlay').removeClass('show menu');
    })

    $('body').tooltip({
       selector: '[data-toggle="tooltip"]'
    });

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

    $('.bs-child').on('click', '.delbs', function (e) {
        const split_el = $(this).attr('id').split('-')
        const idx = aksesories.indexOf(split_el[1]);
        if (idx !== -1) {
            aksesories.splice(idx, 1);
        }
        $(`.bs-child #bscolor-${split_el[1]}`).remove()
    })
});