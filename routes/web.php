<?php
header('Access-Control-Allow-Origin: *');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\PdfController;
use App\Http\Livewire\ReportsController;
use App\Http\Controllers\ExportController;
use App\Models\Pessoa;
use App\Models\Tipo;
use Carbon\Carbon;

use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get("email", [MailerController::class, "email"])->name("email");

Route::post("send-email", [MailerController::class, "composeEmail"])->name("send-email");

Route::get('/apresentacao', function () {
    return view('apresentacao');
})->name('apresentacao');
*/
//Route::view('/404.tenant', 'errors.404.tenant')->name('404.tenant');

	Route::get('/apresentacao',[ContactController::class,'index'])->name('apresentacao');
	Route::post('/apresentacao', [ContactController::class,'saveMessage'])->name('apresentacao');


Route::domain('admin.getheaven.com.br')->middleware(['auth'])->group(function() {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/pages', function() {
        return view('admin.pages');
    })->name('pages');

    Route::resource('empresas', EmpresasController::class);

    Route::get('/', function () {
        return view('dashboard');
    });
});

Route::domain('{tenant}.getheaven.com.br')->middleware('tenant')->group(function(){
    Route::get('/', function ($tenant) {        
        return view('index');
    });

    Route::middleware(['auth:sanctum'])->group(function(){
    
    	Route::get('/dashboard', function ($tenant) {
        	if($tenant != 'admin'){
            		Route::view('dash', 'dash');
        	} else {
            		return view('dashboard');
		}
   	});
    });


Route::group(['middleware' => 'auth'], function() {
    Route::view('dash', 'dash');
    Route::view('causas', 'causas');
    Route::view('cemiterios', 'cemiterios');
    Route::view('funerarias', 'funerarias');
    Route::view('pessoas', 'pessoas');
    Route::view('clientes', 'clientes');
    Route::view('requerimento', 'requerimento');
    Route::view('reservas','reservas');
    Route::view('ufirs', 'ufirs'); //->middleware('permission:ufirs_index');
    Route::view('taxas', 'taxas'); //->middleware('permission:taxas_index');
    Route::view('report', 'report');
    Route::view('permissoes', 'permissoes');
    Route::view('usuarios', 'usuarios');

    Route::get('reports', ReportsController::class);
    Route::get('reports/pdf/{user}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
    Route::get('reports/pdf/geraPdf/{f1}', [ExportController::class, 'geraPDF']);

    Route::get('reports/excel/{user}/{f1}/{f2}', [ExportController::class, 'reportExcel']);
//    Route::get('reports/excel/geraPdf/{f1}', [ExportController::class, 'geraPDF']);
  //  Route::get('/geraPdf/{id}', [PdfController::class, 'geraPdf']);
//    Route::get('/pdf/{d1}/{d2}', [PdfController::class, 'reportPDF']);
});
    Route::get('/reservas/{id}', [PdfController::class, 'reservaPdf']);
//});
    Route::get('/pdf/{d1}/{d2}', [PdfController::class, 'reportPDF']);

    Route::get('/pdf/{id}', function ($tenant, $id) {

        $mes = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];
        $tipo_sepulturas = Tipo::get();
        $requerimento = Pessoa::leftjoin('clientes as cli', 'cli.id','pessoas.cliente_id')
                    ->leftjoin('cemiterios as c', 'c.id', 'pessoas.cemiterio_id')
                    ->leftjoin('funerarias as f', 'f.id', 'pessoas.funeraria_id')
                    ->leftjoin('taxas as t', 't.id', 'pessoas.taxa_id')
                    ->leftjoin('tipo_sepulturas as ts', 'ts.id', 'pessoas.tipo_id')
                    ->leftjoin('users as u', 'u.id', 'cli.user_id')
                    ->select('pessoas.nome as falecido', 'pessoas.dt_obito', 'pessoas.dt_sepultamento','pessoas.idade', 'pessoas.tipo_id',
                    'pessoas.quadra', 'pessoas.numero', 'pessoas.mae' , 'pessoas.hora_sepultamento', 'pessoas.obs' , 'cli.*', 'c.nome as cemiterio',
                     'f.nome as funeraria', 't.tipo', 't.valor', 'ts.tipo as tp_sepultura', 'u.name', 'u.domain', 'u.orgao')
                    ->where('pessoas.id', $id)
                    ->get();

        if(!isset($requerimento)) {
            session()->flash('msg-error', 'Nenhum registro foi encontrado.');
            return redirect()->back();
        }
        $pessoa = $requerimento[0];
        if(! $pessoa->cpf)
        {
            session()->flash('msg-error', 'O Requerente não foi encontrado, complete os dados antes de  continuar.');
            return redirect()->back();
        }

        $pessoa->cpf = cpf($pessoa->cpf);
        $pessoa->telefone = fone($pessoa->telefone);
        $pessoa->celular1 = fone($pessoa->celular1);
        $pessoa->celular2 = fone($pessoa->celular2);
        if($pessoa->cep) {
            $pessoa->cep = cep($pessoa->cep);
        }

        if($pessoa->hora_sepultamento != null)
            $pessoa->hora_sepultamento = \Carbon\Carbon::parse($pessoa->hora_sepultamento)->format('H:i');

        $dia =  date('d', strtotime($pessoa->dt_obito));
        $mesn = date('m', strtotime($pessoa->dt_obito));
        $ano  = date('Y', strtotime($pessoa->dt_obito));

        $now = Carbon::now()->format('Y-m-d');

        $d = date('d', strtotime($now));
        $m = date('m', strtotime($now));
        $a = date('Y', strtotime($now));

        //$mesAtual = date('m', $now);

        $mesn = (int)$mesn-1;
        $m = (int)$m-1;

        $pessoa->hoje = $d.' de '.$mes[$m].' de '.$a;

        $pessoa->ex_obito = $dia.' de '.$mes[$mesn].' de '.$ano;

        $fileName = time().$pessoa->cpf.date("dmY");


        return PDF::loadView('livewire.pessoas.pessoas', compact('pessoa', 'tipo_sepulturas'))
		->setPaper('a4', 'portrait')
                ->stream($fileName.'.pdf');


    });

    Route::get('/pdf/{ini?}}', function($tenant, $ini = 0) {
        if($ini===0) {
            session()->flash('msg-error', 'Data de Início e Fim devem ser digitados.');
            return redirect()->back()
            ->with('msg-error', 'Data de Início e Fim devem ser digitados.');
        }
//dd($ini);
       $arr_data = explode("/","-",$ini);
       $ini = Carbon::parse($ini)->format('Y-m-d');
        
        $fim = Carbon::parse($fim)->format('Y-m-d');

        $user_id = auth()->user()->id;
        $domain = auth()->user()->domain;
        $orgao = auth()->user()->orgao;

        $info = Pessoa::leftjoin('cemiterios as c','c.id','pessoas.cemiterio_id')
                    ->leftjoin('users as u', 'u.id', 'pessoas.user_id')
                    ->select('pessoas.*', 'c.nome as cemiterio' )
                    ->whereBetween('pessoas.dt_obito', [$ini, $fim])->orderBy('dt_obito', 'asc')->get();

        $fileName = time().date("dmY");
        return PDF::loadView('livewire.relatorios.ordem_alfabetica', compact('info', 'domain', 'orgao'))
                ->setPaper('a4', 'landscape')
                ->stream($fileName.'.pdf');
    });
  });
