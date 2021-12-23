(function($) {
	
	"use strict";
	
	//Hide Loading Box (Preloader)
	function handlePreloader() {
		if($('.preloader').length){
			$('.preloader').delay(200).fadeOut(500);
		}
	}
	
	//Update Header Style and Scroll to Top
	function headerStyle() {
		if($('.main-header').length){
			var windowpos = $(window).scrollTop();
			var siteHeader = $('.main-header');
			var scrollLink = $('.scroll-top');
			if (windowpos >= 110) {
				siteHeader.addClass('fixed-header');
				scrollLink.addClass('open');
			} else {
				siteHeader.removeClass('fixed-header');
				scrollLink.removeClass('open');
			}
		}
	}
	
	headerStyle();


	//Submenu Dropdown Toggle
	if($('.main-header li.dropdown ul').length){
		$('.main-header .navigation li.dropdown').append('<div class="dropdown-btn"><span class="fas fa-angle-down"></span></div>');
		
	}

	//Mobile Nav Hide Show
	if($('.mobile-menu').length){
		
		$('.mobile-menu .menu-box').mCustomScrollbar();
		
		var mobileMenuContent = $('.main-header .menu-area .main-menu').html();
		$('.mobile-menu .menu-box .menu-outer').append(mobileMenuContent);
		$('.sticky-header .main-menu').append(mobileMenuContent);
		
		//Dropdown Button
		$('.mobile-menu li.dropdown .dropdown-btn').on('click', function() {
			$(this).toggleClass('open');
			$(this).prev('ul').slideToggle(500);
		});
		//Dropdown Button
		$('.mobile-menu li.dropdown .dropdown-btn').on('click', function() {
			$(this).prev('.megamenu').slideToggle(900);
		});
		//Menu Toggle Btn
		$('.mobile-nav-toggler').on('click', function() {
			$('body').addClass('mobile-menu-visible');
		});

		//Menu Toggle Btn
		$('.mobile-menu .menu-backdrop,.mobile-menu .close-btn').on('click', function() {
			$('body').removeClass('mobile-menu-visible');
		});
	}


	// Scroll to a Specific Div
	if($('.scroll-to-target').length){
		$(".scroll-to-target").on('click', function() {
			var target = $(this).attr('data-target');
		   // animate
		   $('html, body').animate({
			   scrollTop: $(target).offset().top
			 }, 1000);
	
		});
	}

	// Elements Animation
	if($('.wow').length){
		var wow = new WOW({
		mobile:       false
		});
		wow.init();
	}

	//Contact Form Validation
	if($('#contact-form').length){
		$('#contact-form').validate({
			rules: {
				username: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				phone: {
					required: true
				},
				subject: {
					required: true
				},
				message: {
					required: true
				}
			}
		});
	}

	//Fact Counter + Text Count
	if($('.count-box').length){
		$('.count-box').appear(function(){
	
			var $t = $(this),
				n = $t.find(".count-text").attr("data-stop"),
				r = parseInt($t.find(".count-text").attr("data-speed"), 10);
				
			if (!$t.hasClass("counted")) {
				$t.addClass("counted");
				$({
					countNum: $t.find(".count-text").text()
				}).animate({
					countNum: n
				}, {
					duration: r,
					easing: "linear",
					step: function() {
						$t.find(".count-text").text(Math.floor(this.countNum));
					},
					complete: function() {
						$t.find(".count-text").text(this.countNum);
					}
				});
			}
			
		},{accY: 0});
	}


	//LightBox / Fancybox
	if($('.lightbox-image').length) {
		$('.lightbox-image').fancybox({
			openEffect  : 'fade',
			closeEffect : 'fade',
			helpers : {
				media : {}
			}
		});
	}


	//Tabs Box
	if($('.tabs-box').length){
		$('.tabs-box .tab-buttons .tab-btn').on('click', function(e) {
			e.preventDefault();
			var target = $($(this).attr('data-tab'));
			
			if ($(target).is(':visible')){
				return false;
			}else{
				target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
				$(this).addClass('active-btn');
				target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
				target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab');
				$(target).fadeIn(300);
				$(target).addClass('active-tab');
			}
		});
	}



	//Accordion Box
	if($('.accordion-box').length){
		$(".accordion-box").on('click', '.acc-btn', function() {
			
			/*var outerBox = $(this).parents('.accordion-box');
			var target = $(this).parents('.accordion');
			
			if($(this).hasClass('active')!==true){
				$(outerBox).find('.accordion .acc-btn').removeClass('active');
			}
			
			if ($(this).next('.acc-content').is(':visible')){
				return false;
			}else{
				$(this).addClass('active');
				$(outerBox).children('.accordion').removeClass('active-block');
				$(outerBox).find('.accordion').children('.acc-content').slideUp(300);
				target.addClass('active-block');
				$(this).next('.acc-content').slideDown(300);	
			}*/

			$('.acc-content').slideUp(300);
			$('.accordion').removeClass('active-block');
			$(".accordion-box").find('.acc-btn').removeClass('active');
			$(this).parents('.accordion').find('.acc-content').stop().slideToggle(300);
			$(this).parents('.accordion').addClass('active-block');
			if($(this).hasClass('active') !==true){
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
			
		});	
	}


    //three-item-carousel
	if ($('.three-item-carousel').length) {
		$('.three-item-carousel').owlCarousel({
			loop:true,
			margin:30,
			nav:true,
			smartSpeed: 1000,
			autoplay: 500,
			navText: [ '<span class="flaticon-left-2"></span>', '<span class="flaticon-right-1"></span>' ],
			responsive:{
				0:{
					items:1
				},
				480:{
					items:1
				},
				600:{
					items:2
				},
				800:{
					items:2
				},
				1024:{
					items:3
				}
			}
		});    		
	}


	// Four Item Carousel
	if ($('.four-item-carousel').length) {
		$('.four-item-carousel').owlCarousel({
			loop:true,
			margin:30,
			nav:true,
			smartSpeed: 500,
			autoplay: 5000,
			navText: [ '<span class="fas fa-angle-left"></span>', '<span class="fas fa-angle-right"></span>' ],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				800:{
					items:2
				},
				1024:{
					items:3
				},
				1200:{
					items:4
				}
			}
		});    		
	}

	// Gallery Carousel
	if ($('.gallery-carousel').length) {
		$('.gallery-carousel').owlCarousel({
			loop:true,
			margin:6,
			nav:true,
			smartSpeed: 500,
			autoplay: 5000,
			navText: [ '<span class="fas fa-angle-left"></span>', '<span class="fas fa-angle-right"></span>' ],
			responsive:{
				0:{
					items:1
				},
				600:{
					items:2
				},
				800:{
					items:3
				},
				1024:{
					items:3
				},
				1200:{
					items:4
				}
			}
		});    		
	}


	// single-item-carousel
	if ($('.single-item-carousel').length) {
		$('.single-item-carousel').owlCarousel({
			loop:true,
			margin:30,
			nav:false,
			smartSpeed: 3000,
			autoplay: true,
			navText: [ '<span class="icon-Arrow-Left"></span>', '<span class="icon-Arrow-Right"></span>' ],
			responsive:{
				0:{
					items:1
				},
				480:{
					items:1
				},
				600:{
					items:1
				},
				800:{
					items:1
				},			
				1200:{
					items:1
				}

			}
		});    		
	}


	// clients-carousel
	if ($('.clients-carousel').length) {
		$('.clients-carousel').owlCarousel({
			loop:true,
			margin:30,
			nav:false,
			smartSpeed: 3000,
			autoplay: true,
			navText: [ '<span class="fas fa-angle-left"></span>', '<span class="fas fa-angle-right"></span>' ],
			responsive:{
				0:{
					items:1
				},
				480:{
					items:2
				},
				600:{
					items:3
				},
				800:{
					items:4
				},			
				1200:{
					items:6
				}

			}
		});    		
	}


	//Add One Page nav
	if($('.scroll-nav').length) {
		$('.scroll-nav').onePageNav();
	}


	//Sortable Masonary with Filters
	function enableMasonry() {
		if($('.sortable-masonry').length){
	
			var winDow = $(window);
			// Needed variables
			var $container=$('.sortable-masonry .items-container');
			var $filter=$('.filter-btns');
	
			$container.isotope({
				filter:'*',
				 masonry: {
					columnWidth : '.masonry-item.small-column'
				 },
				animationOptions:{
					duration:500,
					easing:'linear'
				}
			});
			
	
			// Isotope Filter 
			$filter.find('li').on('click', function(){
				var selector = $(this).attr('data-filter');
	
				try {
					$container.isotope({ 
						filter	: selector,
						animationOptions: {
							duration: 500,
							easing	: 'linear',
							queue	: false
						}
					});
				} catch(err) {
	
				}
				return false;
			});
	
	
			winDow.on('resize', function(){
				var selector = $filter.find('li.active').attr('data-filter');

				$container.isotope({ 
					filter	: selector,
					animationOptions: {
						duration: 500,
						easing	: 'linear',
						queue	: false
					}
				});
			});
	
	
			var filterItemA	= $('.filter-btns li');
	
			filterItemA.on('click', function(){
				var $this = $(this);
				if ( !$this.hasClass('active')) {
					filterItemA.removeClass('active');
					$this.addClass('active');
				}
			});
		}
	}
	
	enableMasonry();


    // Progress Bar
	if ($('.count-bar').length) {
		$('.count-bar').appear(function(){
			var el = $(this);
			var percent = el.data('percent');
			$(el).css('width',percent).addClass('counted');
		},{accY: -50});

	}


	// page direction
	function directionswitch() {
	  	if ($('.page_direction').length) {

	    	$('.direction_switch button').on('click', function() {
			   $('body').toggleClass(function(){
			      return $(this).is('.rtl, .ltr') ? 'rtl ltr' : 'rtl';
			  })
			});
	  	};
	}


	function onHoverthreeDmovement() {
	    var tiltBlock = $('.js-tilt');
	    if(tiltBlock.length) {
	        $('.js-tilt').tilt({
	            maxTilt: 20,
	            perspective:5000, 
	            glare: true,
	            maxGlare: 0
	        })
	    }
	}


	if($('.paroller').length){
		$('.paroller').paroller({
			  factor: 0.1,            // multiplier for scrolling speed and offset, +- values for direction control  
			  factorLg: 0.1,          // multiplier for scrolling speed and offset if window width is less than 1200px, +- values for direction control  
			  type: 'foreground',     // background, foreground  
			  direction: 'vertical' // vertical, horizontal  
		});
	}

	if($('.paroller-2').length){
		$('.paroller-2').paroller({
			  factor: -0.1,            // multiplier for scrolling speed and offset, +- values for direction control  
			  factorLg: -0.1,          // multiplier for scrolling speed and offset if window width is less than 1200px, +- values for direction control  
			  type: 'foreground',     // background, foreground  
			  direction: 'vertical' // vertical, horizontal  
		});
	}


	$(document).ready(function() {
      $('select:not(.ignore)').niceSelect();
    });

    // Date picker
	function datepicker () {
	    if ($('#datepicker').length) {
	        $('#datepicker').datepicker();
	    };
	}



	// Time picker
	function timepicker () {
	    if ($('input[name="time"]').length) {
	        $('input[name="time"]').ptTimeSelect();
	    }
	}


	//Appointment Calendar
	if($('#appoinment_calendar').length) {
		$('#appoinment_calendar').monthly();
	}


	/*	=========================================================================
	When document is Scrollig, do
	========================================================================== */

	jQuery(document).on('ready', function () {
		(function ($) {
			// add your functions
			directionswitch();
			onHoverthreeDmovement();
			datepicker ();
			timepicker ();
		})(jQuery);
	});



	/* ==========================================================================
   When document is Scrollig, do
   ========================================================================== */
	
	$(window).on('scroll', function() {
		headerStyle();
	});

	
	
	/* ==========================================================================
   When document is loaded, do
   ========================================================================== */
	
	$(window).on('load', function() {
		handlePreloader()
		enableMasonry();
	});

	

})(window.jQuery);

