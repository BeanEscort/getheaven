<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Requerimento_{{$pessoa->id}}</title>
    
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    

</head>
<body style="font-size: 16px">
    
        <div class="col-12">
            <h3 style="text-align:center">PREFEITURA MUNICIPAL DE {{$pessoa->cidade}}</h3>
            <h5 style="text-align:center"><i>Secretaria municipal de Obras e Serviços Urbanos</i></h5>        
            <br>
            <pre><h5>
EXMO. SR.

ADMINISTRADOR 

SERVIÇOS CEMITERIAIS 

<u>NESTA</u>

            </h5></pre>
            
            <table width="100%">
                <tr><td style="border-bottom: 1px solid #000000;" width="60%"><strong>{{$pessoa->nome}}</strong></td>
                <td style="border-bottom: 1px solid #000000; text-align:right" width="40%">
                    @if(strlen(trim($pessoa->cpf))==14) CPF: @else CNPJ: @endif                    
                    <strong>{{$pessoa->cpf}}</strong></td></tr>
            </table><br>
            <p>abaixo assinado, residente em {{$pessoa->cidade}}-{{$pessoa->uf}}, vem mui respeitosamente solicitar o ALVARÁ <br>para SEPULTAR</p>
            <table width="100%">
                <tr>
                    <td  colspan="2" width="100%" style="border-bottom: 1px solid #000000;"> 
                        <strong> {{$pessoa->falecido}}</strong>
                        
                        {{ (substr($pessoa->falecido,0, 7) == 'NATIMOR' ? ' filho(a) de '.$pessoa->mae : '') }}
                    </td>
                </tr>                
                <tr>
                    <td colspan="1" width="30%" style="border-bottom: 1px solid #000000; text-align:right;"></td>
                    <td colspan="1" width="70%">falecido(a) em <b style="text-align:right;">{{$pessoa->ex_obito }}</b>                        
                    </td>                    
                </tr>
                <tr>
                    <td width="80%"><u>aos 
                        <strong>{{ $pessoa->idade }}</strong>
                    de idade.</u></td>
                    <td></td>
                </tr>  
                <tr><td width="80%"></td>
                    <td><h6>
                        @if($pessoa->hora_sepultamento )
                            @if($pessoa->hora_sepultamento !== null )
                                Sepultamento às {{$pessoa->hora_sepultamento}} <br>
                                {{($pessoa->dt_sepultamento > $pessoa->dt_obito ? ' do dia '.strftime('%d/%m/%Y', strtotime($pessoa->dt_sepultamento)) : '')}}
                            @endif
                        @else                            
                            Vai avisar horário 
                        @endif
                        </h6>                  
                    </td>
                </tr>
                              
            </table>  
            
            <table width="100%">
                
                <tr>
                    <td width="25%"></td>
                    <td width="5%">COVA RASA</td>
                    <td></td>
                    <td style="border-bottom: 1px solid #000000;"><strong>{{ $pessoa->tp_sepultura=='RASA ADULTO' || $pessoa->tp_sepultura=='RASA CRIANÇA' ? 'Quadra: '.$pessoa->quadra.'   Número: '.  $pessoa->numero : 'Não' }}</strong></td>
                    <td width="5%"></td>
                </tr>
                <tr>
                    <td width="15%"></td>
                    <td>PERPETUIDADE</td>
                    <td width="0.5%">  </td>
                    <td style="border-bottom: 1px solid #000000;"><strong>{{ $pessoa->tp_sepultura=='CARNEIRO' ? 'Sim' : ($pessoa->tp_sepultura=='GALERIA' ? 'Sim' : 'Não')}}</strong> </td>
                    <td width="15%"></td>
                </tr>
                <tr>
                    <td width="15%"></td>
                    <td>CARNEIRO</td>
                    <td width="0.5%"></td>
                    <td style="border-bottom: 1px solid #000000;"> <strong> {{ ($pessoa->tp_sepultura=='CARNEIRO' ? 'Quadra: '. $pessoa->quadra .'    Número: '.$pessoa->numero : 'Não')}} </strong></td>
                    <td width="15%"></td>
                </tr>
                <tr>
                    <td width="15%"></td>
                    <td>GALERIA</td>
                    <td width="0.5%"></td>
                    <td style="border-bottom: 1px solid #000000;"><strong>{{ ($pessoa->tp_sepultura=='GALERIA' ? 'Quadra:  '. $pessoa->quadra. '   Número: '. $pessoa->numero : 'Não')}}</strong></td>
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
                </tr>
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
                </tr>
                <tr>
                    <td height="25px" width=50% style="border-bottom: 1px solid #000000; font-size:11px;">Telefone(s):   
                    <b>{{$pessoa->telefone.' '.$pessoa->celular1.' '.$pessoa->celular2}} </b>
                     
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
