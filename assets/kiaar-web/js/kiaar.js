$(document).ready(function() {
   $('.carousel').carousel({
      //interval:false
  }); 

  new WOW().init();

  if ($(window).width() > 1025) {

    //for levelone menu
    $('#headermainav ul li').on("mouseenter", function() {
        $(this).children('.levelone-dropdown').addClass('js-showElement');
    });
    $('#headermainav ul>li').on("mouseleave", function() {
        $(this).find('.levelone-dropdown, .leveltwo-dropdown').removeClass('js-showElement');
    });

    //for leveltwo menu
    $('#headermainav ul li .levelone-dropdown li').on("mouseenter", function() {
        $(this).find('.leveltwo-dropdown').addClass('js-showElement');
    });
    $('#headermainav ul li .levelone-dropdown li').on("mouseleave", function() {
        $(this).find('.leveltwo-dropdown').removeClass('js-showElement');
    });
}

  $('#toggleMenu').on('click', function () {

      $("#cu-overlay").toggleClass("overlay-visible");
      if ($(this).hasClass('js-open')) {

          $('#headermainav > ul > li:not(#toggleMenu)').removeClass('js-showElement');
          $(this).removeClass('js-open');

          $(this).attr('aria-expanded', false);

      } else {

          $('.levelone-dropdown').css('display','none');
          $('.leveltwo-dropdown').css('display','none');
          $('.menu-item').removeClass('js-openSubMenu');

          $('#headermainav > ul > li:not(#toggleMenu)').addClass('js-showElement');
          $(this).addClass('js-open');

          $(this).attr('aria-expanded', true);

      }

      return false;
  });


   if ($(window).width() <= 1024) {
    
   $('.leveltwo-dropdown').addClass('menushows');
 
      $('li .levelone-dropdown').siblings('a').append('<span class="moreicon"></span>');
    
      $('li .menu-item').on('click', function (e) {
         if ($(this).hasClass('menu-item')) {
             
             $(this).addClass('js-openSubMenu');
 
             $(this).siblings('.levelone-dropdown').slideToggle('js-showElement'); 
             $(this).siblings('.leveltwo-dropdown').css('display','block');  
         } 
         
 
     });

   $('.menu-item').on('click', function (e) {
        $(this).parent().siblings().children('a').removeClass('js-openSubMenu');
        $(this).parent().siblings().children('a').removeClass('arrow');
        $(this).parent().siblings().children('.levelone-dropdown').css('display','none');
     
        $(this).addClass('js-openSubMenu');
        $(this).toggleClass('arrow');
    });
 
    $("#cu-overlay").click(function() {
       
        $(this).removeClass("overlay-visible");
        $('#headermainav > ul > li:not(#toggleMenu)').removeClass('js-showElement');
        $('#toggleMenu').removeClass('js-open');

        $('#toggleMenu').attr('aria-expanded', false);
      });
 
    
   }
  
 
  // if ($(window).width() > 768) {

  //   $('li:has("ul")').on('mouseover  mouseleave', function (e) {

  //       if (e.keyCode === 9 | e.type === 'mouseover') {
  
  //           $(this).children('ul').removeClass('js-hideElement');
  //           $(this).children('ul').addClass('js-showElement');
  //       }
  
  
  //       if (e.type === 'mouseleave') {
  
  //           $(this).children('ul').removeClass('js-showElement');
  //           $(this).children('ul').addClass('js-hideElement');
  //       }
  
  //   });
  
    
  // }



  

 $(".lazyloadimg").removeAttr("src");
  const targets = document.querySelectorAll('.lazyloadimg');
  

const lazyLoad = target => {
    const io = new IntersectionObserver((entries, observer) => {
        //console.log(entries)
        entries.forEach(entry => {
            

            if (entry.isIntersecting) {
                const img = entry.target;
                const src = img.getAttribute('data-lazy');

                img.setAttribute('src', src);
                img.classList.add('fade');

                observer.disconnect();
            }
        });
    });

    io.observe(target)
};

targets.forEach(lazyLoad);

 if(/MSIE \d|Trident.*rv:/.test(navigator.userAgent)){
    $(".lazyloadimg").attr("src");
 }

  

$("div#accordion .dropdown-toggle").click(function(){
    $("div#accordion ul.dropdown-menu").css("display", "block");
  });  

 
  $(".ogfarm-main.smartsgriculture .tabsmainsecs button.menus").click(function(){
    $(".ogfarm-main.smartsgriculture .tabsmainsecs ul.nav.nav-tabs").toggleClass("open");;
  });


});

//  $(window).on('load', function(){
//     $('header').children().removeClass('menu-active');

// });


$(function()
 {
   $('#headermainav ul li a').filter(function(){return this.href==location.href}).parent().addClass('highlight').siblings().removeClass('highlight')
   $('#headermainav ul li a').click(function(){
   
     $(this).parent().addClass('highlight').siblings().removeClass('highlight')  
   })
   $('#headermainav ul li ul li.highlight a').parents().each(function(){
     if ($(this).is('li'))
     {
       $(this).addClass("highlight");
     }                            
   });
 });


