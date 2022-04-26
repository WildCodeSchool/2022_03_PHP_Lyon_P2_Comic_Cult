
window.onscroll = function () {
	if (window.scrollY<1) 
		{
			document.getElementById("scrollup_img").style.display = "none";
		} else {
			document.getElementById("scrollup_img").style.display = "block";
		}
	}