/* my scripts*/

function copyToClipboard(text) {

var textArea = document.createElement( "textarea" );
textArea.value = text;
document.body.appendChild( textArea );

textArea.select();

try {
    var successful = document.execCommand( 'copy' );
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
} catch (err) {
    console.log('Oops, unable to copy');
}

document.body.removeChild( textArea );
}
    $(document).on('click','.copy_text', function(){
    var t = $(this);
    t.html('<i class="fas fa-check"></i>').addClass('copied');
    copyToClipboard(t.parent().children('p').text());
    setTimeout(function(){
        t.html('<i class="far fa-clone"></i>').removeClass('copied');
    },1000);
});

$(document).on('click','.link_copy', function(){
    var t = $(this);
    
    copyToClipboard(t.parent().children('p').text());
   alert('link copied');
});

$(document).ready(function () {
	$(".address_tabs li  a").on("click", function (e) {
		var currentNewsValue = $(this).attr("href");

		$(".address_tab").hide();
		$(currentNewsValue).fadeIn(500);

		$(this).parent().addClass("active").siblings().removeClass("active");
		e.preventDefault();
	});
});
$(document).ready(function(){
    $('.choose_package_drop_open').click(function(){
        $(this).parent('.choose_package_dropdown ').find('.choose_package_drop').toggleClass('opened');
        $(this).toggleClass('opened_button');
    });

});

