<!DOCTYPE html>
<html>
<head>
	<title>Envio de retencion</title>
</head>
<body>
	<p>Saludos. Realizamos envio de retencion para la(s) siguiente(s) factura(s):</p>
	@foreach ($detailret as $d)
			<p>Factura N°: {{ $d->purchase_num }}. </p>	
	@endforeach
	
</body>
</html>