<script>
	$(function(){
		$('#send').click(function(){
			$.post('/admin/console/ajax', {code: $('#code').val()}, function(result){
				$('#result').html(result);
			});
		});
	});
</script>

<div class='row'>
	<form method='post'>
		<div class='col-xs-12'>
			<textarea style='height: 250px;' id='code' class='col-xs-12' name='code'></textarea><br />
		</div>
		<div class='col-xs-12'>
			<button type='button' id='send' class='btn btn-primary'>Выполнить</button>
		</div>
	</form>
	<br />
	<div id='result' style='width: 100%; margin-top: 20px; height: 250px; overflow: auto;'></div>
</div>