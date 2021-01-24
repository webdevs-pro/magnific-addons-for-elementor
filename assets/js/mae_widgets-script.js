
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

      var el_id = $scope.attr('data-id');

      // console.log(window['snm_' + el_id + '_settings']);

      if(typeof window['snm_' + el_id + '_settings'] === 'undefined') return false;

      var settings = JSON.parse(window['snm_' + el_id + '_settings']);

      var menu = settings.menu;

      var swiper_selector = '#' + settings.menu_id;

      // console.log(settings);



      

      var settings = {
         slides_per_view: 1,
         autoHeight: true,
         speed: 300,
         pagination: {
            el: '.swiper-pagination',
            type: 'bullets',
         },
      }

      var MenuSwiper = new Swiper(swiper_selector, settings);



      $('.menu-item-has-children').on('click', function(e) {
         e.preventDefault();
         if(MenuSwiper.animating) return false;
         var sub_menu_id = $(this).attr('data-sub-menu-id');
         var sub_menu_content = '<div class="swiper-slide">' + menu[sub_menu_id] + '</div>';
         MenuSwiper.appendSlide(sub_menu_content);
         MenuSwiper.slideNext();
      });

      $('.menu-back-button').on('click', function(e) {
         e.preventDefault();
         if(MenuSwiper.animating) return false;
         MenuSwiper.slidePrev();
      });

      MenuSwiper.on('slidePrevTransitionEnd', function() {
         MenuSwiper.removeSlide(MenuSwiper.previousIndex);
      });

   };

	$( window ).on( 'elementor/frontend/init', function() {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_slide_navigation_menu.default', MAESlideMenuHandler );
	} )





   

   //
   // SECTION SLIDER
   //
	var MAEAdvancedSwiperHandler = function( $scope, $ ) {


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
            var container_classes = $(slider_container + ' > .elementor-container').attr('class');
         }
         if (received_settings.optimized_dom) { // elementor DOM optimized 

            // add swiper classes
            $(slider_container + ' > .elementor-container').addClass('swiper-container');
            $(slider_container + ' .swiper-container > .elementor-row').addClass('swiper-wrapper');
            $(slider_container + ' .swiper-container > .elementor-row > .elementor-column').addClass('swiper-slide');

         } else { // elementor DOM legacy mode 

            $(slider_container).addClass('as_legacy_dom');

            // add swiper classes
            $(slider_container + ' > .elementor-container').addClass('swiper-container');
            $(slider_container + ' > .elementor-container').wrapInner('<div class="elementor-row"></div>');
            $(slider_container + ' .swiper-container > .elementor-row').addClass('swiper-wrapper');
            $(slider_container + ' .swiper-container > .elementor-row > .elementor-column').addClass('swiper-slide');

         }


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
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_advanced_swiper.default', MAEAdvancedSwiperHandler );
   } );







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















/*

   //
   // POPUP TEMPLATE
   //
	var MAETemplatePopup = function( $scope, $ ) {


   
      
      var el_id = $scope.attr('data-id');
      
      if(typeof window['pm_' + el_id + '_settings'] === 'undefined') return false;
      
      var settings = JSON.parse(window['pm_' + el_id + '_settings']);
      
      var $toggle = $($scope.find('.mae-toggle-button'));
      var $content = $($scope.find('.mae-toggle-content'));
      
      if(settings.is_editor) {
         addEditingHandler();
      }
      
      // console.log(settings);

      // prevent images lazy load in content
      $content.find('img[loading="lazy"]').removeAttr('loading');
      

      $(document).click(function(e) {
         if (!$scope.is(e.target) && $scope.has(e.target).length === 0) {
            hideContent();
         }
      });

      $toggle.off('click'); // fix for editor
      $toggle.on('click', function(e) {
         
         $this = $(this);

         if($this.hasClass('active')) {
            hideContent();
         } else {
            $(document).trigger('click');
            $content.show();
            showContent();
         }

      });
      

      
      $(window).on('resize', function(){
         if($content.hasClass('active') && settings.width_type == 'full') {
            setFullWidth();
         }
      });



      function setFullWidth() {
         $content.css({
            'left': '',
            'width': ''
         });
         var content_offset_left = $content.offset().left;
         var window_width = $(window).width();
         $content.css({
            'left': -content_offset_left,
            'width': window_width
         });
      }

      function showContent() {
         $toggle.addClass('active');
         $content.addClass('active');
         if(settings.width_type == 'full') {
            setFullWidth();
         }
      }

      function hideContent() {
         $toggle.removeClass('active');
         $content.removeClass('active');
      }

      function addEditingHandler() {
         var elementor_document = $scope.find('.elementor');
         var document_id = elementor_document.attr('data-elementor-id');
         elementor_document.prepend('<div class="elementor-document-handle" style="z-index: 999999;"><i class="eicon-edit"></i>Edit template</div>');
   
         $scope.on('click', '.elementor-document-handle', function(){
            window.elementorCommon.api.internal( 'panel/state-loading' );
            window.elementorCommon.api.run( 'editor/documents/switch', {
               id: document_id
            } ).then( function() {
               return window.elementorCommon.api.internal( 'panel/state-ready' );
            } );
         })
      }

   };

	$( window ).on( 'elementor/frontend/init', function() {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_template_popup.default', MAETemplatePopup );
   } )
   
*/







