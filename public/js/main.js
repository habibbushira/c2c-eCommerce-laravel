/*price range*/

 	$('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};

	function selectAll(){
	    selectBox = document.getElementById('sbTwo');
	    
	    for(var i = 0; i < selectBox.options.length; i++){
	       selectBox.options[i].selected = true;
	    }
	}

$(document).ready(function(){
	$(function () {
		
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});	

		$('input[type=radio][name=checkout_options]').change(function(){
			var id = $(this).val();

			if(id === 'register'){
				$('.register-form').css('display','block');
				$('.register-form input').attr('disabled', false);
				$('.register-form select').attr('disabled', false);
				
				$('.guest').css('display','none');
				$('.guest input').attr('disabled', true);
			}else if(id === 'guest'){
				$('.register-form').css('display','none');
				$('.register-form input').attr('disabled', true);
				$('.register-form select').attr('disabled', true);

				$('.guest').css('display','block');
				$('.guest input').attr('disabled', false);
			}
		});

		$('input[type=checkbox][name=address]').change(function(){
			if($(this).is(':checked')){
				$('.shipping_address').css('display','none');
				$('.shipping_address input').attr('disabled', true);
				$('.shipping_address select').attr('disabled', true);
			}else{
				$('.shipping_address').css('display','block');
				$('.shipping_address input').attr('disabled', false);
				$('.shipping_address select').attr('disabled', false);
			}
		});

		//Change price and stock with size
		$('#selSize').change(function(){
			var idSize = $(this).val();

			$.ajax({
				type:'get',
				url:'/get_product_price',
				data: {idSize:idSize},
				success: function(resp){

					var arr = resp.split('#');
					$('#proPrice').html(arr[0]+" "+arr[2]);

					$('#price').val(arr[0]);

					if(arr[1] == 0){
						$('#car_btn').hide();
						$('#availability').text("Out of Stock");
					}else{
						$('#car_btn').show();
						$('#availability').text("In Stock "+arr[1]+" items");
					}

					$('#quantity').attr('max', arr[1]);
				},
				error: function(e){
					console.log(e);
				}
			});
		});

		$('.changeImage').click(function(){
			var image = $(this).attr('src');
			var mainImage = $('.mainImage').attr('src');
			$('.mainImage').attr("src", image);
			$(this).attr('src', mainImage);
		});

        $('.compare').click(function(){
        	var id = $(this).attr('rel');

        	$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
        	});

        	$.ajax({
				type:'post',
				url:'/compare',
				data: {
					id: id
				},
				success: function(resp){
					if(resp == 1){
						swal("The product has been added to your compare list",{
                            icon:"success",
                        });
                       	value = 0;   

                       	if($('#compare').text()){                       		
                       		value = parseInt(value, 10) + 1;
                       	}
                       	else{                       		
                       		value = 1;
                       	}
                       	$('#compare').text(value);
					}
					else
						swal("The product is already in your compare list",{
                            icon:"warning",
                        });
				},
				error: function(e){
					console.log(e);
				}
			});
        });

        $('.deleteRecord').click(function(){
                var id = $(this).attr('rel');
                var deleteFunction = $(this).attr('rel1');
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this",
                    icon: "warning", 
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if(willDelete){
                        swal("The product has been removed",{
                            icon:"success",
                        });
                        window.location.href=deleteFunction+"/"+id;  
                    }
                });
            });

        $('.dropdown, .btn-group').hover(function(){
        	var dropdownMenu = $(this).children('.dropdown-menu');
        	if(dropdownMenu.is(':visible')){
        		dropdownMenu.parent().toggleClass('open');
        	}
        });
        
	});
});