//});

 /*   function CpfCnpj($cpf) {

        if(strlen($cpf) == 0) return '';


        if (strlen(trim($cpf)) == 11) {

            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9);

        }

        elseif (strlen(trim($cpf)) == 14) {

            return substr($cpf, 0, 2) . '.' . substr($cpf, 2, 3) . '.' . substr($cpf, 5, 3) . '/' . substr($cpf, 8, 4) . '-' . substr($cpf, 12, 2);

        }

        return $cpf;

     }

     function cep($cep)
    {
        if (!$cep) { return '';}

        if (strlen($cep) == 8) {

            return substr($cep, 0, 2).'.'.substr($cep, 2, 3).'-'.substr($cep,5, 3);

        }
    }

     function fone($fone) {

        if (!$fone) {

            return '';

        }

        $fone = trim($fone);

        if (strlen($fone) == 8) {

            return substr($fone, 0, 4).'-'.substr($fone, 4, 4);

        }

        if (strlen($fone) == 9) {

            return substr($fone, 0, 5).'-'.substr($fone, 5);

        }

        if (strlen(trim($fone)) == 10) {

            return '(' . substr($fone, 0, 2) . ') ' . substr($fone, 2, 4) . '-' . substr($fone, 6);

        }

        if (strlen(trim($fone)) == 11) {
            if(substr($fone, 0, 1) != '0'){
                return '(' . substr($fone, 0, 2) . ') ' . substr($fone, 2, 5) . '-' . substr($fone, 7);
            }
        }

        if (strlen(trim($fone)) == 11) {
            if(substr($fone, 0, 1) == '0'){
                return '(' . substr($fone, 1, 2) . ') ' . substr($fone, 2, 5) . '-' . substr($fone, 7);
            }
        }

        return $fone;

    }
*/