/*

   //
   // CART DROPDOWN
   //
	var MAECartDropdown = function( $scope, $ ) {

      var el_id = $scope.attr('data-id');

      if(typeof window['cd_' + el_id + '_settings'] === 'undefined') return false;

      var settings = JSON.parse(window['cd_' + el_id + '_settings']);


      var $toggle = $($scope.find('.mae-toggle-button'));
      var $content = $($scope.find('.mae-toggle-content'));

      // console.log(settings);

      // prevent images lazy load in content
      $content.find('img[loading="lazy"]').removeAttr('loading');


      $(document).click(function(e) {
         if (!$scope.is(e.target) && $scope.has(e.target).length === 0) {
            hideContent();
         }
      });


      $toggle.off('click'); // fix for editor
      $toggle.on('click', function(e) {

         $this = $(this);

         if($this.hasClass('active')) {
            hideContent();
         } else {
            $(document).trigger('click');
            $content.show();
            showContent();
         }

      });
      



      $(window).on('resize', function(){
         if($content.hasClass('active') && settings.width_type == 'full') {
            setFullWidth();
         }
      });




      // Ajax delete product in the cart
      $scope.on('click', '.elementor-menu-cart__product-remove.product-remove a', function (e) {
         e.preventDefault();

         var product_id = $(this).attr("data-product_id"),
            cart_item_key = $(this).attr("data-cart_item_key"),
            product_container = $(this).parents('.elementor-menu-cart__product');

         product_container.css({
            'pointer-events': 'none',
            'opacity': '0.3'
         });

         $.ajax({
            type: 'POST',
            dataType: 'json',
            url: mae_ajax.ajax_url,
            data: {
                  action: "mae_cart_dropdown_product_remove",
                  product_id: product_id,
                  cart_item_key: cart_item_key
            },
            success: function(response) {
                  if ( ! response || response.error )
                     return;

                  var fragments = response.fragments;

                  // Replace fragments
                  if ( fragments ) {
                     $.each( fragments, function( key, value ) {
                        $( key ).replaceWith( value );
                     });
                  }

                  $('.add_to_cart_button.added[data-product_id="'+product_id+'"]').removeClass('added');

            }
         });
      });





      function showContent() {
         $toggle.addClass('active');
         $content.addClass('active');
         if(settings.width_type == 'full') {
            setFullWidth();
         }
      }

      function hideContent() {
         $toggle.removeClass('active');
         $content.removeClass('active');
      }

      function setFullWidth() {
         $content.css({
            'left': '',
            'width': ''
         });
         var content_offset_left = $content.offset().left;
         var window_width = $(window).width();
         $content.css({
            'left': -content_offset_left,
            'width': window_width
         });
      }

   };

	$( window ).on( 'elementor/frontend/init', function() {
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_cart_dropdown.default', MAECartDropdown );
   } )

*/







   class MAECartDropdown extends elementorModules.frontend.handlers.Base {

      getDefaultSettings() {
         return {
            selectors: {
               toggle: '.mae-toggle-button',
               content: '.mae-toggle-content',
               removeItemBtn: '.elementor-menu-cart__product-remove.product-remove a'
            },
         };
      }

      getDefaultElements() {
         var selectors = this.getSettings('selectors');
         return {
            $toggle: this.$element.find( selectors.toggle ),
            $content: this.$element.find( selectors.content ),
         };
      }

      bindEvents() {
         this.elements.$toggle.on('click', this.toggleClick.bind(this));
         this.$element.on('click', this.getSettings('selectors').removeItemBtn, this.removeProductFromCart.bind(this)),
         // $(document).on('click', this.documentClick.bind(this));
         $(window).on('resize', this.windowResize.bind(this));
      }

      toggleClick() {
         if(this.elements.$toggle.hasClass('active')) {
            this.hideContent();
         } else {
            this.elements.$content.show();
            this.showContent();
         }
      }

      documentClick(e) {
         if (!this.$element.is(e.target) && this.$element.has(e.target).length === 0) {
            this.hideContent();
         }
      }

      showContent() {
         this.elements.$toggle.addClass('active');
         this.elements.$content.addClass('active');
         if(this.getElementSettings('content_width_type') == 'full') {
            this.makeContentFullwidth();
         }
         $(document).on('click.'+this.getID(), this.documentClick.bind(this));
      }

      windowResize() {
         if(this.getElementSettings('content_width_type') == 'full' && this.elements.$content.hasClass('active')) {
            this.makeContentFullwidth();
         }
      }

      hideContent() {
         this.elements.$toggle.removeClass('active');
         this.elements.$content.removeClass('active');
         $(document).off('click.'+this.getID());
      }

      onInit() {
         super.onInit();
         this.elements.$content.find('img[loading="lazy"]').removeAttr('loading');
      }

      makeContentFullwidth() {
         this.elements.$content.css({
            'left': '',
            'width': ''
         });
         this.elements.$content.css({
            'left': - this.elements.$content.offset().left,
            'width': $(window).width()
         });
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
               action: "mae_cart_dropdown_product_remove",
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
        elementorFrontend.elementsHandler.addHandler( MAECartDropdown, {
          $element,
        } );
      };
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_cart_dropdown.default', addHandler );
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
      }

      windowResize() {
         if(this.elements.$content.hasClass('active')) {
            this.setContentWidth();
         }
      }

      hideContent() {
         this.elements.$toggle.removeClass('active');
         this.elements.$content.removeClass('active');
         $(document).off('click.'+this.getID());
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
            case 'selector':
               var selector = this.getElementSettings('content_width_selector');
               var container = $(selector);
               break;
            default:
               return;
         }

         // clear styles
         this.elements.$content.css({
            'left': '',
            'width': ''
         });

         var toggle_left = this.elements.$toggle.offset().left;
         var container_left = $(container).offset().left;
         var left = toggle_left - container_left;

         // set styles
         this.elements.$content.css({
            'left': - left,
            'width': $(container).width()
         });

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
      elementorFrontend.hooks.addAction( 'frontend/element_ready/mae_lang_dropdown.default', addHandler );

   } );




})(jQuery);

























