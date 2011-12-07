$(document).ready(function() {
	$('#controls').bind('submit', function(e) {
		form = this;
		e.preventDefault();
		submitUrl = $(this).attr('action');
		$('[name="responseType"], [name="language"], [name="inputType"], [name="inputValue"]', this).each(function() {
			submitUrl += '/' + $(this).val();
		});
		$.ajax(submitUrl, {
			success: function(data, textStatus, jqXHR) {
				$('#response').val(jqXHR.responseText);
			}
		});
	});
});