<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório Ordem Alfbética</title>

    <link rel="stylesheet" href="{{URL::asset('/bootstrap/css/bootstrap.min.css') }}">
</head>

<body>
    <div class="col-12">
        <h3 style="text-align:center">PREFEITURA MUNICIPAL DE {{$domain}}</h3>
        <h4 style="text-align:center; font-size: 18px;"><i>{{$orgao}}</i></h4>
        <br>
        
        <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
            <thead>
                <tr>
                    
                    <th  align="left" class="">NOME</th>
                    <th class="">QUADRA</th>
                    <th class="">NÚMERO</th>
                    <th class="">FALECIDO EM</th>

                </tr>
            </thead>
            <tbody>
                @foreach($info as $r)
                <tr style="font-size:11px;">
                    <td width='300'>{{$r->nome}}</td>
                    <td align="center" width='50'>{{$r->quadra}}</td>
                    <td align="right" width='70'>{{$r->numero}}</td>
                    <td align="right" width='100'>{{\Carbon\Carbon::parse($r->dt_obito)->format('d/m/Y')}}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
