<?php

namespace App\Exports;

use App\Models\Pessoa;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PessoasExport implements FromCollection, WithColumnFormatting,WithMapping,WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{
	protected $userId, $dateFrom, $dateTo;

	public function __construct($userId, $f1, $f2){

		$this->userId = $userId;
		$this->dateFrom = $f1;
		$this->dateTo = $f2;
	}

    public function collection()
    {
        $data = [];
	
	$from = Carbon::parse($this->dateFrom)->format('Y-m-d');
	$to = Carbon::parse($this->dateTo)->format('Y-m-d');
    
	if($this->userId == 0){
		$data = Pessoa::join('cemiterios as c', 'c.id', 'pessoas.cemiterio_id')
			->select('pessoas.nome','pessoas.quadra','pessoas.numero','pessoas.dt_obito','c.nome as cemiterio')
			->whereBetween('pessoas.dt_obito', [$from, $to])
			->orderBy('dt_obito', 'asc')
			->get();
	} else {
		 $data = Pessoa::join('cemiterios as c', 'c.id', 'pessoas.cemiterio_id')
                        ->select('pessoas.nome','pessoas.quadra','pessoas.numero','pessoas.dt_obito','c.nome as cemiterio')
                        ->whereBetween('pessoas.dt_obito', [$from, $to])
			->where('pessoas.cemiterio_id', $this->userId)
			->orderBy('dt_obito', 'asc')
                        ->get();
	}

	return $data;
    }

    public function headings(): array
    {
	return ["NOME","QUADRA", "NUMERO", "DATA OBITO", "CEMITERIO"];
    }

    public function startCell(): string
    {
	return 'A2';
    }

    public function styles(Worksheet $sheet)
    {
	$sheet->getStyle('A2:E2')
            ->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('51d2b7');

	$sheet->getStyle('A2:E2')
            ->getFont()
            ->setBold(true)
            ->getColor()
            ->setRGB('ffffff');
    }

    public function title(): string
    {
	return 'Relatorio data Obito';
    }

    public function map($row): array
    {
	return [
		$row->nome,
		$row->quadra,
		$row->numero,
		Date::dateTimeToExcel($row->dt_obito),
		$row->cemiterio,
	];
    }

    public function columnFormats(): array
    {
	return [
	    'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}

