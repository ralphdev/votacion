@extends('layouts.laprevia')

@section('content')

	<style>
      @font-face {
        font-family: "Ordinary";
        src: url('../../fonts/big_noodle_titling.ttf');
		font-size:24px;
      }
	</style>
	
	
	<div class="row">

			        <div class="col-md-12 DirectivosDir">
  

                            
					</div>  
  
	</div>
	<div class="row col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col text-center">
				  <div class="  d-flex justify-content-center" style="margin-left: 37px;">
				  <button type="button" class="btn btn-secondary" onclick="regresar()" id="botonregresar"  style="height:70px; col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 font-size:34px;    width: 178px;">REGRESAR</button>	&nbsp;&nbsp;&nbsp;			  
				  <button type="button" class="btn btn-info" onclick="imprimir()" id="botonimprimir" style="height:70px;col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 font-size:34px;    width: 178px;">VOTAR</button>

				  </div>
			</div>
	</div>


@endsection
@section('page-script')

<script src="../../js/printThis.js"></script>
 <link rel="stylesheet" href="{{ asset('css/lolibox.css') }}">
<script src="{{ asset('js/lobibox.js') }}"></script>
 
 
<script>


function imprimir()
{
		var lasPapeletas = JSON.parse(localStorage.getItem("lasboletas{{ $id_evento }}"));
		
							$.ajax({
								url: '{{ url("votacion/coopexe3")}}'  
								, data: { 'campos': JSON.stringify(lasPapeletas) }
								, method: 'post'
								, headers: {
										'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								success: function(result){
											Lobibox.notify('info', {
												msg: 'Gracias por su voto.'
											});		
											//localStorage.setItem('sysvot {{! Session::get('idevendesc') }}', '1');
											setTimeout(function(){ window.location.href = '{{ url("votacion/finalizada")}}' });
								},
								error: function (r) {
										console.log("ERROR");
										console.log(r);
								}
							});
							
}

  
  
function regresar(){
	console.log('regresar');
	//location.href = '{{ url("/")}}';
	window.history.back();
}


	var lasPapeletas='';
function visualizarselecciones()
	{  		
	
	var contenedor = localStorage.getItem("lasboletas{{ $id_evento }}");
	//alert( typeof (contenedor));
	if( contenedor.length <=0)
	{
			location.reload();
			window.history.back();
	}
	else
	{
//alert('contenedor vacio2');
			lasPapeletas = JSON.parse(localStorage.getItem("lasboletas{{ $id_evento }}"));
		  
			$.ajax({
			 url: '{{ url("votacion/categoriaslist") }}' 
			, data: { 'campos': JSON.stringify(lasPapeletas) }
			, method: 'get'
			, success: function(result)
			{
				var html = '';
				$(".DirectivosDir").html(html);
				for (var ii = 0; ii < result.length; ii++)
				{  
					var TodosValoresEntradostemp = $.grep(lasPapeletas, function (n, i) {
						return (n.id_area == result[ii].id_area );
					});
					if((TodosValoresEntradostemp.length) >0){
						
						  html += "<div class='col-md-12 d-flex justify-content-center' ><div class='list-group  col-md-6'><a href='#' class='list-group-item list-group-item-action active'><i class='fa-shield '></i> "+ result[ii].nombrearea +"</a>";	
		
						  for (var i = 0; i < TodosValoresEntradostemp.length; i++){  
					 
							//html += "<li><b style='font-family: Ordinary;font-size: 32px;'> "+ lasPapeletas[i].apellido +'  '  + lasPapeletas[i].nombre + "</b></li>";
							html += "<a href='#' class='list-group-item list-group-item-action'><i class='fa fa-book fa-fw' aria-hidden='true'></i>&nbsp;"+ TodosValoresEntradostemp[i].apellido + " "  + TodosValoresEntradostemp[i].nombre + "</a>";

						  }
						  html+="</div>";  
					}
				  html+="</div><br/>";  
				}

				$('.DirectivosDir').html(html);
			}
		  });
	}
}
	
	
$( document ).ready(function() {

	visualizarselecciones();
		  
	//validando();		  
});	

</script>
@stop
