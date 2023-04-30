<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/support.css'); ?>">

<div class="wrapper">
	<div class="col-md-12 bg-light-custom" style="display:flex;flex-direction:row;flex-wrap:wrap;padding:0;">

		<div class="col-md-6 p-3">
			<form action="<?php echo base_url('support'); ?>" method="post" class="contactform">
				<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

				<div class="form-group">
					<label>Name</label> <span>*</span>
					<input type="text" name="name" class="form-control name" placeholder="Your Name" required>
				</div>

				<div class="form-group">
					<label>Email</label> <span>*</span>
					<input type="email" name="email" class="form-control email" placeholder="example@domain.com" required>
				</div>

				<div class="form-group">
					<label>Message</label> <span>*</span>
					<textarea name="msg" class="form-control msg" rows="6" placeholder="Drop your message" required></textarea>
				</div>

				<div class="g-recaptcha form-group" data-sitekey="<?php echo $this->st->captcha_site_key ?>"></div>
				<div class="subbtngrp text-center">
					<button class="btn text-light btn-block cnt_submit" style="background:#004d40">Submit</button>
				</div>
			</form>
		</div>

		<div class="col-md-6 p-3 info">
			<div class="imagediv text-center mb-5">
				<img src="<?php echo base_url('assets/images/') . $this->st->site_logo ?>" class="">
			</div>
			<div class="">
				<i class="fas fa-map-marker"></i>Muzaffarnagar, UP
			</div>
			<div class="">
				<i class="fas fa-phone-alt"></i><a href="tel:+918477070000">+918477070000</a>
			</div>
			<div class="">
				<i class="fas fa-at"></i><a href="mailto:info@sidhbalifertilizers.com">info@sidhbalifertilizers.com</a>
			</div>
			<div class="">
				<i class="fa-brands fa-internet-explorer"></i><a href="https://sidhbalifertilizers.com">sidhbalifertilizers.com</a>
			</div>
			<hr>
			<div class="">
				<div class="" style="font-weight: 500;text-align: center;">
					<a href="https://nkTech.in">NkTech</a> © 2012-<?php echo date('Y') ?> All rights reserved.<br>Terms of Use and Privacy Policy
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('.contactform').on('submit', function(e) {
			//  e.preventDefault();

			$('.cnt_submit').html("Submitting...").attr('disabled', 'disabled').css('cursor', 'not-allowed');
		});
	})
</script>