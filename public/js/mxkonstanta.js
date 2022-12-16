

$(function () {
	

	
	$('.konstanta-save').on('click', function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		const data = {
			id: $('#id-'+id).val(),
			nilai: $('#nilai-'+id).val(),
			aktif: $('#aktif-'+id).val(),
		}
		
		//alert($('#id-'+id).val());
		$.ajax({
			type: "PUT",
			url: `${HOST}/mxkonstanta/edit/api`,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			contentType: 'application/x-www-form-urlencoded; charset=utf-8',
			dataType: 'JSON',
			data: data,
			beforeSend: function () {},
			success: function (response) {
				location.reload();
				let msgClass;
				if(response.success) {
					reload_tr();
					msgClass = 'success'
				} else {
					msgClass = 'danger'
				}
				$('.floating-msg').addClass('show').html(`<div class="alert alert-${msgClass}">${response.msg}</div>`)
			},
			error: function (response) {
				if(response.status == 403) {
					$('.floating-msg').addClass('show').html(`
								<div class="alert alert-danger">${response.responseJSON.msg}</div>
								`)
				}
			},
			complete: function() {
				setTimeout(() => {
					$('.floating-msg').removeClass('show').html('');
				}, 3000);
			}
		})
	})


	
});

function getAllData(obj)
{
	$.ajax({
		type: "GET",
		url: `${HOST}/mxkonstanta/api`,
		beforeSend: obj.beforeSend,
		success: obj.success,
		error: obj.error,
		complete: obj.complete
	})
}