<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{$inventory->name}}</title>
</head>
<body>
	<h3 style="text-align: center">{{$inventory->name}}</h3>
	<h4 style="text-align: center">{{$inventory->kasi->section->name}} - {{$inventory->kasi->name}}</h4>
	
	<table>
		@php $i = 0 @endphp
		<tr>
			@foreach ($inventory->details as $item)
			{{-- <td style="text-align:center; width:184px!important; border:1px solid black; padding-left:44px; padding-top:20px"> --}}
				{{-- {!!DNS2D::getBarcodeHTML(route('inventoryview', $item->barcode), 'QRCODE', 5, 5)!!} --}}
				<td style="text-align: center; width:184px!important; border:1px solid black; padding-top:50px!important">
				<?php echo '<img style="margin:0!important; padding:0!important" src="data:image/png;base64,' . DNS2D::getBarcodePNG(route('inventoryview', $item->barcode), 'QRCODE', 5, 5) . '" alt="barcode"   />' ?>
				<br><b>{{$item->barcode}}</b>
			</td>
			@php $i++ @endphp
			@if($i % 3 == 0)
		</tr>
		<tr>
			@endif
			@endforeach
		</tr>
	</table>
	
	
</body>
</html>