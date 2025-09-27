<?php

namespace App\Imports;

use App\Models\RhDirectoryTmp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\RefTable;



class RhDirectoryImport implements ToModel, WithStartRow
{

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    public function getGroupe($level){
        if($level == 'HE')
        {
            return 1;
        }
        elseif($level == 11){
            return 2;
        }
        elseif(in_array($level, [8, 9, 10])){
            return 3;
        }
        elseif(in_array($level, [5, 6, 7])){
            return 4;
        }

        return null;
    }

    public function getDateFormat($val){

        $val = str_replace('/', '-', $val);        
        if(is_numeric($val)){
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val)->format('Y-m-d');
        }
        else if(strlen(trim($val)) > 8){
            return date('Y-m-d', strtotime(trim($val)));
        }
        
        return null;
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   
        if (count($row) === 11) {
            for($i=0; $i<count($row); $i++){
                $row[$i] = trim($row[$i]);
            }
            if(strlen($row[2]) > 2){
                return new RhDirectoryTmp([
                    'budget_type' => ( $row[0] =="عامة") ? 1  : 2,
                    'rent_number' => $row[1],
                    'cin' => str_replace(' ', '', $row[2]),
                    'first_name' => $row[3],
                    'last_name' => $row[4],
                    'first_name_fr' => $row[5],
                    'last_name_fr'  => $row[6],
                    'name_fr' => $row[6],
                    'level' => $row[7],
                    'cadre' => $row[8],
                    'degree' => $row[9],
                    'groupe' => $this->getGroupe($row[7]),
                    'rib' => $row[10],
                    'residence' => 'الرباط',
                    'active' => 1,
                ]);
            }
            
        }
    }
}