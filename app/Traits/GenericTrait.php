<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Model\Pessoa;

Trait GenericTrait
{
    
    public function buscaCep()
    { 
        $this->logradouro = 'Buscando dados...';
        
        if(strval($this->cep) > 0)
        if(strlen($this->cep) > 8)
        $this->cep = preg_replace('/[^0-9]/', '', $this->cep);
        $cep = $this->cep;
        if(strlen($cep) === 8) {
    
            $url = "http://viacep.com.br/ws/$cep/xml/";  
           // if(simplexml_load_file($url))
                $xml = simplexml_load_file($url);

            if($xml->logradouro == ""){
                
                $this->emit('msg-error', 'CEP não localizado...');
                return false;
            }
            $this->cep = $this->cep($cep);
            $this->logradouro   = $this->converteMaiusculo($xml->logradouro);
            $this->complemento  = $this->converteMaiusculo($xml->complemento);
            $this->bairro       = $this->converteMaiusculo($xml->bairro);
            $this->localidade   = $this->converteMaiusculo($xml->localidade);
            $this->uf           = $this->converteMaiusculo($xml->uf);
            //$this->doAction(2);
             
            return $this->cep;
        }
    }  

    public function retiraTracos()
    {
        $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
        $this->cep = preg_replace('/[^0-9]/', '', $this->cep);
        $this->telefone = preg_replace('/[^0-9]/', '', $this->telefone);
        $this->celular1 = preg_replace('/[^0-9]/', '', $this->celular1);
        $this->celular2 = preg_replace('/[^0-9]/', '', $this->celular2);
    }

    public function fone($fone) {

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

    public function cep($cep)
    {
        if (!$cep) { return '';}

        if (strlen($cep) == 8) {
    
            return substr($cep, 0, 2).'.'.substr($cep, 2, 3).'-'.substr($cep,5, 3);            
    
        }
    }

    public function CpfCli($cpf) {

        if (!$cpf) {
     
            return '';
     
        }

        $cpf = preg_replace('/[^0-9]/', '', $cpf);
     
        if (strlen(trim($cpf)) == 11) {
     
            return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
     
        }
     
        elseif (strlen(trim($cpf)) == 14) {

            return substr($cpf, 0, 2) . '.' . substr($cpf, 2, 3) . '.' . substr($cpf, 5, 3) . '/' . substr($cpf, 8, 4) . '-' . substr($cpf, 12, 2);

        }

        return $cpf;
     
     }

    public function ValidaCpf($value)
    {
        $c = preg_replace('/\D/', '', $value);

        if (strlen($c) == 11) {
            if (strlen($c) != 11 || preg_match("/^{$c[0]}{11}$/", $c)) {
                return false;
            }
    
            for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);
    
            if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
                return false;
            }
    
            for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);
        
            if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
                return false;
            }
        
            return true;

        } 
        $b = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        if (strlen($c) != 14) {
            return false;

        } 

        // Remove sequências repetidas como "111111111111"
        // https://github.com/LaravelLegends/pt-br-validator/issues/4

        elseif (preg_match("/^{$c[0]}{14}$/", $c) > 0) {
            return false;
        }

        for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);

        if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);

        if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) {
            return false;
        }

        return true;
    }

    public function converteMaiusculo($string) {        
        $string = strtoupper ($string);
        $string = str_replace ("â", "Â", $string);
        $string = str_replace ("á", "Á", $string);
        $string = str_replace ("ã", "Ã", $string);
        $string = str_replace ("à", "A", $string);
        $string = str_replace ("ê", "Ê", $string);
        $string = str_replace ("é", "É", $string);
        $string = str_replace ("Î", "I", $string);
        $string = str_replace ("í", "Í", $string);
        $string = str_replace ("ó", "Ó", $string);
        $string = str_replace ("õ", "Õ", $string);
        $string = str_replace ("ô", "Ô", $string);
        $string = str_replace ("ú", "Ú", $string);
        $string = str_replace ("Û", "U", $string);
        $string = str_replace ("ç", "Ç", $string);
        return $string;
        }
}