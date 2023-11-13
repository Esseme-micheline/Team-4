<?php

namespace App\Exports;

use App\Models\Etudiant\Etudiant;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class EtudiantsExport implements FromCollection, WithHeadings
{
    protected int $filiere_id;
    protected int $niveau_id;
    function __construct($niveau_id, $filiere_id){
        $this->niveau_id=$niveau_id;
        $this->filiere_id=$filiere_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if($this->niveau_id==0 && $this->filiere_id==0){
            return Etudiant::select('noms', 'matricule' )->OrderBy('noms')->get();
        }elseif($this->niveau_id!=0 && $this->filiere_id==0){
            return Etudiant::select('noms', 'matricule')->where('niveau_id', $this->niveau_id)->OrderBy('noms')->get();
        }elseif($this->niveau_id==0 && $this->filiere_id!=0){
            return Etudiant::select('noms', 'matricule')->where('filiere_id', $this->filiere_id)->OrderBy('noms')->get();
        }else{
            return Etudiant::select('noms', 'matricule')->where('niveau_id', $this->niveau_id)->where('filiere_id', $this->filiere_id)->OrderBy('noms')->get();
        }

    }
    public function headings():array{
        return [
            'Nom',
            'Matricule',
        ];
    }
}
