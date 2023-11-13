<?php

namespace App\Imports;

use App\Models\Etudiant\Etudiant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class EtudiantsImport implements ToArray, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    protected int $filiere_id;
    protected int $niveau_id;
    protected int $i=0;
    function __construct($niveau_id, $filiere_id){
        $this->niveau_id=$niveau_id;
        $this->filiere_id=$filiere_id;
    }
    use Importable;

    public function array(array $data)
    {
        dd($data);
        foreach($data as $etudiant){
            // dd(strlen($etudiant['matricule']));
            $numero=intval(str_replace('+', '', str_replace('237', '', str_replace(' ', '', $etudiant['telephone']))));
            if($etudiant['matricule'] !=null){
                if(Etudiant::where('matricule', $etudiant['matricule'])->get()->count()==0){
                    if(strlen($etudiant['matricule']) == 7){
                        if(strlen($numero)==9){
                            if($etudiant['prenom'] !=null){
                                Etudiant::create([
                                    'matricule'=>$etudiant['matricule'],
                                    'noms'=>$etudiant['nom'].' '.$etudiant['prenom'],
                                    'filiere_id'=>$this->filiere_id,
                                    'telephone'=>$numero,
                                    'niveau_id'=>$this->niveau_id,
                                    'email'=>$etudiant['email'],
                                    'password' => Hash::make('default')
                                ]);
                            }else{
                                Etudiant::create([
                                    'matricule'=>$etudiant['matricule'],
                                    'noms'=>$etudiant['nom'],
                                    'filiere_id'=>$this->filiere_id,
                                    'telephone'=>$numero,
                                    'niveau_id'=>$this->niveau_id,
                                    'email'=>$etudiant['email'],
                                    'password' => Hash::make('default')
                                   ]);
                            }
                        }else{
                            if($etudiant['prenom'] !=null){
                                Etudiant::create([
                                    'matricule'=>$etudiant['matricule'],
                                    'noms'=>$etudiant['nom'].' '.$etudiant['prenom'],
                                    'filiere_id'=>$this->filiere_id,
                                    'niveau_id'=>$this->niveau_id,
                                    'email'=>$etudiant['email'],
                                    'password' => Hash::make('default')
                                   ]);
                            }else{
                                Etudiant::create([
                                    'matricule'=>$etudiant['matricule'],
                                    'noms'=>$etudiant['nom'],
                                    'filiere_id'=>$this->filiere_id,
                                    'niveau_id'=>$this->niveau_id,
                                    'email'=>$etudiant['email'],
                                    'password' => Hash::make('default')
                                   ]);
                            }

                        }

                    }else{
                        if(strlen($numero)==9){
                            if($etudiant['prenom'] !=null){
                                Etudiant::create([
                                    'noms'=>$etudiant['nom'].' '.$etudiant['prenom'],
                                    'filiere_id'=>$this->filiere_id,
                                    'telephone'=>$numero,
                                    'niveau_id'=>$this->niveau_id,
                                    'email'=>$etudiant['email'],
                                    'password' => Hash::make('default')
                                ]);
                            }else{
                                Etudiant::create([
                                    'noms'=>$etudiant['nom'],
                                    'filiere_id'=>$this->filiere_id,
                                    'telephone'=>$numero,
                                    'niveau_id'=>$this->niveau_id,
                                    'email'=>$etudiant['email'],
                                    'password' => Hash::make('default')
                                   ]);
                            }
                      }
                    }

                }
            }
        }

    }
    public function batchSize():int
    {
        return 1000;
    }
    public function chunkSize():int
    {
        return 10000;
    }
}
/* if(strlen(intval(str_replace('+', '', str_replace('237', '', str_replace(' ', '', $etudiant['telephone'])))))==9){
    if($etudiant['prenom'] !=null){
        Etudiant::create([
            'matricule'=>$etudiant['matricule'],
            'noms'=>$etudiant['nom'].' '.$etudiant['prenom'],
            'filiere_id'=>$this->filiere_id,
            'telephone'=>intval(str_replace('+', '', str_replace('237', '', str_replace(' ', '', $etudiant['telephone'])))),
            'niveau_id'=>$this->niveau_id,
            'email'=>$etudiant['email'],
            'password' => Hash::make('default')
           ]);
    }else{
        Etudiant::create([
            'matricule'=>$etudiant['matricule'],
            'noms'=>$etudiant['nom'],
            'filiere_id'=>$this->filiere_id,
            'telephone'=>intval(str_replace('+', '', str_replace('237', '', str_replace(' ', '', $etudiant['telephone'])))),
            'niveau_id'=>$this->niveau_id,
            'email'=>$etudiant['email'],
            'password' => Hash::make('default')
           ]);
    }
}else{
    if($etudiant['prenom'] !=null){
        return Etudiant::create([
            'matricule'=>$etudiant['matricule'],
            'noms'=>$etudiant['nom'].' '.$etudiant['prenom'],
            'filiere_id'=>$this->filiere_id,
            'niveau_id'=>$this->niveau_id,
            'email'=>$etudiant['email'],
            'password' => Hash::make('default')
           ]);

    }else{
        return Etudiant::create([
            'matricule'=>$etudiant['matricule'],
            'noms'=>$etudiant['nom'],
            'filiere_id'=>$this->filiere_id,
            'niveau_id'=>$this->niveau_id,
            'email'=>$etudiant['email'],
            'password' => Hash::make('default')
           ]);
    }

}
else{
                if($etudiant['nom'] !=null){
                            if(strlen($numero)==9){
                                if(Etudiant::where('telephone', $numero)->get()->count()==0){
                                    return Etudiant::create([
                                        'noms'=>$etudiant['nom'].' '.$etudiant['prenom'],
                                        'filiere_id'=>$this->filiere_id,
                                        'niveau_id'=>$this->niveau_id,
                                        'telephone'=>intval(str_replace('+', '', str_replace('237', '', str_replace(' ', '', $etudiant['telephone'])))),
                                        'email'=>$etudiant['email'],
                                        'password' => Hash::make('default')
                                    ]);

                                }
                            }
                }
            }
 */
