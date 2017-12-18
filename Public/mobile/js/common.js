// var countdown=60;   
// function goTime() {
// 	var mobile=$('#mobile').val();

// 	if(mobile==""||mobile==null){
// 		return false;
// 	}

// 	if (countdown == 0) {  			
// 		$('.getIdentify').attr("disabled",false);    

// 		$('.getIdentify').val("重新发送"); 			
// 		countdown = 60;   
// 	} else {  			
// 		$('.getIdentify').attr("disabled",true); 
// 		$('.getIdentify').css('background','#fff');
// 		$('.getIdentify').val("重新发送(" + countdown + ")"); 
// 		countdown--;   
// 		setTimeout(function() {   
// 			goTime()   
// 		},1000);   
// 	}   
// }	  

// $('.getIdentify').on('click',function(){
// 	goTime();
// })