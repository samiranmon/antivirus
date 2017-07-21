
//Accordian



jQuery(document).ready(function() {

jQuery("#owl-demo").owlCarousel({
      navigation : true,  
 
      slideSpeed : 300,
      paginationSpeed : 400,
 
      items : 1, 
      itemsDesktop : false,
      itemsDesktopSmall : false,
      itemsTablet: false,
      itemsMobile : false
});

//owl-carousel-2
jQuery('#owl-demo-2').owlCarousel({
    loop:true,
    navigation : false,  
    //margin:15,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:1,
            nav:false,
            loop:false
        }
    }
});

jQuery("#owl-demo-3").owlCarousel({
      navigation : true, 
      pagination : false, 
 	  dots: false,
      slideSpeed : 300,
      paginationSpeed : 400,
 
      items : 1, 
      itemsDesktop : false,
      itemsDesktopSmall : false,
      itemsTablet: false,
      itemsMobile : false
});


//owl-carousel-4
jQuery('#owl-demo-4').owlCarousel({
    loop:true,
    navigation : false,  
    //margin:15,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:1,
            nav:false,
            loop:false
        }
    }
});

jQuery("#owl-demo-5").owlCarousel({
      navigation : true, 
      pagination : false, 
 	  dots: false,
      slideSpeed : 300,
      paginationSpeed : 400,
 
      items : 1, 
      itemsDesktop : false,
      itemsDesktopSmall : false,
      itemsTablet: false,
      itemsMobile : false
});


jQuery('#brand-owl').owlCarousel({
    loop:true,
    navigation : false,  
    //margin:15,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:3,
            nav:false
        },
        1000:{
            items:6,
            nav:false,
            loop:false
        }
    }
});



jQuery("#webslider").owlCarousel({
      navigation : true,  
 
      slideSpeed : 300,
      paginationSpeed : 400,
 
      items : 1, 
      itemsDesktop : false,
      itemsDesktopSmall : false,
      itemsTablet: false,
      itemsMobile : false
});

jQuery("#windowslider").owlCarousel({
      navigation : true,  
 
      slideSpeed : 300,
      paginationSpeed : 400,
 
      items : 1, 
      itemsDesktop : false,
      itemsDesktopSmall : false,
      itemsTablet: false,
      itemsMobile : false
});

jQuery("#owl-demo-bt").owlCarousel({
      navigation : true,  
 
      slideSpeed : 300,
      paginationSpeed : 400,
 
      items : 1, 
      itemsDesktop : false,
      itemsDesktopSmall : false,
      itemsTablet: false,
      itemsMobile : false
});

jQuery("#owl-demo-trd").owlCarousel({
      navigation : true,  
 
      slideSpeed : 300,
      paginationSpeed : 400,
 
      items : 1, 
      itemsDesktop : false,
      itemsDesktopSmall : false,
      itemsTablet: false,
      itemsMobile : false
});

// jQuery('.panel-heading a').click(function() {
//     jQuery('.panel-heading').removeClass('actives');
//     jQuery(this).parents('.panel-heading').addClass('actives');
// });

(function() {
  
  jQuery(".panel").on("show.bs.collapse hide.bs.collapse", function(e) {
    if (e.type=='show'){
      jQuery(this).addClass('active');
    }else{
      jQuery(this).removeClass('active');
    }
  });  

}).call(this);



  jQuery(function() {
    jQuery( ".tittle-pannel" ).click(function() {
        if (jQuery(window).width() < 1025) {
        jQuery( ".banner-block .panel-group" ).toggle();
        } else {
                toggle();
            }

    });
});


//Footer menu
jQuery(document).ready(function ($) {

        var screenWidth = jQuery(window).width();
        jQuery('.footer-title').click(function () {
            if (jQuery(window).width() <= 768) {

                if (jQuery(this).hasClass('selected')) {
                    jQuery(this).removeClass('selected');
                    jQuery(this).next('.footer-option').slideUp();
                } else {
                    jQuery('.footer-title').not(this).each(function () {
                        jQuery(this).next('.footer-option').slideUp();

                        jQuery(this).removeClass('selected');
                        jQuery(this).next('.footer-option').slideUp();

                    });
                    jQuery('.footer-option .footer-title').removeClass("selected");
                    jQuery(this).addClass("selected");
                    jQuery(this).next('.footer-option').slideDown();
                }

            }
        });

    });


});