$(document).ready(function(){
    // SHow more and show less for council, body and oour staff page 
    $('.showMore').click(function(){
        $(this).parents('.contentbox').find('.contentBoxHidden').addClass('show');
        $(this).addClass('d-none');
        $(this).next('.showLess').removeClass('d-none');
    });

     $('.showLess').click(function(){
        $(this).parents('.contentbox').find('.contentBoxHidden').removeClass('show');
        $(this).addClass('d-none');
        $(this).prev('.showMore').removeClass('d-none');
    });
     
    // Smooth scroll for council, body page
    $(".kiaarSidebar ul li a[href^='#']").on("click", function(a) {
      if($(window).width() < 992){
         $("html, body").animate({
            scrollTop: $(this.hash).offset().top - 100
        }, 1000);
      }else{
          $("html, body").animate({
            scrollTop: $(this.hash).offset().top - 50
        }, 1000);
      }
     
    });

    // Sticky SideBar for council, body page
    if($(window).width() < 992){
      var stickySidebar = $('.kiaarSidebar, .mobileSelectBOx').offset().top;
      $(window).scroll(function() {  
          if ($(window).scrollTop() > stickySidebar) {
              $('.kiaarSidebar ul, .mobileSelectBOx').addClass('affix');
          }
          else {
              $('.kiaarSidebar ul, .mobileSelectBOx').removeClass('affix');
          }  
      });
      
      $('.kiaarSidebar ul li a').click(function(){
        var getVale =  $(this).html();
        $('.mobileSelectBOx span').text(getVale);
        $('.kiaarSidebar ul').removeClass('openPanel');
      });
      $('.mobileSelectBOx').click(function(){
        $('.kiaarSidebar ul').toggleClass('openPanel');
      });
    }

    //active class for sidebar  
   $('.kiaarSidebar ul li a').click(function(){
        $('.kiaarSidebar ul li ').removeClass('active');
        $(this).parent('li').addClass('active');
    });


    //for nabard soil test
    
    $('#crop-year').change(function(){
            
      $(this).find("option:selected").each(function(){
          var optionValue = $(this).attr("value");
          if(optionValue){
              $(".crop-col").not("." + optionValue).hide();
              $("." + optionValue).show();
          } else{
              $(".crop-col").hide();
          }
      });
       
    }).change();

    $('#crop-month').change(function(){
        
      $(this).find("option:selected").each(function(){
          var optionValue = $(this).attr("value");
          if(optionValue){
              $(".crop-month-col").not("." + optionValue).hide();
              $("." + optionValue).show();
          } else{
              $(".crop-month-col").hide();
          }
      });
        
    }).change();

    /* copy loaded thumbnails into carousel */
  $('.row .zoom-icon').on('load', function() {}).each(function(i) {
      var itemDiv = $(this).parents('.crop-box');
      var title = $(this).parents('.crop-detail').attr("data-title");
      var item = $('<div class="carousel-item" data-title="'+title+'"></div>');
      $(itemDiv.html()).appendTo(item);
      
      item.appendTo('.carousel-inner'); 
      if (i==0){ // set first item active
          item.addClass('active');
      }
  });


  /* activate the carousel */
  $('#modalCarousel').carousel({interval:false});

  /* change modal title when slide changes */
  $('#modalCarousel').on('slide.bs.carousel', function (e) {
  var to = e['to'];
  var title = $('.carousel-inner').children().eq(to).attr('data-title');
  $('.modal-title').html(title);
  })

  $('.crop-mapping-detail').each(function(i, obj){
  $(obj).find('.col-pd').each(function(j, child){
      $(child).attr('data-index', j);
  });
  });

  /* when clicking a thumbnail */
  $(document).on('click', '.zoom-icon', function(){
      var idx = $(this).parents('.col-pd').attr('data-index');
      var title = $(this).parents('.crop-detail').attr('data-title');
      var id = parseInt(idx);
      $('#crop_details').html('');
      $('#crop-modal').modal('hide');
      var year = $(this).attr("data-year");
      var month = $(this).attr("data-month");
      var farmer_id = $(this).attr("data-farmer-id");
      jQuery.ajax({
          type:"post",
          url: '/kiaar_general/carousel_slider_images/',
          data:'month='+month+'&year='+year+'&farmer_id='+farmer_id,
          // data: formData,
          success: function(response)
          {   
              $('#carousel_inner').html(response);
              $('#carousalModal .modal-title').html(title); //add title since slide carousel is not triggered by the .carousel method if 1st element is clicked
              $('#carousalModal').modal('show'); // show the modal
              $('#modalCarousel').carousel(); // slide carousel to selected
              $('#carousalModal').addClass('fade-bg');
              $('body').addClass('scroll-body');
          }
      });
  });

});

