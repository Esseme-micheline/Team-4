<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        h1,
        h3,
        p {
            text-transform: uppercase;
        }
        .card-title{
            text-align: center;
        }
        h3{
            text-align: center;
        }
        .grade{
            text-align: center;
            /* margin-top: 10px; */
        }
        .table-hover{
            border-collapse: collapse;
            min-width: 400px;
            width: auto;
            box-shadow: 0px 5px 50px rgba(0, 0, 0, 0.15);
            margin: 100px auto;
            /* border: 2px solid  #000; */
            border:  1px solid #ddd;
        }
        thead tr{
            text-align: left;
        }
        th, td{
            padding: 15px 20px;
        }
        tbody tr, td, th{
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <section class="section">

        <div class="card">
            <div class="card-body">
                <h1 class="card-title" style="font-size: 30px">Listes des Etudiants</h1>
                @if (isset($filiere))
                    <h3> FILIERE : {{ $filiere->code }}-{{ $filiere->intitule }}</h3>
                @endif

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>
                <br>
                <p class="grade">
                    @if (isset($niveau))
                        GRADE: {{ $niveau }}&ensp; &ensp;
                    @endif
                    ANNEE ACADEMIQUE: {{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}
                </p>
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Nom & Prenom</th>
                            <th scope="col">Matricule</th>
                            <th scope="col">Oservation</th>
                        </tr>
                    </thead>
                    <tbody id="tbodys">
                        @foreach ($etudiants as $etudiant)
                            <tr id="sid{{ $etudiant->id }}">
                                <th scope="row">{{ $n }}</th>
                                <td>{{ $etudiant->noms }}</td>
                                <td>{{ $etudiant->matricule }}</td>
                                <td></td>

                            </tr>
                            <div style="display:none;">{{ $n += 1 }}</div>
                        @endforeach
                    </tbody>
                </table>


            </div>


        </div>
    </section>

    </main>

</body>

</html>
