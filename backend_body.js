jQuery(document).ready(function(){
	$('.cc_loupslider_option_content').hide(0);
	$('.cc_loupslider_option').click(function(){
		$(this).next('div.cc_loupslider_option_content').toggle(400);
		$(this).toggleClass('active');
	});
	$('.upload').click(function(){
		var anzahl = $('.new_image').size();
		$('.new_image:last').after('<br/><input type="file" size="32" class="new_image" name="new_image['+anzahl+']" />');
	});
	$('.show_links').click(function(){
		current = $(this);
		current.toggleClass('active');
		current.parent().find('.select_link').toggleClass('active');
		current.parent().find('.select_gallery').toggleClass('active');
		if (current.hasClass('active')) { current.html('Link manuell setzen'); }
		else { current.html('Galerie auswählen'); }
		
	});
	$('.select_gallery select').change(function(){
		current = $(this);
		current.parent().parent().find('.select_link input').val(current.val());
	});
	$('.select_gallery select').each(function(){
		current = $(this);
		if (current.val()!=''){
			current.toggleClass('active');
			current.parent().parent().find('.select_link').toggleClass('active');
			current.parent().parent().find('.select_gallery').toggleClass('active');
			current.parent().parent().find('.show_links').html('Link manuell setzen').addClass('active');
		}
	});
});