(function($) {
$.fn.autoGrowInput = function(o) {
    o = $.extend({ 
        maxWidth: 1000, 
        minWidth: 25, 
        comfortZone: 15 ,
	parent:$(this).parent()
    }, o); 
    this.filter('input:text').each(function(){ 
        var minWidth = o.minWidth || $(this).width(), 
            val = '', 
            input = $(this), 
            testSubject = $('<tester/>').css({ 
                position: 'absolute', 
                top: -9999, 
                left: -9999, 
                width: 'auto', 
                fontSize: input.css('fontSize'), 
                fontFamily: input.css('fontFamily'), 
                fontWeight: input.css('fontWeight'), 
                letterSpacing: input.css('letterSpacing'), 
                whiteSpace: 'nowrap' 
            }), 
            check = function() { 
                if (val === (val = input.val())) {return;} 
                // Enter new content into testSubject 
                var escaped = val.replace(/&/g, '&amp;').replace(/\s/g,' ').replace(/</g, '&lt;').replace(/>/g, '&gt;'); 
                testSubject.html(escaped); 
                // Calculate new width + whether to change 
                var testerWidth = testSubject.width(), 
                    newWidth = (testerWidth + o.comfortZone) >= minWidth ? testerWidth + o.comfortZone : minWidth, 
                    currentWidth = input.width(), 
                    isValidWidthChange = (newWidth < currentWidth && newWidth >= minWidth) 
                                         || (newWidth > minWidth && newWidth < o.maxWidth); 
                // Animate width 
                if (isValidWidthChange && o.parent.width()>newWidth) { 
                    input.width(newWidth); 
                }  
            }; 
        testSubject.insertAfter(input); 
        $(this).bind('keyup keydown blur update', check); 
    }); 
    return this; 
}; 
})(jQuery); 

/*******************************
Autor: Iván Guardado
Web: http://cokidoo.com
Nota: Siéntete libre de utilizar este código, pero agradeceríamos mantuvieses los créditos originales.
**************************************/

(function($){
	$.fn.extend({
		autoResize: function(options){
			/*//Si no se envía nada, se crea un objeto vacío para que no de error a continuación
			if(!options){
				options = {};
			}
			*/
			var _options = $.extend({
				//Maximo en altura que podrá alcanzar, luego se aplicará scrollbar
				maxHeight:  null,
				//Altura que tomará al coger el foco
				minHeight:  null,
				//Texto que se mostrará cuando esté vacío y sin foco
				textHold:  null,
				//Clase que se añadirá cuando recibe el foco
				activeClass: null
			}, options);
			/*
			//Almacena las opciones pasadas a la función o valores predeterminados en su defecto
			var _options = {
				//Maximo en altura que podrá alcanzar, luego se aplicará scrollbar
				maxHeight: options.maxHeight || null,
				//Altura que tomará al coger el foco
				minHeight: options.minHeight || null,
				//Texto que se mostrará cuando esté vacío y sin foco
				textHold: options.textHold || null,
				//Clase que se añadirá cuando recibe el foco
				activeClass: options.activeClass || null
			};*/
			
			this.each(function(){
				//Encapsulamos con jQuery
				var $this = $(this);
				//Establece el texto por defecto si ha sido establecido
				if($this.val() == "" && _options.textHold){
					$this.val(_options.textHold);
				}
				//Guarda la altura inicial
				$this.initHeight = $this.css("height");
				//Establece el atributo CSS overflow según el caso
				if(_options.maxHeight){
					$this.css("overflow", "auto");
				}else{
					$this.css("overflow", "hidden");
				}
				//Para guardar el texto y comparar si hay cambios
				var _value = null;
				//Crea el clon del textarea
				var $clon = $this.clone(true);
				//Establece propiedades del clon y lo añade al DOM
				$clon.css({
					visibility: "hidden",
					position: "absolute",
					top: 0,
					overflow: "hidden",
					width: parseInt($this.width())-10
				});
				$clon.attr("name","");
				$clon.attr("id", "");
				$this.parent().append($clon);
				//Aux
				var clon = $clon[0];
				var me = $this;
				//Eventos del textarea
				$this.bind("keyup" , autoFit)
					.bind("focus", function(){
						if(_options.textHold){
							if(this.value == _options.textHold){
								this.value = "";
							}
						}
						if(_options.minHeight){
							me.css("height", _options.minHeight+"px");
							$clon.css("height", _options.minHeight+"px");
							autoFit(true);
						}
						if(_options.activeClass){
							me.addClass(_options.activeClass);
						}
					})
					.bind("blur", function(){
						if(_options.textHold){
							if(this.value == ""){
								this.value = _options.textHold;
								if(_options.minHeight && me.initHeight){
									$clon.css("height", me.initHeight);
									me.css("height", me.initHeight);
									autoFit();
								}
							}
						}else{
							if(_options.minHeight && me.initHeight){
								$clon.css("height", me.initHeight);
								me.css("height", me.initHeight);
								autoFit();
							}
						}
						if(_options.activeClass){
							me.removeClass(_options.activeClass);
						}
					});
				function autoFit(force){
				    	clon.value = me.val();
				    	//Comprueba si ha cambiado el valor del textarea
				    	if (_value != clon.value || force===true){
					    _value = clon.value;
					    var h = clon.scrollHeight;
					    if(_options.maxHeight && h > _options.maxHeight){
						me.css("height", _options.maxHeight + "px");
					    }else{
					    	me.css("height", parseInt(h) + "px");
					    }
						
				    	}
				}
				autoFit();
			});
		}
	})  
}(jQuery));

