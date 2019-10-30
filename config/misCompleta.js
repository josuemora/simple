function aplicaCompleta(){
	
 
   $( ".accordion" )
      .accordion({
        header: "> div > h3",
		collapsible: true,
		heightStyle: "content",
		activate:function( event, ui ) {
			activar_principales();
		}
      })
      .sortable({
        axis: "y",
        handle: "h3",
        stop: function( event, ui ) {
          // IE doesn't register the blur when sorting
          // so trigger focusout handlers to remove .ui-state-focus
          ui.item.children( "h3" ).triggerHandler( "focusout" );

          // Refresh accordion to handle new order
          $( this ).accordion( "refresh" );
        }
      });	

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

	
	$(".pintaGrafico").change(function() {
		CreaGrafico(this,'foow','preview-textfield');
	});

	
}

function CreaGrafico(pobj,pidCanvas,pidTextNum){
		var obj = (typeof pobj == 'undefined' || pobj == false) ? $('input[name^=valor_1]') :  pobj ;
		var idCanvas = (typeof pidCanvas == 'undefined' || pidCanvas == false) ? 'foow' :  pidCanvas ;
		var idTextNum = (typeof pidTextNum == 'undefined' || pidTextNum == false) ? 'preview-textfield' :  pidTextNum ;
		var objFrm = $(obj).closest("form");
		var objTabla = $(obj).closest("tbody");
		
		var UltimoValor = 0;
		var Minimo = 0;
		var Meta = 0;
		var Excelente = 0;
		var ren = '';
		var digitosFraccion = $('input[name^=digfraccion]',objFrm).val();

		objTabla.find('input[name^=valor]').each(function(){
			if(parseFloat($(this).val())>0){
				UltimoValor = $(this).val(); //parseInt($(this).val());
				ren = $(this).attr('name').replace('valor','');
				Minimo = $('input[name=minimo'+ren+']').val();
				Meta = $('input[name=meta'+ren+']').val();
				Excelente = $('input[name=excelente'+ren+']').val();
			}
		});
		PintaGrafico(UltimoValor,Minimo,Meta,Excelente,idCanvas,idTextNum,digitosFraccion);
}

