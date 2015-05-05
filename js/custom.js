$(function() {
	$('.close').click(function() {
		$(this).closest('.closeable').remove();
	});
});