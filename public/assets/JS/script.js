//Button go to the top.

window.onscroll = function () {
	if (window.scrollY<1) 
		{
			document.getElementById("scrollup_img").style.display = "none";
		} else {
			document.getElementById("scrollup_img").style.display = "block";
		}
	}

//function for the accordion on the details' view

window.onload = () => {
		
	const allAccordionElement = document.querySelectorAll(".accordion-element");
	const firstActive = document.querySelector(".accordion .active");
		
		let section = firstActive.children[1].querySelector("p");
		let sectionHeight = section.offsetHeight + 20;
	
		firstActive.children[1].style.height = sectionHeight+"px";
	
		for(let element of allAccordionElement){
			element.addEventListener("click", function(){

				const active = document.querySelector(".accordion .active");
				active.classList.remove("active");
				active.children[1].style.height = 0;
				this.classList.add("active");

				let section = this.children[1].querySelector("p");
				let sectionHeight = section.offsetHeight + 20;
			
				this.children[1].style.height = sectionHeight+"px";
			});
		}
	}