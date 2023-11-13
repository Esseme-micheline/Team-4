@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarFaculte')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Form Presence Sceance TD</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Faculte</li>
                    <li class="breadcrumb-item"><a href="{{ route('Admin.ue.index') }}">UE</a></li>
                    <li class="breadcrumb-item">TD</li>
                    <li class="breadcrumb-item">Groupe TD</li>
                    <li class="breadcrumb-item">Sceance Groupe TD</li>
                    <li class="breadcrumb-item active">Presence Sceance Groupe TD</li>
                </ol>
            </nav>

        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-capitalize" style="font-size:30px">Enregistrement d'un Nouvelle
                    Liste de Presence Sceance Groupe
                    de TD
                </h1>

            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <br>
                @if ($etudiants_groupes_tds_count > 0)
                    <!-- Multi Columns Form -->
                    <form class="row g-3" method="POST" action="{{ route('Admin.Presencesceance.store') }}">
                        @csrf
                        <input type="hidden" name="sceance_td_id" value="{{ $id }}">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">matricule</th>
                                    <th scope="col">Noms</th>
                                    <th scope="col"><input type="checkbox" name="check_all" id="check_all"
                                            class=""><label for=""
                                            class="form-check-label">&ensp;Status</label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($etudiants_groupes_tds as $etudiants_groupes_td)
                                    <tr>
                                        <th scope="row">{{ $n }}</th>
                                        <td>{{ $etudiants_groupes_td['matricule'] }}</td>
                                        <td>{{ $etudiants_groupes_td['noms'] }}</td>
                                        <td><input type="checkbox" name="status[]" class="checked"
                                                value="{{ $etudiants_groupes_td['id'] }}"
                                                id="status{{ $etudiants_groupes_td['id'] }}">
                                        </td>
                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Enregistre</button>
                            <button type="reset" class="btn btn-secondary">Effacer</button>
                        </div>
                    </form>
                @else
                    <div>R.A.S</div>
                @endif

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
