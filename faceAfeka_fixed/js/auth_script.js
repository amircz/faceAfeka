$("input#submit").click( function() {
	if( $("#un").val() == "" || $("#pass").val() == "") 
		$("div#ack").html("Please enter both username and pasword")
	else
	{
		$.post( $("#form").attr("action"), 
				$("#form :input").serializeArray(),
				function(data){
					if(data)
						{
						window.location.href = 'MainPage.php';
						}
						
						else
							$("div#ack").html("Username or password are inncorect");
		});
	}
	
	$("#form").submit( function() {
		return false;
	});
});