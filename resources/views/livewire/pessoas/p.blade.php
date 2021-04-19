<html>
<head>
<title>Requerimento_{{$pessoa->id}}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/printer.ico') }}" >

</head>
<body>
<div class="col-12">
            <h2 style="text-align:center">PREFEITURA MUNICIPAL DE {{$pessoa->domain}}</h2>
            <h3 style="text-align:center"><i>{{$pessoa->orgao}}</i></h3>

            <pre><h3 style="height: 130px">
EXMO. SR.
ADMINISTRADOR
SERVIÇOS CEMITERIAIS
<u>NESTA</u>

            </h3></pre>

            <table width="100%">
                <tr><td style="border-bottom: 1px solid #000000;" width="60%"><strong>{{$pessoa->nome}}</strong></td>
                <td style="border-bottom: 1px solid #000000; text-align:right" width="40%">
                    @if(strlen(trim($pessoa->cpf))==14) CPF: @else CNPJ: @endif
                    <strong>{{$pessoa->cpf}}</strong></td></tr>
            </table>
            <div class="col-md-12"><p style="font-size: 18px; font-stretch: expanded">abaixo assinado, residente em {{$pessoa->cidade}}-{{$pessoa->uf}}, vem mui respeitosamente solicitar o ALVARÁ</p>para SEPULTAR</div>
            <div class="col-md-12">
                <div class="col-md-12" style="border-bottom: 1px solid #000000;">
                    <strong> {{$pessoa->falecido}}</strong>

                    {{ (substr($pessoa->falecido,0, 7) == 'NATIMOR' ? ' filho(a) de '.$pessoa->mae : '') }}
                </div>
            </div></br>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-7" style="float: left; ">___________________________________________________</div>

                    <div class="col-md-5" style="float: right; text-align:left;">falecido(a) em <b>{{$pessoa->ex_obito }}</b></div>

                </div>

            </div>

            <br>

            <table width="100%">

                <tr>
                    <td width="80%"><u>aos
                        <strong>{{ $pessoa->idade }}</strong>
                    de idade.</u></td>

                </tr>
                <tr><td width="70%"></td>
                    <td><h5>
                        @if($pessoa->hora_sepultamento )
                            @if($pessoa->hora_sepultamento !== null )
                                Sepultamento às {{$pessoa->hora_sepultamento}} <br>
                                {{($pessoa->dt_sepultamento > $pessoa->dt_obito ? ' do dia '.strftime('%d/%m/%Y', strtotime($pessoa->dt_sepultamento)) : '')}}
                            @endif
                        @else
                            Vai avisar horário
                        @endif
                        </h5>
                    </td>
                </tr>

            </table>

            <table width="100%">
            @foreach ($tipo_sepulturas as $tp)
                <tr>
                    <td width="25%"></td>
                    <td width="5%">{{$tp->tipo}}</td>
                    <td></td>
                    <td style="border-bottom: 1px solid #000000;">
                        <strong>{{ ($tp->id === $pessoa->tipo_id ? 'Quadra: '.$pessoa->quadra.'   Número: '.  $pessoa->numero : 'Não') }}</strong>
                    </td>
                    <td width="5%"></td>
                </tr>
            @endforeach

                <tr>
                    <td width="15%"></td>
                    <td>PERPETUIDADE</td>
                    <td width="0.5%">  </td>
                    <td style="border-bottom: 1px solid #000000;"><strong>{{ ($pessoa->tipo_id===1 ? 'Sim' : ($pessoa->tipo_id===2 ? 'Sim' : 'Não'))}}</strong> </td>
                    <td width="15%"></td>
                </tr>

                <tr>
                    <td width="15%"></td>
                    <td>CEMITÉRIO</td>
                    <td width="0.5%"></td>
                    <td style="border-bottom: 1px solid #000000;"> <strong>{{ $pessoa->cemiterio }}</strong> </td>
                    <td width="15%"></td>
                </tr>
                <tr>
                    <td width="15%"></td>
                    <td>FUNERÁRIA</td>
                    <td width="0.5%"></td>
                    <td style="border-bottom: 1px solid #000000;">  <strong>{{$pessoa->funeraria}} </strong></td>
                    <td width="15%"></td>
                </tr>
            </table>
            <br>
            <div style="margin-left: 25%"> P. deferimento</div><br>
            <div style="margin-left: 25%">
                 <b><u> Ituiutaba, {{$pessoa->hoje}}</u></b>
            </div>
            <p></p><br>
            <table width="100%">
                <tr>
                    <td width=100% style="border-bottom: 1px solid #000000;">Observações:</td>
                {{-- </tr>
                <tr>
                <!--<td height="25px" width=50% style="border-bottom: 1px solid #000000; font-size:11px;">{{$pessoa->obs}} -->
                   <td height="25px" width=50% style="border-bottom: 1px solid #000000; font-size:11px;">TAXA ( R$ <b>{{ number_format($pessoa->valor, 2, ',', '') }}</b> )  REFERENTE {{$pessoa->tipo}}
                     </td>
                </tr>
                <tr>
                    <td height="25px" width=50% style="border-bottom: 1px solid #000000; font-size:11px;"><b>{{$pessoa->endereco}}, {{$pessoa->nro}}</b> </td>
                </tr> 
                <tr>
                    <td height="25px" width=50% style="border-bottom: 1px solid #000000; font-size:11px;">Bairro: <b>{{$pessoa->bairro}}</b>&nbsp;&nbsp;&nbsp; - &nbsp; <b>{{$pessoa->cidade}}-{{$pessoa->uf}} &nbsp;&nbsp;&nbsp;&nbsp; {{($pessoa->cep ? 'CEP: '.$pessoa->cep : '')}}  </b>

                    </td>
                </tr>--}}
                <tr>
                    <td height="25px" width=50% style="border-bottom: 1px solid #000000; font-size:11px;">
                        {{-- Telefone(s): --}}
                    {{-- <b>{{$pessoa->telefone.' '.$pessoa->celular1.' '.$pessoa->celular2}} </b> --}}
                        {!! $pessoa->obs !!}
                    </td>
                </tr>

            </table>
            <br><br>

            <table width="100%">
                <tr><td width=40% style="border-top: 1px solid #000000; float:left; text-align:center; font-size:12px;">{{$pessoa->name}}</td><td width=5%></td>
                <td width=40% style="border-top: 1px solid #000000; float:right; text-align:center; font-size:10px;">{{$pessoa->nome}}</td>
                </tr>
                <tr><td width=40% style="float:left; text-align:center;">Encarregado</td><td width=5%></td>
                <td width=40% style="float:left; text-align:center;">Requerente</td>
                </tr>

            </table>
        </div>

</body>
</html>