function PintaGrafico(UltimoValor,Minimo,Meta,Excelente,idCanvas,idTextNum,digitosFraccion){	
	var ValorInicial = 0;
	var ValorMaximo = 0;
	var Zonas = [];
	var lblZonas = {};
	
	if(parseFloat(Meta) >= parseFloat(Minimo)){
		//ValorInicial = 0;
		//ValorMaximo = Excelente * 1.01;
		ValorInicial = parseFloat(Minimo - (Minimo  * 0.1));
		ValorMaximo = parseFloat(Excelente) * 1.10;
		if(parseFloat(UltimoValor) > parseFloat(ValorMaximo)){
			ValorMaximo = UltimoValor;
		};
		if(parseFloat(UltimoValor) < parseFloat(ValorInicial)){
			ValorInicial = UltimoValor;
		};

		Zonas = [
			   {strokeStyle: "#F03E3E", min: ValorInicial, max: Minimo},  // Red
			   {strokeStyle: "#FFDD00", min: Minimo, max: Meta}, // Yellow
			   {strokeStyle: "#30B32D", min: Meta, max: Excelente}, // Green
			   {strokeStyle: "#0DDE16", min: Excelente, max: ValorMaximo} // Verde  , height: 1.1
			];
		lblZonas = {
			font: "10px sans-serif",
			labels: [parseFloat(ValorInicial),parseFloat(Minimo), parseFloat(Meta), parseFloat(Excelente),parseFloat(ValorMaximo)],
			fractionDigits: digitosFraccion
		  };	
		//console.log(ValorInicial,UltimoValor,Minimo,Meta,Excelente,ValorMaximo);
		//console.log(Zonas);

	}else{
		ValorInicial = parseFloat(Excelente - (Excelente  * 0.3));
		ValorMaximo = parseFloat(Minimo) * 1.10;
		if(parseFloat(UltimoValor) > parseFloat(ValorMaximo)){
			ValorMaximo = UltimoValor;
		};
		if(parseFloat(UltimoValor) < parseFloat(ValorInicial)){
			ValorInicial = UltimoValor;
		};
		Zonas = [
			   {strokeStyle: "#0DDE16", min: ValorInicial, max: Excelente}, // Verde  , height: 1.1
			   {strokeStyle: "#30B32D", min: Excelente, max: Meta}, // Green
			   {strokeStyle: "#FFDD00", min: Meta, max: Minimo}, // Yellow
			   {strokeStyle: "#F03E3E", min: Minimo, max: ValorMaximo}  // Red
			];
		lblZonas = {
			font: "10px sans-serif",
			labels: [parseFloat(ValorInicial),parseFloat(Excelente), parseFloat(Meta), parseFloat(Minimo),parseFloat(ValorMaximo)],
			fractionDigits: digitosFraccion
		  };	
			
		//console.log(ValorInicial,UltimoValor,Minimo,Meta,Excelente,ValorMaximo);
	}
	//console.log(lblZonas);
		
	var opts = {
	  angle: 0.1, // The span of the gauge arc 0.15
	  lineWidth: 0.44, // The line thickness
	  radiusScale: 1, // Relative radius
	  pointer: {
		length: 0.6, // // Relative to gauge radius 0.6
		strokeWidth: 0.03, // The thickness 0.035
		color: '#000000' // Fill color
	  },
	  limitMax: false,     // If false, max value increases automatically if value > maxValue
	  limitMin: false,     // If true, the min value of the gauge will be fixed
	  colorStart: '#6FADCF',   // Colors
	  colorStop: '#8FC0DA',    // just experiment with them
	  strokeColor: '#E0E0E0',  // to see which ones work best for you
	  generateGradient: true,
	  highDpiSupport: true,     // High resolution support
	  staticLabels : lblZonas,
	  staticZones: Zonas,
	   renderTicks: {
		divisions: 2,
		divWidth: 1.2,
		divLength: 0.45,
		divColor: '#333333',
		subDivisions: 5,
		subLength: 0.3,
		subWidth: 0.7,
		subColor: '#666666'
	}
	  
	};
	var target = document.getElementById(idCanvas); // your canvas element
	var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
	gauge.setTextField(document.getElementById(idTextNum),digitosFraccion);
	gauge.maxValue = ValorMaximo; // set max gauge value
	gauge.setMinValue(ValorInicial);  // Prefer setter over gauge.minValue = 0
	gauge.animationSpeed = 32; // set animation speed (32 is default value)
	gauge.set(UltimoValor); // set actual value
	//console.log("entro a pintaGraficooo");
}

//$("#PrincipalesAnio").selectmenu();
//$("#PrincipalesMes").selectmenu();
	
function activar_principales(){
	//$("#PrincipalesAnio").selectmenu('destroy');
	
	var objMarco = $(".marco > .ui-state-active").closest("div");
	
	var Anio = $("#PrincipalesAnio").val();
	var Mes = $("#PrincipalesMes").val();
	//$(".graficoPrincipales").each(function(index, element) {
	$(".graficoPrincipales",objMarco).each(function(index, element){
		var idObj = $(this).attr('id');
		var aDat = idObj.split('_');
		var sPT = 'g_'+aDat[1]+'_pt_'+aDat[3]+'_'+aDat[4];
		var slbl = 'g_'+aDat[1]+'_lbl_'+aDat[3]+'_'+aDat[4];
		var sFec = 'g_'+aDat[1]+'_fec_'+aDat[3]+'_'+aDat[4];
		var sUni = 'g_'+aDat[1]+'_uni_'+aDat[3]+'_'+aDat[4];
		var indicador = aDat[3];
		//console.log(idObj,sPT);
		$.ajax({
			url: "consultas/ValoresGrafico.php",
			dataType: "xml",
			type : "POST",
			data: "indicador="+indicador+"&Anio=" +Anio+"&Mes=" +Mes+"&token=" + $('#token').val()+ "&appid=" + $('#appid').val(),
			success: function( xml ) {
				if(xml!=null){
					if($(xml).find("estatus").text()=="S"){
						//console.log($(xml).find("valor").text());
						var UltimoValor = $(xml).find("valor").text();
						var Minimo = $(xml).find("minimo").text();
						var Meta = $(xml).find("meta").text();
						var Excelente = $(xml).find("excelente").text();
						var descripcion = $(xml).find("descripcion").text();
						var mes = $(xml).find("mes").text();
						var mesd = $(xml).find("mesd").text();
						var anio = $(xml).find("anio").text();
						var descripcion = $(xml).find("descripcion").text();
						var digfraccion = $(xml).find("digfraccion").text();
						var descorta = $(xml).find("descorta").text();
						if(UltimoValor.length > 0){
							$("#"+slbl).html(descripcion);
							$("#"+sFec).html(anio+'-'+mesd);
							$("#"+sUni).html(descorta);
							PintaGrafico(UltimoValor,Minimo,Meta,Excelente,idObj,sPT,digfraccion);
						}else{
							$("#"+slbl).html('');
							$("#"+sFec).html('');
							PintaGrafico(0,0,0,0,idObj,sPT,0);
						}
					};
				};
			}
		})
		
		
	});
	
	

}

