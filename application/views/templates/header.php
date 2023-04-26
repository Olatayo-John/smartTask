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
	<div class="spinnerdiv">
		<div class="spinner-border" style="color:cornflowerblue"></div>
	</div>

	<?php if ($this->session->userdata('logged_in')) : ?>
		<nav class="navbar navbar-expand-lg navbar-light fixed-top p-0">
			<!-- <?php print_r($_SESSION) ?> -->

			<button class="btn menubtn" onclick="closenav()">&#9776;</button>

			<h5 class="mr-auto site_name"><?php echo $this->st->site_name ?></h5>

			<?php
			if ($this->st->site_logo) {
				$hLogo = base_url('assets/images/site/') . $this->st->site_logo;
			} else {
				$hLogo = $this->df['location'] . '' . $this->df['logo'];
			}
			?>

			<div class="logoimg mr-3">
				<img src="<?php echo $hLogo ?>" alt="" class="navbar-label">
			</div>
			
			<div class="side-nav" id="side-nav">
				<?php $url = $this->session->userdata('url') ?>
				<ul>
					<?php if (!$this->session->userdata('logged_in')) : ?>
						<!-- home -->
						<li class="nav-item">
							<a href="<?php echo base_url('home') ?>" class="nav-link" style="<?php echo ($url == 'home') ? 'background:white;color:#263238' : '' ?>">
								<i class="fas fa-home"></i><b>Home</b>
							</a>
						</li>
					<?php endif; ?>

					<?php if ($this->session->userdata('logged_in')) : ?>

						<!-- dashboard -->
						<li class="nav-item">
							<a href="<?php echo base_url('dashboard') ?>" class="nav-link" style="<?php echo ($url == 'dashboard') ? 'background:white;color:#263238' : '' ?>">
								<i class="fas fa-television"></i><b>Dashboard</b>
							</a>
						</li>

						<!-- myAccount -->
						<li class="nav-item">
							<a href="<?php echo base_url('account') ?>" class="nav-link" style="<?php echo ($url == 'account') ? 'background:white;color:#263238' : '' ?>">
								<i class="fas fa-user"></i><b>Profile</b>
							</a>
						</li>
					<?php endif; ?>

					<?php if ($this->session->userdata('logged_in') && $this->session->userdata('role') == "Admin") : ?>

						<!-- actvity logs -->
						<li class="nav-item">
							<a href="<?php echo base_url('logs') ?>" class="nav-link" style="<?php echo ($url == 'logs') ? 'background:white;color:#263238' : '' ?>">
								<i class="fas fa-clipboard-check"></i><b>Logs</b>
							</a>
						</li>

						<!-- settings -->
						<li class="nav-item">
							<a href="<?php echo base_url('settings') ?>" class="nav-link" style="<?php echo ($url == 'settings') ? 'background:white;color:#263238' : '' ?>">
								<i class="fa-solid fa-gear"></i><b>Settings</b>
							</a>
						</li>
					<?php endif; ?>

					<!-- support -->
					<li class="nav-item">
						<a href="<?php echo base_url('support') ?>" class="nav-link" style="<?php echo ($url == 'support') ? 'background:white;color:#263238' : '' ?>">
							<i class="fas fa-question-circle"></i><b>Support</b>
						</a>
					</li>

					<!-- logOUT -->
					<?php if ($this->session->userdata('logged_in')) : ?>
						<li class="nav-item logoutli">
							<a href="<?php echo base_url('logout') ?>" class="nav-link">
								<i class="fas fa-sign-out-alt text-danger"></i><b>Logout</b>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>

		</nav>
	<?php endif; ?>

	<div class="container">
		<!-- testing div -->
		<!-- <div class="alerterror alertWrapper">
			<strong>Test notification Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur, ratione repudiandae esse repellendus est expedita, quod aut at odio odit ipsam vel! Lorem, ipsum dolor sitss amet consectetur adipisicing elit. Consequatur, ratione repudiandae esse repellendus est expedita, quod aut at odio odit ipsam vel! Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur, ratione repudiandae esse repellendus est expedita, quod aut at odio odit ipsam vel!</strong>
		</div> -->

		<!-- ajax-failed -->
		<div class="alertWrapper ajax_alert_div ajax_err_div" style="padding:8px;display:none;z-index: 9999;">
			<strong class="ajax_res_err text-dark"></strong>
		</div>

		<!-- ajax-success -->
		<div class="alertWrapper ajax_alert_div ajax_succ_div" style="padding:8px;display:none;z-index: 9999;">
			<strong class="ajax_res_succ text-dark"></strong>
		</div>

		<!-- session-flashMsg-function -->
		<?php if ($this->session->userdata('FlashMsg')) : ?>
			<div class="alertWrapper alert<?php echo $this->session->userdata('FlashMsg')['status'] ?>">
				<strong><?php echo $this->session->userdata('FlashMsg')['msg'] ?></strong>
			</div>
		<?php endif; ?>

		<?php if (validation_errors()) : ?>
			<div class="alerterror alertWrapper">
				<strong><?php echo validation_errors(); ?></strong>
			</div>
		<?php endif; ?>
	</div>

	<div id="<?php echo ($this->session->userdata('logged_in')) ? 'content' : '' ?>">
		<div class="spinnerdiv">
			<div class="spinner-border" style="color:cornflowerblue"></div>
		</div>