$(function () {

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
});