var indResumen = '';
function irAresumen(pIndicador){
	//console.log('indicador',pIndicador);
	indResumen = pIndicador;
	$(".seg_resumen-acceso > a ").trigger('click');
}




	var chartData = {
			labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Acumulado Anual','Promedio Anual'],
			datasets: [
			/*
			{
				type: 'line',
				label: 'Promedio',
				borderColor: window.chartColors.blue,
				borderWidth: 2,
				fill: false,
				data: [100,0,0,0,0,0,0,0,0,0,0,0]
			}, 
			{
				type: 'bar',
				label: 'Acumulado',
				backgroundColor: window.chartColors.red,
				data: [0,0,0,0,0,0,0,0,120,0,randomScalingFactor(),0],
				borderColor: 'white',
				borderWidth: 2
			}
			*/
			]

		};

function activar_resumen(){
	console.log('activar_resumen ',indResumen);
	
	
	var datasets = [
			{
				type: 'line',
				label: 'Promedio',
				borderColor: window.chartColors.blue,
				borderWidth: 2,
				fill: false,
				data: [0,0,0,0,0,0,0,0,0,0,0,0,0,0]
			}
			];





		
		chartData.datasets = datasets;
		
		if(window.myMixedChart == null){
			var ctx = document.getElementById('graficoResumen').getContext('2d');
			window.myMixedChart = new Chart(ctx, {
				type: 'bar',
				data: chartData,
				options: {
					responsive: true,
					maintainAspectRatio: false,
					title: {
						display: true,
						text: ''
					},
					tooltips: {
						mode: 'index',
						intersect: true
					}
				}
			});
		};
		
	
	window.myMixedChart.options.title.text = "Indicacor "+indResumen;
		
	//console.log(chartData);
	window.myMixedChart.update();
	
	
		$.ajax({
			url: "consultas/ValoresResumenGrafico.php",
			dataType: "json",
			type : "POST",
			data: "indicador="+indResumen+"&token=" + $('#token').val()+ "&appid=" + $('#appid').val(),
			success: function(objson){
				if(objson!=null){
					if(objson.estatus=='S'){
						chartData.datasets = objson.datasets;
						window.myMixedChart.options.title.text = indResumen+' '+objson.descripcion;
						window.myMixedChart.update();
					};
					
				};
				
			}
		});

	
	
	
};

function completaRegIndicadores(xml){
	var aUsuarios = $(xml).find("usuarios").text().split(','); //tomar los usuarios previamente asignados al indicador
	var cad = '';
	var id = '';
	var nombre = '';
	
	//pintar los checkbox...
	$("lusuarios",xml).each(function(){
		id = $("usuarios_id",this).text();
		nombre = $("nombre",this).text();
		cad += '<label for="dlg_lusuarios_'+id+'" style="margin-right:10px;margin-bottom:10px;">'+nombre+'<input class="inputs"  id="dlg_lusuarios_'+id+'" type="checkbox" name="usuarios[]" value="'+id+'" ></label>';
	});
	$("#dlg_indicadores_lusuarios").html(cad);
	$('#dlg_indicadores_lusuarios input:checkbox,#dlg_indicadores_lusuarios input:radio').checkboxradio();
	$('#dlg_indicadores_lusuarios input:checkbox,#dlg_indicadores_lusuarios input:radio').checkboxradio('refresh');

	//asignar los valores de los usuarios asignados a cada uno de los checkbox 
	var check = false;
	$("#dlg_indicadores_lusuarios input:checkbox").each(function(){
		check = false;
		for(item=0;item<aUsuarios.length;item++){
			var sUsuario = aUsuarios[item].replace('[','').replace(']','');
			if($(this).val()==sUsuario){
				check = true;
				break;
			}
		}
		$(this).prop("checked",check);
		$(this).checkboxradio("refresh");
	});	


}


aplicaCompleta();







	
