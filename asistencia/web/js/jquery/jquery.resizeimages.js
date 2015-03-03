/**
 * jQuery ResizeImages Plugin
 * by Santiago Dimattía - http://teleportz.com.ar
 *
 * Released under the MIT Licence
 * http://www.opensource.org/licenses/mit-license.php
 */
(function($) {

	$.fn.resizeImages = function(options)
	{
		var defaults = {
				maxWidth: 400,
				msgResized: 'Esta imagen ha sido redimensionada. Has click aqu&iacute; para mostrarla en su tama&ntilde;o real.',
				msgNotResized: 'Este es el tama&ntilde;o original de la imagen. Has click aqu&iacute; para ajustarla a la p&aacute;gina.'
		};

		var settings = $.extend(defaults, options);

		// Ejecutamos el script en cada elemento
		this.each(function(){
			// Si el objeto no es una imagen, no hacemos nada
			if($(this).is('img') == false)
			{
				return;
			}

			// Como siempre, un pequeño FIX para que IE haga bien las cosas :)
			// Solución por http://www.witheringtree.com/2009/05/image-load-event-binding-with-ie-using-jquery/
			if($.browser.msie)
			{
				var $src = $(this).attr('src');
				$(this).attr('src', '').attr('src', $src);
			}

			// Esperemos hasta que la imagen cargue, así podemos obtener el tamaño de esta
			$(this).load(function()
			{
				// Si el tamaño de la imagen es menor al tamaño máximo, no hacemos nada
				if($(this).width() <= settings.maxWidth)
				{
					return;
				}

				// Creamos un DIV alrededor de la imágen y la redimensionamos al tamaño máximo permitido
				$(this).wrap('<div class="resizedImageContainer" style="width: ' + settings.maxWidth + 'px;" />');
				$(this).width(settings.maxWidth);

				// Seleccionamos el DIV que creamos y arriba de todo agregamos otro DIV que será la alerta
				var $parent = $(this).parent();
				$parent.prepend('<div>' + settings.msgResized + '</div>');

				// Observamos el evento CLICK en la alerta
				$parent.children('div').click(function(){
					var $container = $(this).parent();

					// Si el elemento contiene la clase notResized, es porque la imágen está maximizada.
					if($container.hasClass('notResized'))
					{
						// Achicamos el container y la imágen al tamaño máximo de imagen
						$container.width(settings.maxWidth);
						$container.children('img').width(settings.maxWidth);

						// Cambiamos el mensaje de la alerta
						$container.children('div').html(settings.msgResized);

						// Eliminamos la clase
						$container.removeClass('notResized');
					}
					else
					{
						// Redimensionamos la imágen al tamaño automático y obtenemos el valor
						var width = $container.children('img').width('auto').width();

						// Redimensionamos el contenedor
						$container.css('width', width);

						// Cambiamos el mensaje de la alerta
						$container.children('div').html(settings.msgNotResized);

						// Agregamos la clase
						$container.addClass('notResized');
					}
				})
			});
		});
	}

})(jQuery);
