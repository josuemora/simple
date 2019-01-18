function aplicaCompleta(){
// [{name: 'id', minWidth: '70px',textAlign:'left'}, {name: 'descripcion', minWidth:'320px',textAlign:'left'}, {name: 'precio', minWidth:'200px',textAlign:'right'}]

	$(".completaprod").mcautocomplete({
		showHeader: true,
		delay: 1000,
		minLength: 0,
		autoFocus: true, //selecciona el primer registro encontrado
		columns: [{name: 'id', class: 'completaprodCol1'}, {name: 'descripcion', class:'completaprodCol2'}, {name: 'precio', class:'completaprodCol3'}],
		source:	function( request, response ) {		
				$.ajax({
					url: "consultas/COMPLETA_productos.php",
					dataType: "xml",
					type : "POST",
					data: "cadena_buscar="+request.term+ "&token=" + $('#token').val()+ "&appid=" + $('#appid').val(),
					success: function( xmlResponse ) {
						var data = $( "producto", xmlResponse ).map(function() {
							return [ [$( "id", this ).text(),$( "descripcion", this ).text(),$( "precio", this ).text()] ] ;
						}).get()
						response(data);
					}
				})
			},
		select: function(event, ui) {
			this.value = (ui.item ? ui.item[0]: '');//pasa el id
			var objTR = $(this).closest("tr");
			$('input[name*=descripcion_]', objTR).val(ui.item[1]);//pasa la descripcion
			$('input[name*=precio_]', objTR).val(ui.item[2]);//pasa el precio
			//$('input[name*=precio_]', objTR).trigger('change');
			
			return false;
		}
	});


	$(".calcImp").change(function() {
		var objFrm = $(this).closest("form");
		var objTR = $(this).closest("tr");
		var ventas_id = $("input[id^='dlg_id_']", objFrm).val();
		var NumRen = $('input[name*=NumRen]', objTR).val();
		var productos_id = $('input[name*=productos_id]', objTR).val();
		var cantidad = $('input[name*=cantidad]', objTR).val();
		var precio = $('input[name*=precio]', objTR).val();
		var colorimp = $('input[name*=descripcion]', objTR).css("color"); //tomar el color
		$('input[name*=importe]', objTR).val(0); //poner en cero para identificar el registro en la tabla
		$('input[name*=importe]', objTR).css("color",'red');//poner en rojo
		$.ajax({
			url: "consultas/ABC_detventas2.php",
			dataType: "xml",
			type : "POST",
			data: "NumRen="+NumRen+ "&ventas_id="+ventas_id+ "&productos_id="+productos_id+ "&cantidad="+cantidad+ "&precio="+precio+ "&token=" + $('#token').val()+ "&appid=" + $('#appid').val(),
			success: function( xml ) {
				if(xml!=null){
					if($(xml).find("estatus").text()=="S"){
						$("Registro",xml).each(function(){
							console.log($("ren",this).text()+' '+$("ventas_id",this).text()+' '+$("productos_id",this).text()+' '+$("cantidad",this).text()+' '+$("precio",this).text()+' '+$("importe",this).text());
							$('input[name*=descripcion]', objTR).val($("descripcion",this).text());//registro.descripcion 
							$('input[name*=importe]', objTR).val($("importe",this).text());//registro.importe 
							$('input[name*=importe]', objTR).css("color",colorimp);
						});
						$("Totales",xml).each(function(){
							$('input[name*=sumcantidad]', objFrm).val($("sumcantidad",this).text());
							$('input[name*=sumimporte]', objFrm).val($("sumimporte",this).text());
						});
						
					};
				};
			}
		})
		
		
		
	});


	
}


aplicaCompleta();







	
