<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 align="center"><u>Review Form</u></h1>
    <div class="form-container">
        <div class="projectDetails-container">
            <h3>Details</h3>
            <p>Theme : <b>{{$data['theme']}}</b> </p>
            <p>Authors : <b>{{$data['authors']}}</b> </p>
        </div>

        <div>
            <h3>Evaluation</h3>
        <table>
            <tr>
                <th></th>
                <th>Exeptionelle</th>
                <th>Excellente</th>
                <th>Tres Bien</th>
                <th>Bien</th>
                <th>Passable</th>
                <th>Mediocre</th>
            </tr>
            <tr>
                <td>Presentation</td>
                <td>
                    @if($data['presentation'] == 'Exceptionnelle')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['presentation'] == 'Excellente')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['presentation'] == 'Tres bien')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['presentation'] == 'Bien')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['presentation'] == 'Passable')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['presentation'] == 'Mediocre')
                    <div class="dotDiv"></div>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Originalite</td>
                <td>
                    @if($data['originalite'] == 'Exceptionnelle')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['originalite'] == 'Excellente')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['originalite'] == 'Tres bien')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['originalite'] == 'Bien')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['originalite'] == 'Passable')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['originalite'] == 'Mediocre')
                    <div class="dotDiv"></div>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Applicabilite</td>
                <td>
                    @if($data['applicabilite'] == 'Exceptionnelle')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['applicabilite'] == 'Excellente')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['applicabilite'] == 'Tres bien')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['applicabilite'] == 'Bien')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['applicabilite'] == 'Passable')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['applicabilite'] == 'Mediocre')
                    <div class="dotDiv"></div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="comments-container">
    <h3>Comments</h3>
        @if($data['comments'])

        {{$data['comments']}}

        @endif
    </div>

    <div class="recommendation-container">
        <h3>Recommendations</h3>
        <table>
            <tr>
                <th></th>
                <th>Fortement accepte</th>
                <th>Accepte</th>
                <th>Marginalement accepte</th>
                <th>Accepte avec modifications</th>
                <th>Resoumettre</th>
                <th>Rejete</th>
            </tr>
            <tr>
                <td>Recommendation</td>
                <td>
                    @if($data['rec'] == 'Fortement accepte')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['rec'] == 'Accepte')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['rec'] == 'Marginalement accepte')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['rec'] == 'Accepte avec modifications')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['rec'] == 'Resoumettre')
                    <div class="dotDiv"></div>
                    @endif
                </td>
                <td>
                    @if($data['rec'] == 'Rejete')
                    <div class="dotDiv"></div>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>


<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,600;1,300;1,400&display=swap');

    *{
        font-family: 'Poppins', sans-serif;
        margin: 0px;
        padding: 1px;
    }
    .dotDiv{
        width: 5px;
        height: 5px;
        background-color: black;
        border-radius: 50%;
        margin: auto;
        padding: 2px;
    }
    tr,td,th,table{
        font-size: 13px;
        padding: 10px;
        border: 1px solid black;
        border-collapse: collapse;
    }
    ul{
        list-style-type: disc;
    }
    th{
        max-width: 100px;
    }
    th,td{
        font-weight: 600;
    }
    div.form-container{
        border: 1px solid black;
        width: fit-content;
        margin: auto;
        padding: 10px;
    }
    div.comments-container ul{
        padding: 0px 30px;
    }
</style>
