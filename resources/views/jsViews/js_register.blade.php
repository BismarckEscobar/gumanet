<script type="text/javascript">
	$(document).ready(function() {
	    //AGREGO LA RUTA AL NAVEGADOR
	    $("#item-nav-01").after(`<li class="breadcrumb-item"><a href="Usuario">Usuario</a></li><li class="breadcrumb-item active">Registro</li>`);
	    
	});
//$('select').selectpicker();

	$('#company').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
  	$('#company_values').val( $('#company').val());
});

</script>