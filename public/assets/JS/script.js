
	jQuery(function () {
        $(window).scroll(function () { 
            if ($(this).scrollTop() > 1) { 
                $('#scrollUp').css('right', '1.8vh'); 
            } else {
                $('#scrollUp').removeAttr('style'); 
            }
        });
    });  
