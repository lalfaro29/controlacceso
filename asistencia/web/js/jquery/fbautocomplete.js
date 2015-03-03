/**
 * fbautocomplete jQuery plugin
 * version 1.0 
 *
 * Copyright (c) 2010 Igor Crevar <crewce@hotmail.com>
 *
 * Licensed under the MIT (MIT-LICENSE.txt) 
 *
 * Requires: jquery UI autocomplete plugin, jquery offcourse
 * Based on tutorial from Dan Wellman 
 * http://net.tutsplus.com/tutorials/javascript-ajax/how-to-use-the-jquery-ui-autocomplete-widget/
 * TODO: global functions are bad?
 **/
 
(function($) {
  $.fn.fbautocomplete = function (options) {
	  var defaultOptions = {
			  minLength: 1,
			  url: 'principal/autocompleta.php',
			  param: false,
			  title: 'Eliminar %s',
	  		  useCache: false,
	  		  formName: 'send_message[user]',
	  		  sendTitles: true,
	  		  onChangeFunc: function($obj){ //$obj.css("top", 2); 
			   },
	  		  onRemoveFunc: function($obj){ 	
	  			  //correct field position 
	  			  if( $obj.parent().find('span').length === 0 ) {
	  				  //$obj.css("top", 0);
	  			  }
	  		  },	
	  		  onAlreadySelected: function($obj){},
	  		  maxUsers: 0,
	  		  onMaxSelectedFunc: function($obj){},
	  		  selected: [],
	  		  cache: {},
			  editable:false,
			  ajax: true,
			  validar: null,
			  error: null,
			  caracteres: new Array(" ",",")
	  };			
	  options = $.extend( true, defaultOptions, options);
	  this.each(function(i){			 	  
		  $(this).fbautocomplete = new $.fbautocomplete($(this), options );
	  });
      return this;
  };
  
  $.fbautocomplete = function ($obj, options) { //constructor
	  var $idObj = '#'+$obj.attr('id');
	  var $parent = $obj.parent(); 
	  $parent.addClass('fbautocomplete-main-div').addClass('ui-helper-clearfix');
	  var selected = [];
	  var lastXhr;
          $obj.width(25)
	  $obj.autoGrowInput();
	  for (var i in options.selected){
		  //be sure to use this only if sendTitles is true
		  if ( typeof options.selected[i].title == 'undefined' ) continue;
		  addNewSelected(options.selected[i].id, options.selected[i].title,true );
	  }
	  $obj.autocomplete({ 
		        minLength: options.minLength,
			source: function(request, response){ 
				var term = request.term;
				request = $.extend( true, request, options.param);
				if(options.ajax){
					if ( options.useCache ){
						if ( term in options.cache ) {
							response( $.map( options.cache[ term ], function( item ) {
								return {
									value: item.title,
									label: item.title,
									id: item.id
								};
							}));
							return;
						}
					}
				//abortar las llamadas anteriores a la base de datos
					if(lastXhr){
						lastXhr.abort()
					}
					//pass request to server

					lastXhr = $.post( options.url, request, function(data,status, xhr){
						data = eval('('+data+')' );
						if ( options.useCache )	{
							options.cache[ term ] = data;
						}
						
						if ( lastXhr == xhr ){
							//parse returned values
							response( $.map( data, function( item ) {
								return {
									value: item.title,
									label: item.title,
									id: item.id
								};
							}));
						}
					});
				}else{
					caracter = term.charAt(term.length -1);
					term = term.slice(0, -1)
					if(jQuery.inArray(caracter, options.caracteres) != -1 && term.length){
						term = term.limpiar();
						if(options.validar(term)){
							addNewSelected(term, term,true);
							$obj.val("");
						}else{
							alert((options.error)?options.error:"valor no valido")
						}
					}
				}
			},

			//define select handler
			select: function(e, ui) {
				addNewSelected(ui.item.id, ui.item.label,true);
				$obj.val("");
				//prevent ui updater to set input
				e.preventDefault();
			},
			//define change handler
			change: function(event, ui) { 
				if(options.validar &&  options.validar($obj.val())){
					addNewSelected($obj.val(), $obj.val(),true);
				}
				$obj.val("");
				options.onChangeFunc($obj);
			}
			
	});
	  //
	  // 
	//add live handler for clicks on remove links
	$(".remove-fbautocomplete", $parent.get(0) ).live("click", function(){
	    //remove current friend
	    $(this).parent().remove();
	    var $input = $(this).parent().find('input.ids-fbautocomplete');
	    if ($input.length){
		    removeSelected($input.val()); 
	    }
	    		
	    options.onRemoveFunc($obj);
	});
	
	
	
	//if user clicks on parent div input is selected  
	/*$parent.click(function(event){
		alert($(this).find("span").length)
		$obj.focus(); 
		
		
	}); 
	*/
      $parent.click(function(event){
          var $target = $(event.target);
          if($target.is("div > span > img.edit-fbautocomplete") && options.editable){
		editar($target.parent())
	  }else{
		if($target.is("div > span > input.text-fbautocomplete_hab") && options.editable){
			return false;
		}else{
			$obj.focus();
		}
	  }
      });
      
      
      
	function addNewSelected(fId, fTitle,valido){
		if ( isInSelected(fId) ){
			options.onAlreadySelected($obj);
			return false;
		}
		if ( isMaxSelected() )
		{
			options.onMaxSelectedFunc($obj);
			return false;
		}
		addToSelected(fId);
		var __title = options.title.replace( /%s/, fTitle );
		
		var $id_hidden = $('<input type="hidden" />').addClass("ids-fbautocomplete").attr('value', fId);
		if(options.editable){
			var $texto     = $('<input type="text" >').width($obj.width())
								.addClass("text-fbautocomplete_des")
								.val(fTitle)
								.attr("disabled","disabled")
								.attr("readOnly","readOnly");
		}else{
			$texto = (fTitle+"  ")
		}
		var $span = $("<span>").append($texto).append($id_hidden);
			if(valido==false){
				$span.addClass("error");
			}else{
				$span.addClass("valido");
			}
		if ( options.sendTitles ){
			$span.append(
				$('<input type="hidden" />').attr('value', fTitle)
					.addClass("name-fbautocomplete")
					.attr('name', options.formName+'[title][]') 
			);
			$id_hidden.attr('name', options.formName+'[id][]');
		}
		else{
			$id_hidden.attr('name', options.formName+'[]');
		}
			if(options.editable){
				var $a = $("<img/>").addClass("edit-fbautocomplete").attr({
					src: "../../images/editarAutoCompleta.gif",
					title: __title,
					alt: "e"
				}).appendTo($span)
			}
				
		var $a = $("<img/>").addClass("remove-fbautocomplete").attr({
					src: "../../images/eliminarAutoCompleta.png",
					title: __title,
					alt: "x"
				}).appendTo($span);
		//text-fbautocomplete		
				
		$span.insertBefore( $idObj );
		return true;
	}
	
	function posOfSelected(id)
	{
		for (var i in selected){
			if ( selected[i] == id ){
				return i;
			}
		}
		return -1;
	}
	function isMaxSelected()
	{
		return options.maxUsers > 0  && selected.length >= options.maxUsers;
	}
	function removeSelected(id)
	{
		var pos = posOfSelected(id);
		if (pos != -1) selected.splice(pos,1);
	}
	function isInSelected(id)
	{
		return posOfSelected(id) != -1;
	}
	function addToSelected(id)
	{
		selected[selected.length] = id;
	}
	function foco(element) {
		if(element == 'input'){
			
		}
	}
	function editar(span){
		span.find('input[type="text"]')
				.removeClass()
				.addClass("text-fbautocomplete_hab")
				.removeAttr("readOnly")
				.removeAttr("disabled")
				.focus()
		span.find('input[type="text"]').blur(function(){
					if(!$(this).attr("readOnly")){
						$(this).attr("readOnly","readOnly")
						.removeClass()
						.addClass("text-fbautocomplete_des")
						.attr("disabled","disabled")
						
					}
				});
		span.find('input[type="text"]').autoGrowInput()
		span.find('input[type="text"]').change(function(){
			span.find('input[type="hidden"].name-fbautocomplete').val($(this).val())
		})		
	
	}
  };
  
})(jQuery);

