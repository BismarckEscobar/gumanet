<script type="text/javascript">
	
$( "#cmbRutas").change(function() {
	tBody = "";
	$("#tBody")
	.empty()
	.append(`<tr><td colspan='2'>Cargando...</td></tr>`)

	$("#noVencido")
	.empty()
	.append(`Cargando...`)
	ruta = $(this).val();
	
	$.ajax({
		url: 'saldoxRuta',
		type: 'POST',
		async: true,
		data: {ruta: ruta},
		success: function(response) {
			if (response) {
				tBody = `
                  <tr>
                    <td>30 Días</td>
                    <td>C$<span class="float-right">`+numeral(response[0]['Dias30']).format('0,0.00')+`</span></td>
                  </tr>
                  <tr>
                    <td>60 Días</td>
                    <td>C$<span class="float-right">`+numeral(response[0]['Dias60']).format('0,0.00')+`</span></td>
                  </tr>
                  <tr>
                    <td>90 Días</td>
                    <td>C$<span class="float-right">`+numeral(response[0]['Dias90']).format('0,0.00')+`</span></td>
                  </tr>
                  <tr>
                    <td>120 Días</td>
                    <td>C$<span class="float-right">`+numeral(response[0]['Dias120']).format('0,0.00')+`</span></td>
                  </tr>
                  <tr>
                    <td>Más de 120 Días</td>
                    <td>C$<span class="float-right">`+numeral(response[0]['Mas120']).format('0,0.00')+`</span></td>
                  </tr>`;
			}

			$("#tBody")
			.empty()
			.append(tBody);

			$("#noVencido")
			.empty()
			.append(`C$ `+numeral(response[0]['N_VENCIDOS']).format('0,0.00'))
		}
	})
})


</script>