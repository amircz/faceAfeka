$("input#log").click( function() {
	$.ajax({
		type: "POST",
		url: "logout.php",
		success: function(data){
			window.location.href = 'login.php';

			}
		});  
});
