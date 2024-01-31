
(function($) {


   //
   // TAX TREE WIDGET
   //
	var MAETaxTreeHandler = function( $scope, $ ) {

      var toggler = $scope.find('.mae_navigation_tree li .sub_toggler');
      $(toggler).on('click', function(e){
         var $this = $(this);
         if ($this.hasClass('opened')) {
            $this.parent().find('ul').first().css('display', 'block');
         }
         $this.parent().find('ul').first().slideToggle(200);
         $this.toggleClass('opened');
      })

   };
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_taxonomy_navigation_tree.default', MAETaxTreeHandler );
	} );







   //
   // NAV TREE WIDGET
   //
	var MAENavMenuTreeHandler = function( $scope, $ ) {

      var toggler = $scope.find('.mae_navigation_tree li .sub_toggler');
      $(toggler).on('click', function(e){
         var $this = $(this);
         $this.parent().find('ul').first().slideToggle(200);
         $this.toggleClass('opened');
      })

      // auto open current item on menu
      if ($scope.hasClass('mae_unfold_current')) {
         var to_toggle_li = $scope.find('li.current-menu-ancestor');
         $(to_toggle_li).each(function(){
            $(this).find('.sub_toggler').first().click();
         });
      }

   };
	$( window ).on( 'elementor/frontend/init', function() {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_navigation_menu_tree.default', MAENavMenuTreeHandler );
	} );









   //
   // NAV SLIDES WIDGET
   //
	var MAESlideMenuHandler = function( $scope, $ ) {

      // SET IDS MENUS AND MOVE SUB MENUS TO TOP LEVEL
      var main_menu = $($scope.find('.mae_slide_menu ul.menu'));
      var sub_menus = main_menu.find('ul').each(function(){
         $(this).attr('data-parent-id', $(this).parent().closest('ul').attr('id'));
      });
      var $contaner = $($scope.find('.mae_slide_menu'));
      $contaner.append(sub_menus);

      // VARS
      var animation_duration = parseInt($contaner.attr('data-animation-duration')) + 20;
      var auto_height = false;

      // SUB MENU CLICK
      var li = $scope.find('.mae_slide_menu li.menu-item-has-children');
      $(li).on('click', function() {

         var $new_ul = $($scope.find('#menu-' + $(this).attr('id').replace(/\D/g,'')));
         var $cur_ul = $($scope.find('#' + $new_ul.attr('data-parent-id')));

         $cur_ul.addClass('slide_out_left');
         $new_ul.addClass('slide_in_left opened');

         var old_height = $cur_ul[0].scrollHeight;
         var new_height = $new_ul[0].scrollHeight;

         console.log('old_height', new_height);
         console.log('new_height', new_height);
         console.log('auto_height', auto_height);

         // $contaner.height(new_height);


         scrollBarUpdate(new_height);

         if ($scroll_el) {
            $scroll_el.css('overflow-y', 'hidden');
            var top_offset = $scroll_el.scrollTop();
            $new_ul.css('padding-top', top_offset);
         }

         if (auto_height && new_height > old_height) {

            $contaner.height(new_height);
         }

         setTimeout(function(){

            $cur_ul.removeClass('slide_out_left opened ');
            $new_ul.removeClass('slide_in_left');

            if ($scroll_el) {
               $scroll_el.css('overflow-y', '');
               $new_ul.css('padding-top', '');
               $scrollbar.val(0); 
               $scroll_el.scrollTop(0);
            }

            if (auto_height && new_height < old_height) {
               $contaner.height(new_height);
            }

         }, animation_duration);
      })


      // BACK CLICK
      var back = $scope.find('.mae_slide_menu li.menu-item-back');
      $(back).on('click', function(e){

         e.stopPropagation();
         
         var $cur_ul = $($(this).closest('ul'));
         var $new_ul = $($scope.find('#' + $cur_ul.attr('data-parent-id')));

         $cur_ul.addClass('slide_out_right');
         $new_ul.addClass('slide_in_right opened');

         var old_height = $cur_ul[0].scrollHeight;
         var new_height = $new_ul[0].scrollHeight;


         scrollBarUpdate(new_height);

         if ($scroll_el) {
            $scroll_el.css('overflow-y', 'hidden');
            var top_offset = $scroll_el.scrollTop();
            $new_ul.css('padding-top', top_offset);      
         }

         if (auto_height && new_height > old_height) {
            $contaner.height(new_height);
         }
  
         setTimeout(function(){

            $cur_ul.removeClass('slide_out_right opened');
            $new_ul.removeClass('slide_in_right');

            if ($scroll_el) {
               $scroll_el.css('overflow-y', '');
               $new_ul.css('padding-top', '');
               $scroll_el.scrollTop(0);
               $scrollbar.val(0);
            }

            if (auto_height && new_height < old_height) {
               $contaner.height(new_height);
            }

         }, animation_duration);
      });

      
      // SET CONTAINER HEIGHT (BY HIGEST)
      if ($scope.hasClass('mae-menu-height-by-higest')) {

         var menus = $scope.find('ul');
         var maxHeight = 0; 
         $(menus).css({
            'display': 'flex',
            'visibility': 'hidden',
         });
         $(menus).each(function(){
            
            var $this = $(this);
            if ($this.prop('scrollHeight') > maxHeight) {
               maxHeight = $this.prop('scrollHeight');
            }
         });
         $(menus).removeAttr('style');
         $contaner.height(maxHeight);

      }


      // SET CONTAINER HEIGHT (DEFAULT)
      if ($scope.hasClass('mae-menu-height-default')) {
         $contaner.height($scope.find('ul.menu')[0].scrollHeight).addClass('loaded');
      }


      // SET CONTAINER HEIGHT (AUTO)
      if ($scope.hasClass('mae-menu-height-auto')) {
         auto_height = true;
         $contaner.height($scope.find('ul.menu')[0].scrollHeight).addClass('loaded');
      }


      // CUSTOM SCROLL
      if ($scope.hasClass('mae-menu-scroll-custom')) {

         var scroll_el = $contaner;
         var $scroll_el = $(scroll_el);
         var $scrollbar = $($scope.find('.mae_custom_scrollbar'));

         // update scrollbar position on element scroll
         $scroll_el.on('scroll', function(e){
            if (!$scrollbar.hasClass('disabled')) {
               $scrollbar.val($(this).scrollTop());
            }
         });

         // scroll menu by moving scrollbar
         $scrollbar.on('change mousemove touchmove', function(){
            $scroll_el.scrollTop($(this).val());
         });

         // check scrollbar on load
         var cont_height = $scroll_el.height();
         var main_menu_height = $scope.find('ul.menu')[0].scrollHeight;
         if (main_menu_height > cont_height) {
            scrollBarUpdate(main_menu_height);
         }
         
      }
      function scrollBarUpdate (new_height) {
         if ($scroll_el) {
            var cont_height = $scroll_el.height();
            if (new_height > cont_height) {
               var new_max = new_height - cont_height
               $scrollbar.width(cont_height);
               resetScrollbar(new_max);
               $scrollbar.addClass('mae_scrollbar_visible');
            } else {
               $scrollbar.removeClass('mae_scrollbar_visible');
            }
         }
      }
      function resetScrollbar(new_max) {
         $scrollbar.addClass('disabled');
         // var iteractions = animation_duration / 100;
         var iteractions = 6;
         var val = $scrollbar.val();
         var step = val / iteractions;
         var i = 0;
         var interval = setInterval(function () {
            i++;
            val = val - step;
            $scrollbar.val(val);
            if (i >= iteractions) {
               window.clearInterval(interval);
               $scrollbar.attr('max', new_max);
               $scrollbar.removeClass('disabled');
            }
         }, 20);
      }

   };

	$( window ).on( 'elementor/frontend/init', function() {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_slide_navigation_menu.default', MAESlideMenuHandler );
	} )










   //
   // TAXONOMY SWIPER WIDGET
   //
	var MAETaxonomySwiper = function( $scope, $ ) {

      var el_id = $scope.attr('data-id');
      var received_settings = JSON.parse(window['as_' + el_id + '_settings']); 
      // console.log(received_settings);

      var swiper_container = $scope.find('.swiper-container');
      // console.log(swiper_container);


      var taxonomy_swiper = new Swiper(swiper_container, {
         speed: received_settings.speed,
         slidesPerView: received_settings.slidesPerView,
         slidesPerGroup: received_settings.slidesPerGroup,
         spaceBetween: received_settings.spaceBetween,
         // autoplay: {
         //    delay: 500,
         // },
         observer: true,
         observeParents: true,
         navigation: {
            nextEl: '.taxonomy-swiper-button-next',
            prevEl: '.taxonomy-swiper-button-prev',
         },
         breakpoints: {
            // mobile
            768: {
              slidesPerView: received_settings.slidesPerView_mobile,
              slidesPerGroup: received_settings.slidesPerGroup_mobile,
              spaceBetween: received_settings.spaceBetween_mobile
            },
            // tablet
            1025: {
              slidesPerView: received_settings.slidesPerView_tablet,
              slidesPerGroup: received_settings.slidesPerGroup_tablet,
              spaceBetween: received_settings.spaceBetween_tablet
            },
          },
          handleElementorBreakpoints: true
     });

   };
	$( window ).on( 'elementor/frontend/init', function() {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_taxonomy_swiper.default', MAETaxonomySwiper );
   } );
   













   




















   //
   // SECTION SLIDER
   //
	var MAEPostsSwiperHandler = function( $scope, $ ) {

      var el_id = $scope.attr('data-id');


      // var el_data_settings = JSON.parse($scope.attr('data-settings'));
      // var target_sanitalized = el_data_settings.mae_as_target.replace(/[^a-zA-Z0-9]/g,'');

      // console.log(window['as_' + el_id + target_sanitalized + '_settings']);

      // if(typeof window['as_' + el_id + target_sanitalized + '_settings'] === 'undefined') return false;
      if(typeof window['as_' + el_id + '_settings'] === 'undefined') return false;


      // var received_settings = JSON.parse(window['as_' + el_id + target_sanitalized + '_settings']); 
      var received_settings = JSON.parse(window['as_' + el_id + '_settings']); 



      if (received_settings.element == '' || received_settings.element == '#' || received_settings.element == '.') return false;

      // console.log(received_settings);

      var slider_container = received_settings.element;
	  

      // create or destroy slider
      if(received_settings.enabled == '1') { // create slider



         // SETTINGS
         var settings = { 
            speed: received_settings.speed,
            effect: received_settings.effect,
            centeredSlides: received_settings.centeredSlides,
            centeredSlidesBounds: received_settings.centeredSlidesBounds
         }

         // autoplay
         if (received_settings.autoplay == '1') {
            settings.autoplay = {
               delay: received_settings.autoplay_delay,
               disableOnInteraction: true,
            } 
         }
         // loop
         if (received_settings.loop == '1') {
            settings.loop = true;
         }
         // parallax
         if (received_settings.parallax == '1') {
            settings.parallax = true;
         }       

         settings.init = false;

         // slider
         if (received_settings.front != '1') { // frontend
            // remove old swiper instance
            removeSwiper(slider_container, received_settings.optimized_dom);
         }




         // HTML
         // copy elementor-container 
         if (received_settings.navigation.enabled
            || received_settings.pagination.enabled 
            || received_settings.scrollbar.enabled) {
            var container_classes = $(slider_container + ' > .elementor-widget-container').attr('class');
         }


         // add swiper classes
         $(slider_container + ' > .elementor-widget-container').addClass('swiper-container');
         $(slider_container + ' .elementor-widget-container > .elementor-posts-container').addClass('swiper-wrapper');
         $(slider_container + ' .elementor-widget-container > .elementor-posts-container > article').addClass('swiper-slide');

         


         // NAVIGATION
         if(received_settings.navigation.enabled) {

            $(slider_container).append('<div class="'+container_classes+' mae_as_navigation">'+received_settings.navigation.prev_button+received_settings.navigation.next_button+'</div>');

            settings.navigation = {
               nextEl: slider_container + ' .advanced-swiper-button-next',
               prevEl: slider_container + ' .advanced-swiper-button-prev',
            }

         }


         // PAGINATION
         if(received_settings.pagination.enabled) {

            $(slider_container).append('<div class="'+container_classes+' mae_as_pagination"><div class="mae_as_bullets"></div></div>');

            settings.pagination = {
               el: slider_container + ' .mae_as_pagination .mae_as_bullets',
               clickable: true,
               type: received_settings.pagination.type,
            }

         }


         // SCROLLBAR
         if(received_settings.scrollbar.enabled) {

            $(slider_container).append('<div class="'+container_classes+' mae_as_scrollbar"></div>');

            settings.scrollbar = {
               el: slider_container + ' .mae_as_scrollbar',
               draggable: true,
            }

         }


         // BREAKPOINTS
         if(received_settings.effect == 'slide' || received_settings.effect == 'coverflow') {
            elementorBreakpoints = elementorFrontend.config.breakpoints
            settings.slidesPerView = received_settings.breakpoints.desktop.slidesPerView;
            settings.spaceBetween = received_settings.breakpoints.desktop.spaceBetween;
            settings.handleElementorBreakpoints = true;
            settings.breakpoints = {
               [elementorBreakpoints.lg]: {
                  slidesPerView: received_settings.breakpoints.tablet.slidesPerView,
                  spaceBetween: received_settings.breakpoints.tablet.spaceBetween
               },
               [elementorBreakpoints.md]: {
                  slidesPerView: received_settings.breakpoints.mobile.slidesPerView,
                  spaceBetween: received_settings.breakpoints.mobile.spaceBetween
               }
            }
         }


         // COVERFLOW EFFECT
         if(received_settings.effect == 'coverflow') {
            settings.coverflowEffect = {
               slideShadows: received_settings.coverflow.slideShadows,
            };
         }


         // FADE EFFECT
         if(received_settings.effect == 'fade') {
            settings.fadeEffect = {
               crossFade: received_settings.fade.crossfade,
            };
         }
         
         // INIT IN HIDDEN
         settings.observer = true;
         settings.observeParents = true;
         
         


         // custom settings
         if (received_settings.custom) {
            Object.assign(settings, eval('({' + received_settings.custom + '})'));
         }



         // console.log(settings);
         // init new swiper
         var swiper_selector = $(slider_container + ' .swiper-container')[0]; // target only first founded elements to avoid conflicts (elementor sticky header fix)
         //console.log(swiper_selector);
         SectionSwiper = new Swiper(swiper_selector, settings,);


		 
         // setupSliderBreakpoints(received_settings.breakpoints);
         SectionSwiper.on('init', function() { 
            $(slider_container).css({'opacity':'1','transition':'opacity 50ms'});
         });
         SectionSwiper.init();

         // elementor animation fix
         SectionSwiper.on('transitionStart', function(e) { 
            $(slider_container + ' .elementor-invisible').css('visibility','visible');
         });

         // stop autoplay on hover
         if(received_settings.pause_on_hover == '1') {
            SectionSwiper.el.addEventListener("mouseenter", function( event ) {   
               SectionSwiper.autoplay.stop();
            }, false);
            SectionSwiper.el.addEventListener("mouseleave", function( event ) {   
               SectionSwiper.autoplay.start();
            }, false);
         }
         if(received_settings.autoplay) {
            // autoplay after resize
            $(window).resize(function(e){
               SectionSwiper.autoplay.start();
               // setupSliderBreakpoints(received_settings.breakpoints);
            });
         }


      } else { // remove slider
         // console.log('remove');
         // console.log(slider_container);
         if(slider_container) {
            removeSwiper(slider_container, received_settings.optimized_dom);
         }

      }


      // function to completely remove swiper slider form section
      function removeSwiper (el, optimized_dom) {

         // console.log('remove');

         // remove arrows container
         $(el + ' .mae_as_navigation').remove();
         $(el + ' .mae_as_pagination').remove();
         $(el + ' .mae_as_scrollbar').remove();
         

         // check is swiper container present
         var prevSectionSlider = $(el + ' .swiper-container');
         if (prevSectionSlider.length) {

            // get element swiper data
            var swiperInstance = prevSectionSlider[0].swiper;

            // if element has swiper instance
            if(swiperInstance) {

               // destroy swiper instance
               swiperInstance.destroy();

               // remove swiper classes
               // get all elements with `swiper` in class name
               var $el_with_swiper_classes = $(el + " [class*=swiper]");

               // loop through elements to remome `swiper` classes 
               $.each($el_with_swiper_classes, function() {
                  var $current_el_with_swiper_class = $(this);
                  var current_element_class_list = $(this).attr("class");  
                  current_element_class_list = current_element_class_list.split(/ +/);
                  $.each(current_element_class_list, function(key, value) {
                     var current_swiper_class = value;
                     if (current_swiper_class.indexOf("swiper") !== -1) {
                        $current_el_with_swiper_class.removeClass(current_swiper_class);
                     }
                  });
               });

               // unwrap if legasy DOM
               if (!optimized_dom) {
                  $(el + ' > .elementor-container > .elementor-row').contents().unwrap();
                  $(el).removeClass('as_legacy_dom');
               }

            }

         }   

      }



   };
	$( window ).on( 'elementor/frontend/init', function() {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_posts_swiper.default', MAEPostsSwiperHandler );
   } );





















   class MAEMiniCart extends elementorModules.frontend.handlers.Base {

      getDefaultSettings() {
         return {
            selectors: {
               removeItemBtn: '.elementor-menu-cart__product-remove.product-remove a'
            },
         };
      }

      bindEvents() {
         this.$element.on('click', this.getSettings('selectors').removeItemBtn, this.removeProductFromCart.bind(this));
      }
      
      onInit() {
         super.onInit();
      }

      removeProductFromCart(e) {
         e.preventDefault();
         var $this = $(e.target);
         var product_id = $this.attr("data-product_id"),
            cart_item_key = $this.attr("data-cart_item_key"),
            product_container = $this.parents('.elementor-menu-cart__product');
         product_container.css({
            'pointer-events': 'none',
            'opacity': '0.3'
         });
         $.ajax({
            type: 'POST',
            dataType: 'json',
            url: mae_ajax.ajax_url,
            data: {
               action: "mae_minicart_product_remove",
               product_id: product_id,
               cart_item_key: cart_item_key
            },
            success: function(response) {
               if (!response || response.error) {
                  return;
               }
               var fragments = response.fragments;
               if (fragments) {
                  $.each(fragments, function(key, value) {
                     $(key).replaceWith(value);
                  });
               }
               $('.add_to_cart_button.added[data-product_id="'+product_id+'"]').removeClass('added');
            }
         });
      }

   }
   $( window ).on( 'elementor/frontend/init', () => {
      const addHandler = ( $element ) => {
        elementorFrontend.elementsHandler.addHandler( MAEMiniCart, {
          $element,
        } );
      };
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_minicart.default', addHandler );
   } );











   class MAETemplatePopup extends elementorModules.frontend.handlers.Base {

      getDefaultSettings() {
         return {
            selectors: {
               toggle: '.mae-toggle-button',
               content: '.mae-toggle-content',
            },
         };
      }

      getDefaultElements() {
         var selectors = this.getSettings( 'selectors' );
         return {
            $toggle: this.$element.find( selectors.toggle ).first(),
            $content: this.$element.find( selectors.content ).first(),
         };
      }

      bindEvents() {
         this.elements.$toggle.on('click', this.toggleClick.bind(this));
         // this.$element.on('mouseenter', this.mouseIn.bind(this));
         // this.$element.on('mouseleave', this.mouseOut.bind(this));
         $(window).on('resize', this.windowResize.bind(this));
      }

      toggleClick(e) {
         if(this.elements.$toggle.hasClass('active')) {
            this.hideContent();
         } else {
            this.elements.$content.show();
            this.showContent();
         }
      }

      // mouseIn(e) {
      //    this.elements.$content.show();
      //    this.showContent();
      // }

      // mouseOut(e) {
      //    var self = this;
      //    setTimeout(function () {
      //       self.hideContent();
      //    }, 300);
      // }

      documentClick(e) {
         if (!this.$element.is(e.target) && this.$element.has(e.target).length === 0) {
            this.hideContent();
         }
      }

      showContent() {
         this.elements.$toggle.addClass('active');
         this.elements.$content.addClass('active');
         this.setContentWidth();

         $(document).on('click.'+this.getID(), this.documentClick.bind(this));

         this.elements.$content.trigger('mae_content_visible'); // add event for elements inside
      }

      windowResize() {
         if(this.elements.$content.hasClass('active')) {
            this.setContentWidth();
            this.check_bounding();
         }
      }

      hideContent() {
         this.elements.$toggle.removeClass('active');
         this.elements.$content.removeClass('active');
         $(document).off('click.'+this.getID());
         this.elements.$content.trigger('mae_content_hidden'); // add event for elements inside

      }

      onInit() {
         super.onInit();
         if(this.isEdit) {
            this.addEditHandler();
         }
         this.elements.$content.find('img[loading="lazy"]').removeAttr('loading');
      }

      setContentWidth() {

         var type = this.getElementSettings('content_width_type');
         var window_width = $(window).width();
         var breakpoint = this.getElementSettings('fullwidth_on');

         if(breakpoint && window_width <= breakpoint) {
            var container = $('body');
            this.elements.$content.addClass('fullwidth-breakpoint');
         } else {            
            // clear styles
            this.elements.$content.css({
               'left': '',
               'width': ''
            });

            this.elements.$content.removeClass('fullwidth-breakpoint');

            switch (type) {
               case 'full':
                  var container = $('body');
                  break;
               case 'section':
                  var container = this.$element.closest('section').children('.elementor-container');
                  break;
               case 'column':
                  var container = this.$element.closest('.elementor-column');
                  break;
               case 'custom':
                  return;
               default:
                  return;
            }
         }



         var toggle_left = this.elements.$toggle.offset().left;
         var container_left = $(container).offset().left;
         var left = toggle_left - container_left;
         var container_width = $(container).width();

         console.log(container_width);

         // set styles
         this.elements.$content.css({
            'left': - left,
            'width': container_width
         });

      }

      check_bounding() {
         var bounding = this.elements.$content[0].getBoundingClientRect();
         
         // console.log(bounding);
         var overflow_right = (window.innerWidth || document.documentElement.clientWidth) - bounding.right;

         if(overflow_right < 0) {
            this.elements.$content.width(bounding.width - Math.abs(overflow_right));
         } else {
            // this.elements.$content.css({'width': ''});
         }
         


      }

      addEditHandler() {
         var elementor_document = this.findElement('.elementor').prepend('<div class="elementor-document-handle" style="z-index: 999999;"><i class="eicon-edit"></i>Edit template</div>');
         this.findElement('.elementor-document-handle').on('click', function() {
            window.elementorCommon.api.internal( 'panel/state-loading' );
            window.elementorCommon.api.run( 'editor/documents/switch', {
               id: elementor_document.attr('data-elementor-id')
            }).then( function() {
               return window.elementorCommon.api.internal( 'panel/state-ready' );
            });
         })
      }

   }
   $( window ).on( 'elementor/frontend/init', () => {
      const addHandler = ( $element ) => {
        elementorFrontend.elementsHandler.addHandler( MAETemplatePopup, {
          $element,
        } );
      };
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_template_popup.default', addHandler );
      // elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_lang_dropdown.default', addHandler );

   } );




})(jQuery);

























