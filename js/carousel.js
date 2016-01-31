(function ($, window, document) {
  $(document).ready(function() {
   
    $("#featured-carousel-content").owlCarousel({
      autoPlay: true,
      stopOnHover: true, // Stop autoplay on mouse hover
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true
    });
   
  });
}(jQuery, window, document));
