function CloseDialog()
{
	$('#shadow').hide();
	$('.modal-dialog-open').hide();
	$('#'+id).removeClass('modal-dialog-open');
	$('body').removeClass('modal-open');
}

function ShowDialog(id)
{
	$('body').addClass('modal-open');
	if (!$('#shadow').size()) $('body').append('<div id="shadow"></div>');
	$('#shadow').show();
	$('#'+id).addClass('modal-dialog-open');
	$('#'+id).show();
}