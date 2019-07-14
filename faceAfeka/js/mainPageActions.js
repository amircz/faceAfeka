$(document).ready(function(){
	
	$('#addPost').on('submit', function(e){  
        e.preventDefault();  
        $.ajax({  
              url: "addPost.php",  
              type: "POST",  
              data: new FormData(this),  
              contentType: false,  
              processData:false,  
              success: function(data)  
              {  
            	  $("#textArea").val(""); 
            	  $('#postsList').load('MainPageLoadFunc.php').fadeIn("slow");
              }  
         });
    });
	//search friend
	$(".search").keyup(function(){
		var searchbox = $(this).val();
		var dataString = 'searchword='+ searchbox;

		if(searchbox==''){}
		else
		{
			$.ajax({
				type: "POST",
				url: "searchRes.php",
				data: dataString,
				cache: false,
				success: function(html){
					$("#display").html(html).show();
				}
			});
		}return false;    
	});

//add comment
$('#postsList').on('click','input.post',function(e){
	e.preventDefault();
	//var ed = $("#commCont").val();
	var post_id = $(this).attr("name");
	var ed;
	var elements = document.getElementsByClassName("commCont");
	var names = '';
	for(var i=0; i<elements.length; i++) {
		if(elements[i].name == post_id)
	    	ed = elements[i].value;
	}

	var fd = new FormData();    
	fd.append('commCont', ed );
	fd.append('post_id', post_id );

	$.ajax({
		type: "POST",
		url: "addComment.php",
		data:  fd,
		cache: false,
		contentType: false,  
        processData:false,  
		success: function(data){
				$("#commCont").val(""); 
				$('#postsList').load('MainPageLoadFunc.php').fadeIn("slow");

			}
		});   
});

//add like
$('#postsList').on('click','input.like',function(e){
	e.preventDefault();
	var val = $(this).val();
	var post_id = $(this).attr("name")
	
	var fd = new FormData();    
	fd.append('num_like', val );
	fd.append('post_id', post_id );
	$.ajax({
		type: "POST",
		url: "addLike.php",
		data:  fd,
		cache: false,
		contentType: false,  
        processData:false,  
		success: function(data){
			if(data == "true")
				$('#postsList').load('MainPageLoadFunc.php').fadeIn("slow");
			
			}
		});   
});

//change permission
$('#postsList').on('click','input.perm',function(e){
	e.preventDefault();
	var p = $("#result");
	var post_id = $(this).attr("name")
	
	var fd = new FormData();    
	fd.append('res', p );
	fd.append('post_id', post_id );
	$.ajax({
		type: "POST",
		url: "changePerm.php",
		data:  fd,
		cache: false,
		contentType: false,  
        processData:false,  
		success: function(data){
				$('#postsList').load('MainPageLoadFunc.php').fadeIn("slow");
			}
		});   
});

$('#postsList').on('click','input.show',function(e){
	e.preventDefault();
	var currnetHide = $(this).attr("name");
	var currnetShow = $(this).attr("name");
	var currentDiv = $(this).attr("name");
	
	$.ajax({
		type: "POST",
		cache: false,
		contentType: false,  
        processData:false,  
		success: function(data){
			var buttons = document.getElementsByClassName('hide');
		    for ( var i in Object.keys(buttons)) {
		    	if(buttons[i].atrr("name").equals(currentHide))
		    		buttons[i].parentElement.show();

		    	else
		    		if(button[i].attr("name").equals('show'))
		    			buttons[i].parentElement.hide();
		    }
		    
			var divs = document.getElementsByClassName('exposeDiv');
			for ( var i in Object.keys(divs)) {
		    	if(divs[i].atrr("name").equals(currentDiv))
		    		divs[i].parentElement.show('blind');
			}
		}  
	});
});

$('#postsList').on('click','input.hide',function(e){
	e.preventDefault();
	var currnetHide = $(this).attr("name");
	var currnetShow = $(this).attr("name");
	var currentDiv = $(this).attr("name");
	
	$.ajax({
		type: "POST",
		cache: false,
		contentType: false,  
        processData:false,  
		success: function(data){
			var buttons = document.getElementsByClassName('hide');
		    for ( var i in Object.keys(buttons)) {
		    	if(buttons[i].atrr("name").equals(currentHide))
		    		buttons[i].parentElement.hide();

		    	else
		    		if(button[i].attr("name").equals('show'))
		    			buttons[i].parentElement.show();
		    }
		    
			var divs = document.getElementsByClassName('exposeDiv');
			for ( var i in Object.keys(divs)) {
		    	if(divs[i].atrr("name").equals(currentDiv))
		    		divs[i].parentElement.hide('blind');
			}
		}  
	});
});

//
//$('#postsList').on('click','input.hide',function(e){
//	e.preventDefault();
//	$('#exposeDiv').show('blind');
//	$('#hide').show();
//	$('#show').hide();
//});

//$('#hide').click(function(){
//	$('#exposeDiv').hide('blind');
//	$('#hide').hide();
//	$('#show').show();
//});
//
//$('#show').click(function(){
//	$('#exposeDiv').show('blind');
//	$('#hide').show();
//	$('#show').hide();
//});

});

function addFriend(user_id) {
    $.ajax({
         type: "POST",
         url: 'addFriend.php',
         data:{user_id:user_id},
         success:function(html) {
        	 $('#postsList').load('MainPageLoadFunc.php').fadeIn("slow");
         }

    });
}

$(document).mouseup(function(e) 
		{
		    var container = $("#display");

		    // if the target of the click isn't the container nor a descendant of the container
		    if (!container.is(e.target) && container.has(e.target).length === 0) 
		    {
		        container.hide();
		    }
		});
