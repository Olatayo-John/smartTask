</div>


<script type="text/javascript">
	function opennav() {
		document.getElementById('side-nav').style.width = "200px";
		document.getElementById('content').style.marginLeft = "200px";

		$('div.side-nav ul li a.nav-link b').css({
			'display': 'unset'
		});
	}

	function closenav() {
		document.getElementById('side-nav').style.width = "60px";
		document.getElementById('content').style.marginLeft = "60px";

		$('div.side-nav ul li a.nav-link b').css({
			'display': 'none'
		});
	}

	//close nav-bar on smaller screen sizes
	function onScreenChange(vp) {
		if (vp.matches) {
			closenav();
		} else {
			opennav();
		}
	}
	var vp = window.matchMedia("(max-width: 550px)");
	onScreenChange(vp);
	vp.addListener(onScreenChange);


	function topFunction() {
		$('html, body').animate({
			scrollTop: 0
		}, 100);
	}


	function clearAlert() {
		$(".alertWrapper").hide();
		$(".alertWrapper strong").empty();
	}

	$(document).on("click", ".alertWrapper", function() {
		clearAlert();
	});

	function chillAndReload(t = null) {
		setTimeout(function() {
			window.location.reload();
		}, t);
	}

	function returnPassword() {
		var length = 10;
		var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		var val = "";

		for (var i = 0, n = charset.length; i < length; ++i) {
			val += charset.charAt(Math.floor(Math.random() * n));
		}
		return val;
	}

	$(".menubtn").click(function() {
		var func = $(this).attr("onclick");
		if (func == "opennav()") {
			$(this).attr("onclick", "closenav()");
		} else if (func == "closenav()") {
			$(this).attr("onclick", "opennav()");
		}

	});

	// toggle tablinks and tabContent
	$('.tablink,.tab_link').click(function(e) {
		e.preventDefault();

		var tabName = $(this).attr('tabName');

		$('.tabDiv').hide();
		$('div[tabName="' + tabName + '"]').show();

		$('.tablink,.tab_link').css({
			'border': 'none',
			'color': '#263238',
			'font-weight': '400'
		});

		$(this).css({
			'border-bottom': '1px solid #263238',
			'color': '#263238',
			'font-weight': '500'
		});

	});

	//close modal
	$(".closeModalBtn").click(function(e) {
		e.preventDefault();

		var modalName = $(this).attr("modalName");

		$('.' + modalName + '').modal('hide');

	});


	$(document).ready(function() {
		setTimeout(() => document.querySelector('.alerterror').remove(), 6000);
		setTimeout(() => document.querySelector('.alertsuccess').remove(), 6000);
	});
</script>
</body>

</html>