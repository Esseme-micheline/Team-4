<?php

namespace App\Imports;

use App\Models\Admin\GroupeTd;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GroupeTDImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    protected int $td_id;

    function __construct($td_id){
        $this->td_id=$td_id;
    }
    use Importable;
    public function collection(Collection $collection)
    {   
        // dd($collection);
        foreach($collection as $groupeTD){
            // dd($groupeTD);
            GroupeTd::create([
                'td_id'=>$this->td_id,
                'intitule'=>$groupeTD['intitule'],
                'periode'=>$groupeTD['periode'],
                'capacite'=>intval($groupeTD['capacite']),
                'salle'=>$groupeTD['salle']
            ]);
        }
        // dd(intval($groupeTD['capacite']));
        // return GroupeTd::create([
        //     'td_id'=>$this->td_id,
        //     'intitule'=>$groupeTD['intitule'],
        //     'periode'=>$groupeTD['periode'],
        //     'capacite'=>intval($groupeTD['capacite']),
        //     'salle'=>$groupeTD['salle']
        // ]);
    }
    public function batchSize():int
    {
        return 100;
    }
    public function chunkSize():int
    {
        return 1000;
    }
}
