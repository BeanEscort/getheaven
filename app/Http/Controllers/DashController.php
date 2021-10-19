<?php

namespace App\Http\Controllers;

use App\Models\Cemiterio;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{

    public function data()
    {

        $currentYear = date('Y');
        $start = date('Y-m-d', strtotime('monday this week'));
        $finish = date('Y-m-d', strtotime('sunday this week'));

        $d1 = strtotime($start);
        $d2 = strtotime($finish);

         $array = array();
         for($currentDate = $d1; $currentDate <= $d2; $currentDate +=(86400))
         {
            $dia = date('Y-m-d', $currentDate);
            $array[] = $dia;
         }


         $sql = "SELECT c.dt_sepultamento, IFNULL(c.total,0) as total FROM(
            SELECT '$array[0]' as dt_sepultamento
            UNION
            SELECT '$array[1]' as dt_sepultamento
            UNION
            SELECT '$array[2]' as dt_sepultamento
            UNION
            SELECT '$array[3]' as dt_sepultamento
            UNION
            SELECT '$array[4]' as dt_sepultamento
            UNION
            SELECT '$array[5]' as dt_sepultamento
            UNION
            SELECT '$array[6]' as dt_sepultamento

            ) d
            LEFT JOIN(
                SELECT COUNT(*) as total, DATE(dt_sepultamento) as dt_sepultamento FROM pessoas WHERE dt_sepultamento BETWEEN '$start' AND '$finish' GROUP BY DATE(
                    dt_sepultamento)
            ) c ON d.dt_sepultamento = c.dt_sepultamento";

        $weekSales = DB::select(DB::raw($sql));

        $chartMortesxSemana = new LarapexChart();
        $chartMortesxSemana->setTitle('Sepultamentos Semana Atual')
        ->setLabels(['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'])
        ->setType('donut')
        ->setDataset([intval($weekSales[0]->total),
        intval($weekSales[1]->total),
        intval($weekSales[2]->total),
        intval($weekSales[3]->total),
        intval($weekSales[4]->total),
        intval($weekSales[5]->total),
        intval($weekSales[6]->total)
        ]);

        $sql = "SELECT m.MONTH as mes, IFNULL(c.falecidos, 0) as FALECIDOS
        FROM( SELECT 'January' as MONTH
        UNION
        SELECT 'February' as MONTH
        UNION
        SELECT 'March' as MONTH
        UNION
        SELECT 'April' as MONTH
        UNION
        SELECT 'May' as MONTH
        UNION
        SELECT 'June' as MONTH
        UNION
        SELECT 'July' as MONTH
        UNION
        SELECT 'August' as MONTH
        UNION
        SELECT 'September' as MONTH
        UNION
        SELECT 'October' as MONTH
        UNION
        SELECT 'November' as MONTH
        UNION
        SELECT 'December' as MONTH) m
        LEFT JOIN(SELECT MONTHNAME(dt_obito) as MONTH, COUNT(*) as falecidos FROM pessoas WHERE YEAR(dt_obito) = $currentYear GROUP BY MONTHNAME(dt_obito), MONTH(dt_obito) ORDER BY MONTH(dt_obito)) c ON m.MONTH = c.MONTH ";

        $falecidosMes = DB::select(DB::raw($sql));

        $chartMortesxMes = (new LarapexChart)->setType('area')
        ->setTitle('Sepultamentos Anuais')
        ->setSubTitle('Por Mês')
        ->setGrid(true)
        ->setXAxis(['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'])
        ->setDataset([
            [
                'name' => 'Sepultamentos',
                'data' =>
                [
                    $falecidosMes[0]->FALECIDOS,
                    $falecidosMes[1]->FALECIDOS,
                    $falecidosMes[2]->FALECIDOS,
                    $falecidosMes[3]->FALECIDOS,
                    $falecidosMes[4]->FALECIDOS,
                    $falecidosMes[5]->FALECIDOS,
                    $falecidosMes[6]->FALECIDOS,
                    $falecidosMes[7]->FALECIDOS,
                    $falecidosMes[8]->FALECIDOS,
                    $falecidosMes[9]->FALECIDOS,
                    $falecidosMes[10]->FALECIDOS,
                    $falecidosMes[11]->FALECIDOS,
                ]
            ]
        ]);
        $cemit=[];
        $listParque=[];
        $cemiterio = Cemiterio::get();
        $lC = $cemiterio->count();

        for($c=0; $c < $lC; $c++){

            $cemit_id = $cemiterio[$c]->id;

            for ($i=0 ; $i < 12 ; $i++ ) {
                $listParque[$c][$i] = Pessoa::where('cemiterio_id', $cemit_id)->whereMonth('dt_obito', $i+1)->whereYear('dt_obito', $currentYear)->count('*');
            }

            $cemit[] = [
                'name' => $cemiterio[$c]->nome,
                'data' => $listParque[$c]
            ];


        }


       $chartFalecidosxMes = (new LarapexChart)->setTitle('Sepultamentos por ano')
        ->setType('bar')
        ->setXAxis(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'])
        ->setGrid(true)
        ->setColors(['#0000FF', '#FF0000', '#00FF7F', '#4B0082', '#FF8C00', '#FFFF00'])
        ->setDataset(
            $cemit,

        );

        return view('dash', compact('chartMortesxSemana', 'chartMortesxMes', 'chartFalecidosxMes', 'tenantName'));

    }
}
