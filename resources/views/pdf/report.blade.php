
<html>
<head>
    <title>Relatório por data de {{$dateFrom}} até {{$dateTo}}</title>

    <link type="text/css" href="{{ public_path('css/custom_pdf.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ public_path('css/custom_page.css') }}"> 
    <style>
    	@page { margin: 180px 50px; }
    	#header { position: fixed; left: 0px; top: -160px; right: 0px; height: 130px; background-color: white; text-align: center; }
    	#footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px; }
    	#footer .page:after { content: counter(page, upper-roman); }
    </style>
</head>
<body>
<section id="header">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td colspan="2" class="text-center">
				<span style="font-size: 25px; font-weight: bold;">PREFEITURA MUNICIPAL DE {{auth()->user()->domain}}</span>
			</td>
		</tr>
		<tr>
			<td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
				<img src="{{ asset('storage/' . Auth::user()->logo) }}" alt="" class="invoice-logo" width="100px" height="100px">
			</td>
			<td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 10px;">
                                <span style="font-size: 22px"><strong>{{auth()->user()->orgao}}</strong></span>
				<br><br>
				<span style="font-size: 16px"><strong>Data da Consulta: {{$dateFrom}} até {{$dateTo}}</strong></span>

                        </td>
		</tr>
	</table>
</section>

<section id="footer">
<table cellpadding="0" cellspacing="0" class="table-items" width="100%">
        <tr>
                <td width="30%">
                        <span>Sistema de Cemitérios 2010 - {{\Carbon\Carbon::parse(now())->format('Y')}}<span>
                </td>
                <td width="40%" class="text-center">Usuário: {{auth()->user()->name}}</td>
                <td width="30%" class="text-right">
                Página <span class="pagenum"></span>
                </td>
        </tr>
</table>
</section>

<section id="content">
	<table cellpadding="0" cellspacing="0" class="table-items" width="100%">
		<thead>
			<tr>
				<th width="40%">NOME</th>
				<th width="10%">QUADRA</th>
				<th width="10%">NÚMERO</th>
				<th width="15%">DT ÓBITO</th>
				<th width="25%">CEMITÉRIO</th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $item)
			<tr>
				<td align="left">{{$item->nome}}</td>
				<td align="center">{{$item->quadra}}</td>
				<td align="center">{{$item->numero}}</td>
				<td align="center">{{\Carbon\Carbon::parse($item->dt_obito)->format('d-m-Y')}}</td>
				<td align="center">{{$item->cemiterio}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

</body>
</html>

