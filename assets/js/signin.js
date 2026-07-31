$(function () {

	var root_url = window.location.origin+"/";
    var current_url = window.location.href.match(/^.*\//);
    var check_id_url = ((window.location.href).substring((window.location.href).lastIndexOf('/') + 1)).match(/\d/g);
    var id_url = (check_id_url===null) ? null : check_id_url.toString();

	jQuery.support.placeholder = false;
	test = document.createElement('input');
	if('placeholder' in test) jQuery.support.placeholder = true;
	
	if (!$.support.placeholder) {
		
		$('.field').find ('label').show ();
		
	}

	$('#login').on('click', function(){
        $.ajax({
            url: root_url+'root/service.php',
            type: "POST",
            dataType: "JSON",
            data: {
				username            :   $('#username').val(),
				password            :   $('#password').val(),
                from        : 'login',
                action      : 'login-attempt'
            },
            success: function(data) {
                if(data.error){
                    alert(data.message);
                }else{
                    window.location.href = root_url+"system/dashboard";
                }
            }
        });
        
    })

	
});