function checkEmail(str) {

    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(str.val())) {

        str.val('');
        str.focus();
        return false;
    }
};

function alert_fun(message, klass='error', redirect=false) {
    swal({
        title: message,
        text: '',
        icon: klass,
        button: 'BaÄŸla',

    }).then(function(){

        if(redirect){
            window.location.href=redirect;
        }

    });
};

if($(window).width() < 991){
	$('.user_name_drop>a').click(function(e){
		e.preventDefault();
	});
}

$('.active_lang').click(function(e){
	e.preventDefault();
});


$('.banner-section .owl-carousel').owlCarousel({
    loop:true,
    margin:0,
	nav:false,
	dots:false,
	autoplay:true,
	autoplayTimeout:4000,
	autoplaySpeed:1000,
    responsive:{
        0:{
			items:1,
			nav:false,
			dots:false,
        },
        600:{
			items:1,
			nav:false,
			dots:false,
        },
        1000:{
			items:1,
			autoplay:true,
			autoplayTimeout:3000
        }
    }
});

function calcPrice() {
	var formData = $("#calc_form").serialize();
	var route = $("#calc_form").data('route');
	$.get(route, formData, function (data) {
		$(".calc_price").text(data);
	});
}


$(document).ready(function(){

	$('#calc_form select').on('change', calcPrice);
	$('#calc_form input').on('keyup paste', calcPrice);

	$("form:not(.no_loading)").on('submit', function () {
		$("#preloader").show();
	});


	$(document).ready(function () {

		var _passport = $("#passport");
		var _passport_profix = $("#passport_prefix");

		changeMask();

		_passport_profix.on('change', function () {
			changeMask();
		});

		function changeMask() {
			var valueSelected = _passport_profix.val();

			if ('AA' == valueSelected) {
				_passport.inputmask("9999999");
				_passport.attr('placeholder', "1234567");
			} else {
				_passport.inputmask("99999999");
				_passport.attr('placeholder', "12345678");
			}
		}
	});

	$(document).ready(function () {
		$('[data-popup="popovery_img"]').popover({
			html: true,
			trigger: 'focus',
			content: function () {
				return '<img src="' + $(this).data('img') + '" />';
			}
		});
		var _district = $("#district");
		$("#city").change(function () {
			var selectedItem = $(this).val();
			var routeDistrict = $(this).data('route');

			$(function () {
				$.ajax({
					url: routeDistrict,
					type: 'get',
					data: {city_id: selectedItem},
					success: function (data) {
						options = "";
						data.forEach(function (entry) {
							options += "<option value='" + entry.id + "'>" + entry.name + "</option>";
						});

						_district.parent().find(".nice-select").remove();
						_district.html(options);
						_district.niceSelect();
					}
				});
			});
		});

		$(document).on('input', '.order_price, .order_kargo_fee', function () {
			$(this).val($(this).val().replace(/,/g, '.'));
		});

		$(document).on('click', '.add_order', function () {
			count = 1;
			var cloned = $(".added_order_row:first-child").clone();
			html = '<div class="row order_box added_order_row"> ' + cloned.html() + ' </div>';

			$('#container-url').append(html);
			let hesterx = document.getElementsByClassName('count-item__count');
			for (var i = 0; i < hesterx.length; i++) {
				hesterx[i].innerHTML = (i < 9 ? '0' : '') + (i + 1);
				$(".order_box:nth-child(" + (i + 1) + ") ").attr("data-id", i);
			}

			$(".order_box").each(function (i) {
				$(this).find("input").each(function (j) {
					var key = $(this).data('key');
					$(this).attr('name', "url[" + i + "][" + key +"]");
					console.log(i + " :: " + key);
				});
			});
		});

		$(document).on('click', '.delete_order', function () {
			$(this).parents('.added_order_row').remove();
			let hesterx = document.getElementsByClassName('count-item__count');
			for (var i = 0; i < hesterx.length; i++) {
				hesterx[i].innerHTML = (i < 9 ? '0' : '') + (i + 1);
				$(".order_box:nth-child(" + (i + 1) + ") ").attr("data-id", i);
			}
			$(".order_box").each(function (i) {
				$(this).find("input").each(function (j) {
					var key = $(this).data('key');
					$(this).attr('name', "url[" + i + "][" + key +"]");
					console.log(i + " :: " + key);
				});
			});
		});
	});


	$(document).ready(function () {

		$(document).bind('input', '.order_price, .order_amount, .order_kargo_fee', function () {
			calculatePrice();
		});

		function calculatePrice() {
			var sum = 0;

			$('.order_price').each(function () {
				$this_price = parseFloat($(this).parents('.order_box').find('.order_price').val().replace(',', '.'));
				$this_amount = parseInt($(this).parents('.order_box').find('.order_amount').val());
				$this_kargo = parseFloat($(this).parents('.order_box').find('.order_kargo_fee').val().replace(',', '.'));
				curSum = Number($this_price) * Number($this_amount);
				if ($this_kargo) {
					curSum += $this_kargo;
				}
				if (!curSum) {
					curSum = 0;
				}
				sum += curSum;
			});

			if (!sum) {
				sum = 0;
			}
			sum = sum.toFixed(2);
			$("#calc_order_price").text(sum + ' TL');
			$("#cargo_fee_value").text((sum * 0.05).toFixed(2) + ' TL');
			$("#overall_fee").text((sum * 1.05).toFixed(2) + ' TL');
		}
	});
});