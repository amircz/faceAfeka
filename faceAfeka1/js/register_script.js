$("input#submit").click( function() {
	if( $("#un").val() == "" || $("#pass").val() == "" || $("#rpass").val() == "") 
		$("div#ack").html("Please fill all fields");
		
	else if($("#pass").val() != $("#rpass").val())
		$("div#ack").html("passwords don't match");
		
	else
	{
		var form = new FormData(document.getElementById('upload_img'));
	    //append files
	    var file = document.getElementById('img').files[0];
	    if (file) {   
	        form.append('files', file);
	    }
	    
	    var other_data = $("#form :input").serializeArray();
	    $.each(other_data,function(key,input){
	    	form.append(input.name,input.value);
	    });

		$.ajax({
	        type: "POST",
	        url: "authUser.php",
	        data: form,             
	        cache: false,
	        contentType: false, //must, tell jQuery not to process the data
	        processData: false,
	        //data: $("#upload_img").serialize(),
	        success: function(data)
	        {
	        	if(data == "username already exsit")
	        		$("div#ack").html(data);
	        	else
	        		window.location.href = 'userAdded.php';
	        }
	    });
	}
	
	$("#form").submit( function() {
		return false;
	});
});