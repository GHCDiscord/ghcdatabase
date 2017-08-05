<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
</head>
<body>
<div class="container">
<noscript>JavaScript ist nicht aktiviert!</noscript>
<noscript><div id="body"></noscript>
<script type="text/javascript">
	$(document).ready(function() {
		var sperren = <?php echo $time ?> *
		1000;
		var Seconds = new Date().getTime() + sperren;
		$('#loginbtn').countdown(Seconds, {elapse: true})
			.on('update.countdown', function (event) {
				var $this = $(this);
				if (event.elapsed) {

					console.log('klar');
					$('#loginbtn').text('Login');
					$("#loginbtn").removeClass('disabled');
					<?php $this->session->set_flashdata('msg', ''); ?>
				} else {
					console.log('lmaa');
					$('#loginbtn').text(event.strftime('%H:%M:%S'));
					$("#loginbtn").addClass('disabled');
					<?php
					if(!$errormsg == ''){
					$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">'.$errormsg.'</div>');

					}
					?>
				}
			});
	});

</script>








<?php

if($error){
	$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">'.$errormsg.'</div>');


}


 ?>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
		<?php $attributes = array("name" => "loginform");
			echo form_open("login", $attributes);?>
			<legend>Login</legend>
			<div class="form-group">
				<label for="name">Username</label>
				<input class="form-control" name="email" placeholder="Enter Username" type="text" autocomplete="off"/>
				<span class="text-danger"><?php echo form_error('email'); ?></span>
			</div>
			<div class="form-group">
				<label for="name">Password</label>
				<input class="form-control" name="password" placeholder="Password" type="password" autocomplete="off" />
				<span class="text-danger"><?php echo form_error('password'); ?></span>
			</div>
			<div class="form-group">
				<button id="loginbtn" name="loginbtn" type="submit" class="btn btn-info"></button>
				<button name="cancel" type="reset" class="btn btn-danger">Cancel</button>
			</div>
		<?php echo form_close(); ?>
		<?php echo $this->session->flashdata('msg'); ?>
		</div>
	</div>
	
</div>
</div></noscript>
</div>
</body>
</html>
