</div>


<script type="text/javascript">
	function opennav() {
		document.getElementById('side-nav').style.marginLeft = "0";
		// document.getElementById('content').style.opacity = ".3";

		$(".menubtn").attr("onclick", "closenav()");
	}

	function closenav() {
		document.getElementById('side-nav').style.marginLeft = "-200px";
		// document.getElementById('content').style.opacity = "1";

		$(".menubtn").attr("onclick", "opennav()");
	}

	//close nav-bar on smaller screen sizes
	function onScreenChange(vp) {
		if (vp.matches) {
			closenav();
		}
	}
	var vp = window.matchMedia("(max-width: 550px)");
	onScreenChange(vp);
	vp.addListener(onScreenChange);

	//scroll to top
	function topFunction() {
		$('html, body').animate({
			scrollTop: 0
		}, 100);
	}

	//alert removes after x-seconds
	$(document).ready(function() {
		setTimeout(() => document.querySelector('.alerterror').remove(), 6000);
		setTimeout(() => document.querySelector('.alertsuccess').remove(), 6000);
	});

	//clear/hide alert
	function clearAlert() {
		$(".alertWrapper").hide();
		$(".alertWrapper strong").empty();
	}
	$(document).on("click", ".alertWrapper", function() {
		clearAlert();
	});

	//wait and reload after ajax
	function chillAndReload(t = null) {
		setTimeout(function() {
			window.location.reload();
		}, t);
	}

	//return random password
	function returnPassword() {
		var length = 10;
		var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		var val = "";

		for (var i = 0, n = charset.length; i < length; ++i) {
			val += charset.charAt(Math.floor(Math.random() * n));
		}
		return val;
	}

	// toggle menu and submenue
	$('.nav-link').click(function(e) {
		var menuName = $(this).attr('menuName');

		if ($('ul[menuName="' + menuName + '"]').hasClass('submenu-close') === true) {
			$('ul[menuName="' + menuName + '"]').removeClass('submenu-close').addClass('submenu-open');
		} else if ($('ul[menuName="' + menuName + '"]').hasClass('submenu-open') === true) {
			$('ul[menuName="' + menuName + '"]').removeClass('submenu-open').addClass('submenu-close');
		}

		// $('.nav-link').css({
		// 	'background': 'unset',
		// 	'color': '#fff',
		// });
		// $(this).css({
		// 	'background': '#fff',
		// 	'color': '#004d40',
		// });

	});

	// toggle tablinks and tabContent
	$('.tablink,.tab_link').click(function(e) {
		e.preventDefault();

		var tabName = $(this).attr('tabName');

		$('.tabDiv').hide();
		$('div[tabName="' + tabName + '"]').show();

		$('.tablink,.tab_link').css({
			'border': 'none',
			'color': '#000',
			'font-weight': '400'
		});

		$(this).css({
			'border-bottom': '1px solid #004d40',
			'color': '#004d40',
			'font-weight': '500'
		});

	});

	//close modal
	$(".closeModalBtn").click(function(e) {
		e.preventDefault();

		var modalName = $(this).attr("modalName");

		$('.' + modalName + '').modal('hide');

	});

</script>
</body>

</html>