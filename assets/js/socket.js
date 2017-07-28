$(function () {
	$('.send_message').on('click', function (e) {
		e.preventDefault();
		$.post('/controller.php', {message: $('.message_input').val()}, function(){
			$('.message_input').val('');
		});
	});
	
	$('.message_input').on('keyup', function (e) {
		if (e.which === 13) {
			$('.send_message').trigger('click');
		}
	});


	var tattler = tattlerFactory.create({
		urls: {
			ws: '/controller.php?ws',
			channels: '/controller.php?channels',
			auth: '/controller.php?auth'
		},
		autoConnect: true,
		debug: true
	});

	tattler.addHandler('message', function (data) {
		renderMessage(data.message, 'left');
	});
});