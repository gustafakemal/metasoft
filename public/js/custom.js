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

    $('button.add-acc').on('click', function() {
        const val = $('select[name="aksesoris"] option:selected').val()
        const label = $('select[name="aksesoris"] option:selected').text()

        const len = $('.bs-child').children().length

        console.log(len)

        const elem = `<div class="row mb-1 bscolor-2">
                        <div class="col-sm col-form-label">${label}</div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn-sm btn-danger delbs" id="delbs-2">
                                <i class="fas fa-trash-alt text-light"></i>
                            </button>
                        </div>
                        </div>`

        $('.bs-child').append(elem)
    })
});