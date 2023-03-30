/**
 *  Custom jQuery Scripts
 *  
 *  Developed by: Lisa DeBona
 *  Date Created: 03.29.2023
 */

(function($) {
    $.fn.countUp = function(options) {
        options = options || {};
        this
            .each(function () {
                $(this).data('val', parseInt(($(this).text().replace(/[\.,]/,'') || '0'), 10));
                this.innerHTML = 0;
            })
            .on('inview', function(ev, isInView) {
                // cache base value + remove dot or comma, and get it
                var i = +$(this).data('val'), // || +($(this).data('val', v=parseInt(($(this).text().replace(/[\.,]/,'') || '0'), 10)), v),
                    self = this;

                if (isInView) {

                    // uses easing!
                    $({n: 0}).stop(true).animate({n: i},
                        {
                            duration: $.speed(options.duration || $(this).data('count-duration')).duration,
                            step: function(now, fx) {
                                self.innerHTML = parseInt(now, 10).toLocaleString('en-US'); // use comma per thousand version
                            }
                        }
                    );

                }
                // this seems not to work
                else {
                    self.innerHTML = 0;
                }
            });
    };

    // auto init
    $(function() {
        $('[count="up"]').countUp();
    });


})(jQuery);

jQuery(document).ready(function ($) {

  $('.fancybox').fancybox({
    protect: true,
    loop: false,
    buttons : ['close','thumbs','fullScreen'],
    hash : false,
    afterLoad : function(instance, current) {
    }
  });

  var owl = $('.carouselcontent');
  owl.owlCarousel({
    center: true,
    items:2,
    loop: true,
    margin: 10,
    autoplay: false,
    autoplayTimeout: 5000,
    responsiveClass: true,
    onInitialized:function(){
    },
    onDragged:function(){
    },
    onChanged:function(e){
    },
    responsive:{
      900:{
        items:2
      }
    }
  });

  $('[data-bacount]').each(function(){
    var owlSelector = $(this).find('.before-after-carousel');
    var count = $(this).attr('data-bacount');
    beforeAfterCarousel(owlSelector,count);
  });

  function beforeAfterCarousel(selector,count) {
    if(count>4) {
      var options = {
        items:2,
        loop: true,
        margin: 0,
        nav: true,
        navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
        autoplay: false,
        autoplayTimeout: 5000,
        responsiveClass: true,
        responsive:{
          800:{
            items:4
          },
          1200:{
            items:5
          },
        }
      }
      selector.owlCarousel(options);
    }
    
    // selector.owlCarousel({
    //   items:2,
    //   loop: true,
    //   margin: 0,
    //   autoplay: false,
    //   autoplayTimeout: 5000,
    //   responsiveClass: true,
    //   onInitialized:function(){
    //   },
    //   onDragged:function(){
    //   },
    //   onChanged:function(e){
    //   },
    //   responsive:{
    //     800:{
    //       items:4
    //     },
    //     1200:{
    //       items:5
    //     },
    //   }
    // });
  }

  

  function checkVisability() {
    var row = $('.image-text-section');
    row.each(function(){
      $(this).on('inview', function(ev, isInView) {
        if (isInView) {
          $(this).addClass("inview");
        } else {
          $(this).removeClass("inview");
        }
      });
    });
  }

  checkVisability();
  $(window).scroll(function() {
    checkVisability();
  });

  
  /* BANNER TABS */
  $('.flex-content[data-title]').each(function(){
    if( $(this).attr('data-title') ) {
      var title = $(this).attr('data-title');
      var id = $(this).attr('id');
      var tab = '<a href="#'+id+'">'+title+'</a>';
      $('#bannerTabs').append(tab);
    }
  });

  /* SMOOTH SCROLLING */
  $('a[href*="#"]')
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var offset = $('.fusion-header-wrapper .fusion-header').height() + 100;
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top - offset
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });

  if( $('.section-before-and-after').length ) {
    var imageResizer = $('.baTabs').attr('data-resizer');
    var imageContainer = '<div class="baImageContainer">';
    var baImages = [];
    var i = 1;
    $('.section-before-and-after .info').each(function(){
      var parent = $(this).parent().not('.cloned');
      var link = parent.find('.ba_tab');
      var baId = link.attr('data-id');
      var beforeImg = link.attr('data-before-img');
      var afterImg = link.attr('data-after-img');
      if(beforeImg && afterImg) {
        var baImgs = [beforeImg,afterImg];
        baImages.push(baImgs);
        var isActive = (i==1) ? ' active':'';
        imageContainer += '<div data-rel="'+baId+'" class="baItem'+isActive+'">';
        imageContainer += '<div class="img before"><span>Before</span><figure style="background-image:url('+beforeImg+')"><img class="resizer" src="'+imageResizer+'" /></figure></div>';
        imageContainer += '<div class="img after"><span>After</span><figure style="background-image:url('+afterImg+')"><img class="resizer" src="'+imageResizer+'" /></figure></div>';
        imageContainer += '</div>';
        i++;
      }
    });
    imageContainer += '</div>';
    if(baImages.length) {
      $('.ba-image-container').html(imageContainer);
    }
  }

  $(document).on('click','.ba_tab',function(e){
    e.preventDefault();
    var baId = $(this).attr('data-id');
    $('.baTabs .info').removeClass('active');
    $(this).parent().toggleClass('active');
    $('.section-before-and-after .baItem').removeClass('active');
    $('.section-before-and-after .baItem[data-rel="'+baId+'"]').addClass('active animated fadeIn');
  }); 

});