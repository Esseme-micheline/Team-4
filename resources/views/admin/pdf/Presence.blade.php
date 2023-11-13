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

        .tete {
            text-align: center;

        }

        .entete-fil {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        h3 {
            text-align: center;
        }

        .fil {
            text-align: center;
        }

        .grade {
            /* width: 100%; */
            text-align: center;
        }

        .table-hover {
            border-collapse: collapse;
            min-width: 400px;
            width: auto;
            box-shadow: 0px 5px 50px rgba(0, 0, 0, 0.15);
            margin: 100px auto;
            /* border: 2px solid  #000; */
            border: 1px solid #ddd;
        }

        thead tr {
            text-align: left;
        }

        th,
        td {
            padding: 15px 20px;
        }

        tbody tr,
        td,
        th {
            border: 1px solid #000;
        }
        body{
            display: flex;
            flex-direction: column;
        }
        main{
            flex: 1 0 auto;
        }
        footer{
            flex-shrink: 0;
            border-top: 1px solid #000;
            width: 100%;
        }
        .contenu-footer{
            width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            font-size: 15px;
            padding: 50px 0 20px;
        }
        .bloc{
            width: 25px;
            margin: 0 30px;
        }
        /* tbody tr:nth-child(even){
            background-color: #f3f3f3;
        } */
    </style>
</head>

<body>
    <main>
        @if ($td_bool ==true)
            <header>

                <h1 class="tete">{{ $sceance->intitule }} : {{ $sceance->groupe_td->td->intitule }}</h1>
                <h3 class="ue">UE : {{ $sceance->groupe_td->td->ue->intitule }}
                </h3>
            </header>
            <div class="entete-fil">
                <div class="grade">
                    <p>Grade: {{ $sceance->groupe_td->td->ue->niveau->code }} &ensp;&ensp;ANNEE ACADEMIQUE:
                        {{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}</p>
                </div>

            </div>
        @else
            <header>
                <h1 class="tete">{{ $sceance->intitule }} : {{ $sceance->groupe_td->td_special->intitule }}</h1>
                <h3 class="ue">
                    UE : {{ $sceance->groupe_td->td_special->ue->intitule }}
                </h3>
            </header>
            <div class="entete-fil">
                <p class="grade">Grade {{ $sceance->groupe_td->td_special->ue->niveau->code }} &ensp;&ensp;ANNEE
                    ACADEMIQUE: {{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}</p>
            </div>
        @endif


        <section>
            @if ($presences_sceances->count() > 0)
                <h1 class="card-title text-center text-capitalize" style="font-size: 30px; text-align:center;">Liste
                    de présence
                </h1>
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Noms & Prenom</th>
                            <th scope="col">Matricule</th>
                        </tr>
                    </thead>
                    <tbody id="tbodys">

                        @foreach ($presences_sceances as $presences_sceance)
                            <tr id="sid{{ $presences_sceance->id }}">
                                <th scope="row">{{ $n }}</th>
                                <td>
                                    {{ $presences_sceance->etudiant['noms'] }}
                                </td>
                                <td>
                                    {{ $presences_sceance->etudiant['matricule'] }}
                                </td>
                            </tr>
                            <div style="display:none;">{{ $n += 1 }}</div>
                        @endforeach

                    </tbody>
                </table>
            @endif
            @if ($presences_sceances_Absent->count() > 0)
                <h1 class="card-title text-center text-capitalize" style="font-size: 30px; text-align:center;">liste
                    d'Absence
                </h1>
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th scope="col">N°</th>
                            <th scope="col">Noms & Prenoms</th>
                            <th scope="col">Matricule</th>
                        </tr>
                    </thead>
                    <tbody id="tbodys">

                        <div style="display:none;">{{ $n = 1 }}</div>
                        @foreach ($presences_sceances_Absent as $presences_sceance)
                            <tr id="sid{{ $presences_sceance->id }}">
                                <th scope="row">{{ $n }}</th>
                                <td>
                                    {{ $presences_sceance->etudiant['noms'] }}
                                </td>
                                <td class=" text-break" style="width:10rem">
                                    {{ $presences_sceance->etudiant['matricule'] }}
                                </td>
                            </tr>
                            <div style="display:none;">{{ $n += 1 }}</div>
                        @endforeach

                    </tbody>
                </table>

            @endif

        </section>

    </main>
    <footer>
        <div class="contenu-footer">
            <div class="bloc footer-services">

                Groupe : {{ $sceance->groupe_td->intitule }}

            </div>
            <div class="bloc footer-services">

                Date: {{ $sceance->date }}

            </div>
            <div class="bloc footer-services">

                Heure: {{ $sceance->heureDebut }}-
                {{ $sceance->heureFin }}

            </div>
            <div class="bloc footer-services">
                @if ($td_bool == true)
                    Grade: {{ $sceance->groupe_td->td->ue->niveau->code }} &ensp;&ensp;ANNEE ACADEMIQUE:
                    {{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}
                @else
                    Grade {{ $sceance->groupe_td->td_special->ue->niveau->code }} &ensp;&ensp;ANNEE
                    ACADEMIQUE: {{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}
                @endif

            </div>
            {{-- <p>Date: {{ $sceance->date }} &ensp; &ensp; &ensp; Heure: {{ $sceance->heureDebut }}-
                {{ $sceance->heureFin }}</p> --}}
        </div>
    </footer>
</body>

</html>
