<div class="wrapper">
	<div class="tabLinkDiv bg-light-custom">
		<a href="" class="tablink" tabName="gen">General</a>
		<a href="" class="tablink" tabName="gCaptcha">Captcha</a>
		<a href="" class="tablink" tabName="smtp">SMTP</a>
	</div>

	<div class="">

		<!-- modals -->

		<!--  -->


		<form action="<?php echo base_url('save-settings') ?>" method="post" id="settingsForm" enctype="multipart/form-data">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">

			<div class="tabInfoDiv bg-light-custom p-3">
				<div class="tabDiv" tabName="gen">

					<div class="row">
						<div class="form-group col-md-6">
							<label>Site Name</label>
							<input type="text" name="site_name" class="form-control site_name" required value="<?php echo $settings->site_name ?>">
						</div>
						<div class="form-group col-md-6">
							<label>Site Title</label>
							<input type="text" name="site_title" class="form-control site_title" value="<?php echo $settings->site_title ?>">
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label>Site Description</label>
							<textarea name="site_desc" class="form-control site_desc" cols="30" rows="3"><?php echo $settings->site_desc ?></textarea>
						</div>
						<div class="form-group col-md-6">
							<label>Site Keywords</label>
							<textarea name="site_keywords" class="form-control site_keywords" cols="30" rows="3"><?php echo $settings->site_keywords ?></textarea>
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label>Site Logo</label>
							<span>Max size: 2MB</span>
							<input type="file" name="site_logo" class="form-control site_logo">
							<input type="hidden" name="current_site_logo" value="<?php echo $settings->site_logo ?>">
						</div>
						<div class="form-group col-md-6">
							<label>Site Fav. Icon</label>
							<span>Max size: 2MB</span>
							<input type="file" name="site_fav_icon" class="form-control site_fav_icon">
							<input type="hidden" name="current_site_fav_icon" value="<?php echo $settings->site_fav_icon ?>">
						</div>
					</div>

				</div>

				<div class="tabDiv" tabName="gCaptcha">

					<div class="row">
						<div class="form-group col-md-6">
							<label>reCAPTCHA Site Key</label>
							<input type="password" name="captcha_site_key" class="form-control captcha_site_key" value="<?php echo $settings->captcha_site_key ?>">
						</div>
						<div class="form-group col-md-6">
							<label>reCAPTCHA Secret Key</label>
							<input type="password" name="captcha_secret_key" class="form-control captcha_secret_key" value="<?php echo $settings->captcha_secret_key ?>">
						</div>
					</div>

				</div>

				<div class="tabDiv" tabName="smtp">

					<div class="form-group">
						<label>Protocol</label>
						<input type="text" name="protocol" class="form-control protocol" value="<?php echo $settings->protocol ?>">
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label>SMTP User</label>
							<input type="text" name="smtp_user" class="form-control smtp_user" value="<?php echo $settings->smtp_user ?>">
						</div>
						<div class="form-group col-md-6">
							<label>SMTP Password</label>
							<input type="password" name="smtp_pwd" class="form-control smtp_pwd" value="<?php echo $settings->smtp_pwd ?>">
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label>SMTP Host</label>
							<input type="text" name="smtp_host" class="form-control smtp_host" value="<?php echo $settings->smtp_host ?>">
						</div>
						<div class="form-group col-md-6">
							<label>SMTP Port</label>
							<input type="text" name="smtp_port" class="form-control smtp_port" value="<?php echo $settings->smtp_port ?>">
						</div>
					</div>

				</div>

				<div class="form-group d-flex mt-5" style="justify-content:space-between;">
					<button class="btn text-light btn-danger" id="resetSettingsBtn" type="button">Reset</button>
					<button class="btn text-light saveSettingsBtn" type="submit" style="background:#263238">Update</button>
				</div>
			</div>

		</form>
	</div>
</div>



<script type="text/javascript" src="<?php echo base_url('assets/js/settings.js'); ?>"></script>
<script type="text/javascript">
	var csrfName = $('.csrf_token').attr('name');
	var csrfHash = $('.csrf_token').val();

	$(function() {
		var buttonsOrder = ['export', 'btnAdd'];

		$('#planstable').bootstrapTable('refreshOptions', {
			buttonsOrder: buttonsOrder
		})

	});


	$(document).ready(function() {

		//reset settings
		$('#resetSettingsBtn').on('click', function(e) {
			e.preventDefault();

			var con = confirm('Are you sure you want to reset settings?');

			if (con !== true) {
				return false;
			} else {
				$.ajax({
					url: "<?php echo base_url("reset-settings"); ?>",
					method: "post",
					dataType: "json",
					data: {
						[csrfName]: csrfHash
					},
					beforeSend: function(res) {
						clearAlert();

						$('#resetSettingsBtn').html('Reseting...').attr('disabled', 'disabled').css('cursor', 'not-allowed');
					},
					success: function(res) {
						if (res.status === 'error') {
							window.location.assign(res.redirect);
						} else if (res.status === false) {
							$(".ajax_res_err").append(res.msg);
							$(".ajax_err_div").fadeIn();
						} else if (res.status === true) {
							$(".ajax_res_succ").append(res.msg);
							$(".ajax_succ_div").fadeIn();

							chillAndReload(t = 1000);
						}

						$('#resetSettingsBtn').html('Reset').removeAttr('disabled').css('cursor', 'pointer');
						$('.csrf_token').val(res.token);
					},
					error: function(res) {
						var con = confirm('Some error occured. Refresh?');
						if (con === true) {
							window.location.reload();
						} else if (con === false) {
							return false;
						}
					},
				});
			}
		});

		//save settings
		$('#settingsForssm').submit(function(e) {
			// e.preventDefault();

			var site_name = $('.site_name').val();

			console.log(site_name);

			if (site_name == "" || site_name == null) {
				return false;
			}

			$.ajax({
				beforeSend: function() {
					$('.saveSettingsBtn').attr('disabled', 'disabled').html('Saving...').css('cursor', 'not-allowed');

					clearAlert();
				}
			});
		});

	});
</script>