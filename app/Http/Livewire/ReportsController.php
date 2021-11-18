<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Pessoa;
use App\Models\Cemiterio;
use Carbon\Carbon;

class ReportsController extends Component
{
    public $componentName, $data, $cemiterios, $userid, $dateFrom, $dateTo, $cemiterioid;

    public function mount()
    {
        $this->componentName = '';
        $this->data = [];
        $this->userid = '';

        if(auth()->user()) 
        $this->userid = auth()->user()->id;

        $this->cemiterioid = 0;
        $this->dateFrom = '';//Carbon::parse('01-01-1930')->format('Y-m-d').' 00:00:00';
        $this->dateTo = '';
        $this->cemiterios = Cemiterio::orderBy('nome', 'asc')->get();
    }

    public function render()
    {
        $this->reportByDate();

        return view('livewire.reports.component')
        ->extends('layouts.template')->section('content');
    }

    public function reportByDate()
    {
        $from = Carbon::parse($this->dateFrom)->format('Y-m-d');
        $to = Carbon::parse($this->dateTo)->format('Y-m-d');

        if($this->cemiterioid == 0){            
            $this->data = Pessoa::join('cemiterios as c', 'c.id', 'pessoas.cemiterio_id')
            ->select('pessoas.*','c.nome as cemiterio')
            ->whereBetween('pessoas.dt_obito', [$from, $to])
            ->get();
        } else {
            $this->data = Pessoa::join('cemiterios as c', 'c.id', 'pessoas.cemiterio_id')
            ->select('pessoas.*','c.nome as cemiterio')
            ->whereBetween('pessoas.dt_obito', [$from, $to])
            ->where('cemiterio_id', $this->cemiterioid)
            ->get();
        }
    }

    public function getDetails($id){
        
        return;
    }
}
