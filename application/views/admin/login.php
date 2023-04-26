<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">

<div class="" id='loginWrapper'>
	<div class="container">
		<div class="row" style="justify-content: center;">
			<div class="col-lg-5 bg-light-custom">
				<?php
				if ($this->st->site_logo) {
					$tLogo = base_url('assets/images/site/') . $this->st->site_logo;
				} else {
					$tLogo = $this->df['location'].''.$this->df['logo'];
				}
				?>

				<div class="tabLogo">
					<img src="<?php echo $tLogo ?>" alt="">
				</div>

				<div class="tabs">
					<button class="btn btn-block tablink" id="user" tabName="user">Admin Login</button>
				</div>

				<div class="tabDivs">
					<div class="adminDiv tabDiv" tabName="admin">
						<form action="<?php echo base_url('adminlogin'); ?>" method="post">
							<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

							<div class="form-group">
								<label>Email</label><span class='req'> *</span>
								<input type="email" name="adminEmail" class="form-control adminEmail" autofocus placeholder="Your Email" required>
							</div>

							<div class="form-group">
								<label>Password</label><span class='req'> *</span>
								<input type="password" name="adminPwd" class="form-control adminPwd" placeholder="Your password" required>
							</div>

							<div class="form-group btnGroup">
								<button class="btn btn-block btn-bg-custom loginbtn" type="submit">Login</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
	$(document).ready(function() {});
</script>