/*
 * jQuery autoResize (textarea auto-resizer)
 * @copyright James Padolsey http://james.padolsey.com
 * @version 1.04
 */

(function($){
    
    $.fn.autoResize2 = function(options) {
        
        // Just some abstracted details,
        // to make plugin users happy:
        var settings = $.extend({
            onResize : function(){},
            animate : true,
            animateDuration : 150,
            animateCallback : function(){},
            extraSpace : 5,
            limit: 1000
        }, options);
        
        // Only textarea's auto-resize:
        this.filter('textarea').each(function(){
            
                // Get rid of scrollbars and disable WebKit resizing:
            var textarea = $(this).css({resize:'none','overflow-y':'hidden'}),
            
                // Cache original height, for use later:
                origHeight = textarea.height(),
                
                // Need clone of textarea, hidden off screen:
                clone = (function(){
                    
                    // Properties which may effect space taken up by chracters:
                    var props = ['height','width','lineHeight','textDecoration','letterSpacing'],
                        propOb = {};
                        
                    // Create object of styles to apply:
                    $.each(props, function(i, prop){
                        propOb[prop] = textarea.css(prop);
                    });
                    
                    // Clone the actual textarea removing unique properties
                    // and insert before original textarea:
                    return textarea.clone().removeAttr('id').removeAttr('name').css({
                        position: 'absolute',
                        top: 0,
                        left: -9999
                    }).css(propOb).attr('tabIndex','-1').insertBefore(textarea);
					
                })(),
                lastScrollTop = null,
                updateSize = function() {
					
                    // Prepare the clone:
                    clone.height(0).val($(this).val()).scrollTop(10000);
					
                    // Find the height of text:
                    var scrollTop = Math.max(clone.scrollTop(), origHeight) + settings.extraSpace,
                        toChange = $(this).add(clone);
						
                    // Don't do anything if scrollTip hasen't changed:
                    if (lastScrollTop === scrollTop) { return; }
                    lastScrollTop = scrollTop;
					
                    // Check for limit:
                    if ( scrollTop >= settings.limit ) {
                        $(this).css('overflow-y','');
                        return;
                    }
                    // Fire off callback:
                    settings.onResize.call(this);
					
                    // Either animate or directly apply height:
                    settings.animate && textarea.css('display') === 'block' ?
                        toChange.stop().animate({height:scrollTop}, settings.animateDuration, settings.animateCallback)
                        : toChange.height(scrollTop);
                };
            
            // Bind namespaced handlers to appropriate events:
            textarea
                .unbind('.dynSiz')
                .bind('keyup.dynSiz', updateSize)
                .bind('keydown.dynSiz', updateSize)
                .bind('change.dynSiz', updateSize);
            
        });
        
        // Chain:
        return this;
        
    }; 
})(jQuery);
