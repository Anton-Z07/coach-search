$(function(){
	$('#change-photo').click(function(e){
    	$('#photo-select').click();
    });

    $('#photo-select').change(function(){
    	file = this.files[0];
    	SubmitPhoto(file, $(this).attr('data-type'));
    });
});

function SubmitPhoto(file, type)
{
	formdata = new FormData();
	//reader = new FileReader();
	if (!file) return;
	//reader.readAsDataURL(file);
	formdata.append("images[]", file);
	$.ajax({
		url: "/coach/upload/photo?dest=" + type,
		type: "POST",
		data: formdata,
		processData: false,
		contentType: false,
		success: function (res) {
			OnImageUploaded(res, type);
		}
	});
}

function OnImageUploaded(res, type)
{
	res = JSON.parse(res);
	if (res.result == 'ok')
	{
		$("#edit-photo img").attr('src', res.full_path);
		$('#photo-input').val(res.name);
	}
	else alert(res.description);
}