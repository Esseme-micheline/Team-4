
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Noter Etudiant</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <main id="main" class="main">


        <div class="card w-75">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Theme : {{ $theme }}</h1>

                <!-- Horizontal Form -->
                <!-- End Horizontal Form -->

            </div>
        </div>

        <div class="card w-75 ">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ Route('Ecole_Doctorat.email.note', $url) }}">
                    @csrf
                    <div class="col-12 text-capitalize">
                        <label for="inputName5" class="form-label">Entrer Note: </label>
                        <input type="number" class="form-control @error('note') is-invalid  @enderror"
                            value="{{ old('note') }}" id="inputName5" required name="note" autofocus
                            placeholder="../20">
                        @error('note')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistre</button>
                        <button type="reset" class="btn btn-secondary">Effacer</button>
                    </div>
                </form>

            </div>
    </main>

</body>

</html>
