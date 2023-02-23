$().ready(function(){
  $('div.boxmsg').delay(1500);
  $('div.boxmsg').hide(1000);
  
  $('#inputForm').parsley().on('field:validated', function() {
	var ok = $('.parsley-error').length === 0;
	$('.bs-callout-info').toggleClass('hidden', !ok);
	$('.bs-callout-warning').toggleClass('hidden', ok);
  });
  
});