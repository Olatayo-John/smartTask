<!DOCTYPE html>
<html>

<head>
	<title>
		<?php echo (isset($title) && !empty($title)) ? ucwords($title) . ($this->st->site_name ? ' - ' . $this->st->site_name : '') : '' ?>
	</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="title" content="<?php echo $this->st->site_title ?>">
	<meta name="description" content="<?php echo $this->st->site_desc ?>">
	<meta name="keywords" content="<?php echo $this->st->site_keywords ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css'); ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.0/gsap.min.js"></script>

	<link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>

	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>

	<link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">

	<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/export/bootstrap-table-export.min.js"></script>

	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/print/bootstrap-table-print.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

	<link rel="icon" href="<?php echo base_url('assets/images/') . $this->st->site_fav_icon ?>">
	<script type="text/javascript">
		document.onreadystatechange = function() {
			if (document.readyState !== "complete") {
				$(".spinnerdiv").show();
			} else {
				$(".spinnerdiv").fadeOut();
			}
		};
	</script>
</head>

<body>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">

<div class="wrapper">
	<div class="tabs_">
		<!-- <button class="btn btn-block tablink" id="login" tabName="login">Login</button> -->
	</div>

	<div class="bg-light-custom p-3">
		<div class="loginDiv tabDiv" tabName="login">
			<form action="<?php echo base_url('login'); ?>" method="post" id="loginForm">
				<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

				<div class="form-group">
					<label>Mobile</label><span> *</span>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">+91</span>
						</div>

						<input type="number" name="loginMobile" class="form-control loginMobile" autofocus placeholder="Your mobile" required>
					</div>
					<div class="err mobileerr">Invalid mobile length</div>
				</div>

				<div class="form-group">
					<label>Password</label><span> *</span>
					<input type="password" name="loginPwd" class="form-control loginPwd" placeholder="Your password" required>
				</div>

				<div class="form-group">
					<label for="role"></label>
					<div class="form-group">
						<input type="radio" id="isAdmin" name="role" value="isAdmin" required>
						<label for="isAdmin">Admin</label>

						<input type="radio" id="isStaff" name="role" value="isStaff">
						<label for="isStaff">Staff</label>

						<input type="radio" id="isClient" name="role" value="isClient" checked>
						<label for="isClient">Farmer</label>
					</div>
				</div>

				<div class="form-group btnGroup">
					<button class="btn btn-block btn-bg-custom loginbtn" type="submit">Login</button>
				</div>
			</form>
		</div>
	</div>
</div>




<script>
	$(document).ready(function() {
		//login
		$('form#loginForm').submit(function(e) {
			// e.preventDefault();

			var mobile = $('.loginMobile').val();
			var pwd = $('.loginPwd').val();
			var role = $('input[name="role"]').val();

			if (mobile == "" || mobile == null || mobile.length < 10 || mobile.length > 10) {
				$('.mobileerr').show();
				$('.loginMobile').css({
					'border-bottom': '2px solid #dc3545'
				});
				return false;
			} else {
				$('.mobileerr').hide();
				$('.loginMobile').css({
					'border-bottom': '2px solid #ced4da'
				});
			}

			if (pwd == "" || pwd == null) {
				return false;
			}

			console.log(role);
		});

	});
</script>