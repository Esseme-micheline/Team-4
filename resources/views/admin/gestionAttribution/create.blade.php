@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form Attributions</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item"><a href="{{ route('Admin.enseignant.index') }}">Enseignant</a></li>
                    <li class="breadcrumb-item active">Attributions</li>
                </ol>
            </nav>

        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size:30px">Enregistrement d'un Nouvelle
                    Attribution
                </h1>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>

                <!-- Multi Columns Form -->
                <form class="row g-3" method="POST" action="{{ route('Admin.attribution.store') }}">
                    @csrf
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Enseignant</th>
                                <th scope="col">UE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>
                                    <div class="">
                                        <label for="" class="form-label">Enseignant :</label>
                                        <select name="enseignant_id" id="" required
                                            class="form-select @error('enseignant_id') is-invalid  @enderror"
                                            @if (!isset($enseignant_id)) autofocus @endif>
                                            <option value="">Selectionner un champ</option>
                                            @if (isset($enseignant_id))
                                                @foreach ($enseignants as $enseignant)
                                                    @if ($enseignant->id == $enseignant_id)
                                                        <option value="{{ $enseignant->id }}" selected>
                                                            {{ $enseignant->noms }}</option>
                                                    @else
                                                        <option value="{{ $enseignant->id }}">{{ $enseignant->noms }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($enseignants as $enseignant)
                                                    @if (old('enseignant_id') == $enseignant->id)
                                                        <option value="{{ $enseignant->id }}" selected>
                                                            {{ $enseignant->noms }}</option>
                                                    @else
                                                        <option value="{{ $enseignant->id }}">{{ $enseignant->noms }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('enseignant_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </td>
                                <td>
                                    @if ($ues != null)
                                        <div class="col-12">
                                            <label for="" class="form-label">UE</label>
                                            <select multiple name="ue_id[]" id="" required
                                                class="form-select @error('ue_id') is-invalid  @enderror">
                                                <option value="">Selectionner un champ</option>
                                                @if (isset($ue_id))
                                                    @foreach ($ues as $ue)
                                                        @if ($ue->id == $ue_id)
                                                            <option value="{{ $ue->id }}" selected>
                                                                {{ $ue->code }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $ue->id }}">{{ $ue->code }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach ($ues as $ue)
                                                        @if (old('ue_id') == $ue->id)
                                                            <option value="{{ $ue->id }}" selected>
                                                                {{ $ue->code }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $ue->id }}">{{ $ue->code }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('ue_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @else
                                        <div>R.A.S</div>
                                    @endif
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enregistre</button>
                        <button type="reset" class="btn btn-secondary">Effacer</button>
                    </div>
                </form>

            </div>
    </main>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('input[type=checkbox][name=check_all]').change(function() {
                let cmpt = document.getElementsByClassName('checked').length
                if ($(this).is(':checked')) {

                    for (let i = 0; i < cmpt; i++) {
                        document.getElementsByClassName('checked')[i].checked = true
                    }
                    $('input[type=checkbox][name=status]').checked = true
                    // console.log(`${this.value} is checked`);
                } else {
                    for (let i = 0; i < cmpt; i++) {
                        document.getElementsByClassName('checked')[i].checked = false
                    }
                    // console.log(`${this.value} is unchecked`);
                }
            });
            $('input[type=checkbox][class=checked]').change(function() {
                let cmpt = document.getElementsByClassName('checked').length
                let val = true;
                for (let i = 0; i < cmpt; i++) {

                    if (document.getElementsByClassName('checked')[i].checked == false) {
                        val = false
                    }
                }
                if (val == false) {
                    document.getElementById('check_all').checked = false
                } else {
                    document.getElementById('check_all').checked = true
                }

            });
        });
    </script>
@endsection
