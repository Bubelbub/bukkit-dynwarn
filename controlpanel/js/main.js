function searchUser(obj)
{
	var username = $(obj).val();
	$('.warn').show();
	$('.warn').each(function()
	{
		var userField = $(this).find('.warn_username');
		if	(
				userField.html().toUpperCase() != username.toUpperCase()
				&& userField.html().substr(0, username.length).toUpperCase() != username.toUpperCase()
				&& userField.html().substr(userField.html().length - username.length).toUpperCase() != username.toUpperCase()
			)
		{
			$(this).hide();
		}
	});
}

$(function()
{
	$('.warnSearch')
		.keyup(function() { searchUser(this); });
});
