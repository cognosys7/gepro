//FUNCION PARA COLUMNAS DE TIPO 2
function OcultaBOx()
{
    $("#cboxTopLeft").hide();
    $("#cboxTopRight").hide();
    $("#cboxBottomLeft").hide();
    $("#cboxBottomRight").hide();
    $("#cboxMiddleLeft").hide();
    $("#cboxMiddleRight").hide();
    $("#cboxTopCenter").hide();
    $("#cboxBottomCenter").hide();
    $("#cboxOverlay").hide();
}

function GetColumnSize(percent)
{ 
    var div_ancho   = document.getElementById("datos").offsetWidth;
    return (parseInt((div_ancho * percent)/100)-20);
} 

function GetHightSize()
{ 
    var Alto = window.innerHeight;
    return Alto - 486;
} 

/*deshabilita botones*/
$.validator.setDefaults({
    submitHandler: function() {
        submit();
    }
});

/*valida si es fecha correcta*/
function existeFecha(fecha){
      var fechaf 	= fecha.split("/");
      var day 		= fechaf[0];
      var month 	= fechaf[1];
      var year 		= fechaf[2];
      var date 		= new Date(year,month,'0');
      if((day-0)>(date.getDate()-0)){
            return false;
      }
      return true;
}

/*valida todo el formulario*/
$(function() {
    $("#formulario").validate({
        submitHandler: function(form){
            if(!this.wasSent){
                this.wasSent = true;
                $(':submit', form).val('Procesando...')
                    .attr('disabled', 'disabled')
                    .addClass('disabled');
                form.submit();
            } else {
                return false;
            }
        }
    });
    $("#formulario1").validate({
        submitHandler: function(form){
            if(!this.wasSent){
                this.wasSent = true;
                $(':submit', form).val('Procesando...')
                    .attr('disabled', 'disabled')
                    .addClass('disabled');
                form.submit();
            } else {
                return false;
            }
        }
    });
    $("#formulario2").validate({
        submitHandler: function(form){
            if(!this.wasSent){
                this.wasSent = true;
                $(':submit', form).val('Procesando...')
                    .attr('disabled', 'disabled')
                    .addClass('disabled');
                form.submit();
            } else {
                return false;
            }
        }
    });
    

});


jQuery.validator.addMethod(
        "maxfilesize",
        function (value, element) {
            return this.optional(element) || (element.files && element.files[0]
                                   && element.files[0].size < 1024 * 1024 * 1);
        },
        'El archivo debe ser menor o igual a 1 Mb.'
);


jQuery.validator.addMethod(
        "tipoarchivoimagen",
        function (value, element) {
            var extArray = new Array("jpg", "jpeg", "bmp", "png", "gif");
            var elemento=$(element).val();
            var b = elemento.split('.');
            var check = false;
             for (var i = 0; i < extArray.length; i++) {
                  if (extArray[i] == b[b.length-1]) {
                      check = true;
                   }

             }
             return this.optional(element) || check;
     },
        'Solo se permiten subir imagenes'
);

jQuery.validator.addMethod(
        "tipoarchivopdf",
        function (value, element) {
            var extArray = new Array("pdf");
            var elemento=$(element).val();
            var b = elemento.split('.');
            var check = false;
             for (var i = 0; i < extArray.length; i++) {
                  if (extArray[i] == b[b.length-1]) {
                      check = true;
                   }

             }
             return this.optional(element) || check;
     },
        'Solo se permiten subir pdfs'
);

jQuery.validator.addMethod(
        "tipoarchivoimagenpdf",
        function (value, element) {
            var extArray = new Array("jpg", "jpeg", "bmp", "png", "gif", "pdf");
            var elemento=$(element).val();
            var b = elemento.split('.');
            var check = false;
             for (var i = 0; i < extArray.length; i++) {
                  if (extArray[i] == b[b.length-1]) {
                      check = true;
                   }

             }
             return this.optional(element) || check;
     },
        'Solo se permiten subir imagenes'
);

