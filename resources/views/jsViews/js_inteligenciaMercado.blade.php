<script>
$(document).ready(function() {
	fechas = {};
	$('#dom-id').dateRangePicker({
		language: 'es',
		singleMonth: true,
		showShortcuts: false,
		startOfWeek: 'monday',
		separator : ' al ',
		showTopbar: false,
		autoClose: true,
		setValue: function(s,s1,s2) {
			setFechas(s1, s2)
		}
	});
});

var fechas = {};

$(document).on('click', '.pagination a', function (e) {
	e.preventDefault();
	var page = $(this).attr('href').split('page=')[1];
	fetch_data(page);
});

$(document).on('change', '#orderByDate', function (e) {
	fetch_data(1)
})

$(document).on('keyup','#search', function (event) {
	fetch_data(1);
 });

function setFechas(f1, f2) {
	fechas = { fecha1:f1, fecha2:f2 };
	fetch_data(1);
}

function fetch_data(page) {
	var base_url = window.location.origin + '/' + window.location.pathname.split ('/') [1] + '/';

		value 		= $('#search').val();
		valueDate 	= $('#orderByDate').val();
		fechas_		= fechas;

		$.ajax({
			type : 'post',
			url: 'paginateDataSearch',
			data:{ 'search':value, 'date':valueDate, 'page':page, 'fechas':fechas_ },
			success:function(data) {
				
				if (data.length=='') {
					$('.comentarios').html(`<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<p class="text-center font-weight-bolder">No se encontraron registros</p>
									<center><img src="./images/icon_sinresultados.png" width="100" class="mt-4 mb-4" /></center>
								</div>
							</div>
						</div>
						</div>`);
					
				}else {
					$('.comentarios').html(data);
				}				
			}
		});
}

$(document).on('mouseenter','.card', function (event) {
    $( this ).removeClass('border-light').addClass('border-primary')
}).on('mouseleave','.card',  function(){
	$( this ).removeClass('border-primary').addClass('border-light')
});

</script>