$(document).ready(function(){

	$("#menu_bar .arrow").click(function(){ 			
		$("span.head_menu").removeClass('active');
		submenu = $(this).parent().parent().find("div.sub_menu");
		if(submenu.css('display')=="block"){
			$(this).parent().removeClass("active"); 	
			submenu.hide(); 		
			//$(this).attr('src','arrow_hover.png');									
		}else{
			$(this).parent().addClass("active"); 	
			submenu.fadeIn(); 		
			//$(this).attr('src','arrow_select.png');	
		}
		$("div.sub_menu:visible").not(submenu).hide();
		//$("#menu_bar .arrow").not(this).attr('src','arrow.png');
						
	})
	.mouseover(function(){ 
		//$(this).attr('src','arrow_hover.png'); 
	})
	/*.mouseout(function(){ 
		if($(this).parent().parent().find("div.sub_menu").css('display')!="block"){
			//$(this).attr('src','arrow.png');
		}else{
			//$(this).attr('src','arrow_select.png');
		}
	});*/

	$("#menu_bar span.head_menu").mouseover(function(){ $(this).addClass('over')}).mouseout(function(){ $(this).removeClass('over') });
	$("#menu_bar div.sub_menu").mouseover(function(){ $(this).fadeIn(); }).blur(function(){ 
							   		$(this).hide();
									$("span.head_menu").removeClass('active');
								});		
	$(document).click(function(event){ 		
			var target = $(event.target);
			if (target.parents("#menu_bar").length == 0) {				
				$("#menu_bar span.head_menu").removeClass('active');
				$("#menu_bar div.sub_menu").hide();
			}
	});			   
							   
								   
});