/*valida fecha*/
jQuery.validator.addMethod("date", function(value, element) {
	var check = false;
	var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
	if( re.test(value)) {
                var adata1 = value.split('/');
                var gg1 = adata1[0];
                var mm1 = adata1[1];
                var numgg=gg1.length;
                var nummm=mm1.length;
                if (numgg<2){
                    check = false;
                    return this.optional(element) || check;
                }
                if (nummm<2){
                    check = false;
                    return this.optional(element) || check;
                }

                var currentYear = parseInt((new Date).getFullYear());
                var currentMes  = parseInt((new Date).getMonth() + 1);
                var currentDia  = parseInt((new Date).getDate());
		var adata 	= value.split('/');
		var gg 		= parseInt(adata[0],10);
		var mm 		= parseInt(adata[1],10);
		var aaaa 	= parseInt(adata[2],10);
		var xdata 	= new Date(aaaa,mm-1,gg);
        //alert(currentMes);
		if ((xdata.getFullYear() === aaaa) && (xdata.getMonth() === mm - 1) && (xdata.getDate() === gg))
        {
			if (aaaa <= currentYear)
			{
				if (aaaa === currentYear)
				{
					if (mm <= currentMes)
					{
						if (mm === currentMes)
						{
							if (gg <=currentDia)
							{
								check = true;
							}
							else
							{
								check = false;
							}
						}
						else
						{
							check = true;
						}
					}
					else
					{
						check = false;
					}
				}
				else
				{
					check = true;
				}
			}
			else
			{
			   check = false;
			}
		}
		else 
		{
		   check = false;     
		}
	} 
	else 
	{
   		check = false;
	}
	return this.optional(element) || check;
}, "Ingrese una fecha correcta");

jQuery.validator.addMethod("date", function(value, element) {
	return value.match(/^\d{1,2}\/\d{1,2}\/\d{4}$/);
}, "Ingrese una fecha correcta");

jQuery.validator.addMethod("integer", function(value, element) {
    return this.optional(element) || /^-?\d+$/.test(value);
}, "Solamente ingrese Números enteros");

jQuery.validator.addMethod("alphanumeric", function(value, element) {
    //return this.optional(element) || /^[a-z0-9\a-zñÑáÁéÉíÍóÓúÚ° \-:.,;$¿?\n\ - \n]+$/i.test(value);
    return this.optional(element) || /^[(a-z)(A-Z)(0-9)(ñÑáÁéÉíÍóÓúÚäëïöüÿÄËÏÖÜ) (:.,;?¿) – (“”) (°) (/) \n -]+$/.test(value);
}, "Ingrese Sólo Letras y N° Números");

jQuery.validator.addMethod("alphanumericFono", function(value, element) {
    return this.optional(element) || /^[a-z0-9\() \-]+$/i.test(value);
}, "Ingrese un número de teléfono válido");

jQuery.validator.addMethod("alphanumericContacto", function(value, element) {
    return this.optional(element) || /^[a-z0-9\a-zñÑáÁéÉíÍóÓúÚ°@ \-:.,;$¿?\n\ - \n]+$/i.test(value);
}, "Ingrese un número de teléfono válido");

jQuery.validator.addMethod("alphanumeric2", function(value, element) {
    //return this.optional(element) || /^[a-zA-Z0-9������������. - ]+$/.test(value);
    return this.optional(element) || /^[a-z0-9\a-zñÑáÁéÉíÍóÓúÚ° \:.,\ -]+$/i.test(value);
}, "Ingrese Sólo Letras y Números");

jQuery.validator.addMethod("strippedminlength", function(value, element, param) {
    return jQuery(value).text().length >= param;
}, 

jQuery.validator.format("Ingrese {0} caracteres como mínimo"));
var nav4 = window.Event ? true : false;
function decimal(evt){
    var key = nav4 ? evt.which : evt.keyCode;
    return (key <= 13 || key === 46 || key === 8  || (key >= 48 && key <= 57));
}

function acceptNum(evt)
{	
        if(window.event){
        // IE
        keynum = evt.keyCode;
    }
    else
    {
        keynum = evt.which;
    }
    if((keynum>47 && keynum<58) || keynum===8 || keynum===0){
        return true;
    }
    else
    {
        return false;
    }
    var key = nav4 ? evt.which : evt.keyCode;	
    return (key === 0 || key === 8 || key <= 13 || (key >= 48 && key <= 57));
}

function soloText(evt){
    var key = nav4 ? evt.which : evt.keyCode;
    return ((key > 57));
}

function conMayusculas(field) {
    field.value = field.value.toUpperCase();
}

function soloLetras(e){

    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = [8];

    tecla_especial = false;
    for(var i in especiales){
        if(key === especiales[i]){
            tecla_especial = true;
            break;
        } 
    }
    if(letras.indexOf(tecla)===-1 && !tecla_especial)
        return false;
}

function isAlphanumeric(evt)
{ 
    if(window.event){
        keynum = evt.keyCode;
    }
    else
    {
        keynum = evt.which;
    }
    if(keynum === 45 || keynum === 127  || keynum === 46 || (keynum > 64 && keynum < 91) || (keynum > 96 && keynum < 123) || keynum === 8 || keynum === 32 || (keynum >= 48 && keynum <= 57)){
        return true;
    }
    else
    {
        return false;
    }
    var key = nav4 ? evt.which : evt.keyCode;	
    return (keynum === 45 || keynum === 46 || (key > 64 && key < 91) || (key > 96 && key < 123) || key === 8 || key === 32 || (key >= 48 && key <= 57));
} 