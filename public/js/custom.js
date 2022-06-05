$(function () {

  $('[data-toggle="tooltip"]').tooltip();
  $('.sidebar-nav-btn .burger-icon').tooltip({
    title: function() {
      return ($(this).hasClass('active')) ? 'Hide sidebar' : 'Show sidebar'
    },
  });
  $('.sidebar-nav-btn .burger-icon-mobile').tooltip({title: 'Show sidebar'});

  setTimeout(() => {
    $('.floating-msg').html('').removeClass('show');
  }, 3000);

  $('form[name="login"]').on('submit', function(e) {
    e.preventDefault();
    $('form[name="login"] input[name="nik"], form[name="login"] input[name="password"]').removeClass('border-danger')
    const nik = $('input[name="nik"]').val();
    const password = $('input[name="password"]').val();

    $.ajax({
      type: 'POST',
      url: `${HOST}/auth/checkLogin`,
      dataType: 'JSON',
      data: { nik, password },
      beforeSend: function() {
        $('form[name="login"] button[name="submit"], form[name="login"] input[name="nik"], form[name="login"] input[name="password"]').attr('disabled', true);
      },
      success: function(response) {
        if(response.success) {
          window.location.href = HOST;
        } else {
          $('form[name="login"] input[name="nik"], form[name="login"] input[name="password"]').addClass('border-danger')
        }
      },
      complete: function() {
        $('form[name="login"] button[name="submit"], form[name="login"] input[name="nik"], form[name="login"] input[name="password"]').attr('disabled', false);
      }
    })
  })
  

  $(window).on('scroll', function() {
		const position = $(this).scrollTop();
		if(position >= 63) {
			$('.header-wrapper').addClass('fixed');
			$('.main-wrapper').addClass('fixed-to-header');
		} else {
			$('.header-wrapper').removeClass('fixed');
			$('.main-wrapper').removeClass('fixed-to-header');
		}
	})

	$('.sidebar-nav-btn').on('click', '.burger-icon', function() {
		$(this).toggleClass('active');
		$('.sidebar').toggleClass('hide');
		$('.header-wrapper, .main-wrapper, .app-footer').toggleClass('to-sidebar-hide')
	})
  $('.sidebar-nav-btn').on('click', '.burger-icon-mobile', function() {
    $('.sidebar').addClass('on-mobile-show');
    $('.overlay').addClass('show sidebar-mobile');
    $('body').addClass('hidescroll');
  })
  $('#page').on('click', '.overlay.sidebar-mobile', function() {
    $(this).removeClass('show sidebar-mobile');
    $('.sidebar').removeClass('on-mobile-show');
    $('body').removeClass('hidescroll');
  });

	$('.switch-nav .dropdown-item').on('click', function(e) {
		e.preventDefault();
		const key = $(this).attr('data-key');
    console.log(key)
		$.ajax({
			type: "POST",
			url: `${HOST}/auth/changeFungsi`,
			data: {key},
			dataType: "JSON",
			beforeSend: function () {
				$('.overlay').addClass('show')
			},
			success: function (data) {
        console.log(window.location.href);
				if(data.success) {
					$('.switch-nav .fungsi').html(data.Site + ' - ' + data.Fungsi)
					$('.switch-nav .dropdown-item').removeClass('active')
					$('.switch-nav .dropdown-item:nth-child('+(data.selected_key + 1)+')').addClass('active')
				}
			},
			error: function () {},
			complete: function (complete) {
        $('.overlay').removeClass('show')
        location.reload();
			}
		})
	});

  $('[id*=acc_notes]').on('keyup', function() {

    const maxlength = $(this).attr('maxlength');

    const characterCount = $(this).val().length;
    const current = $('#current');
    const maximum = parseInt(maxlength) - parseInt(characterCount);
    current.text(maximum);
  });
});