

$(document).ready(function() {

$("#owl-demo").owlCarousel({
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
$('#owl-demo-2').owlCarousel({
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
})

$("#owl-demo-3").owlCarousel({
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
$('#owl-demo-4').owlCarousel({
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
})

$("#owl-demo-5").owlCarousel({
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


$('#brand-owl').owlCarousel({
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
})

jQuery('.panel-heading a').click(function() {
    $('.panel-heading').removeClass('actives');
    $(this).parents('.panel-heading').addClass('actives');
});

});

