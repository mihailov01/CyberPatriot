let slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  var w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
  let slides = document.getElementsByClassName("mySlides"); 
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}

  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "None";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
/*     let elem = document.querySelector('#mySlide');
    elem.style.paddingTop = '15px'; */
  }

 /* function paddingNew(){
  let elem = document.querySelector('#mySlide');
  elem.style.paddingTop = '15px';
 } */


  if (window.screen.width >=700){
    slides[slideIndex-1].style.display = "flex"
  } else {
    slides[slideIndex-1].style.display = "block";
    let sliderSh = document.querySelector('#sliderShow');
    sliderSh.style.height = '1025px';
    sliderSh.style.margin = '-40px -8px 0 -8px'
  


  }
  dots[slideIndex-1].className += " active";
} 