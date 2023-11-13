@extends('layouts.admin.body')
@section('content')
    @include('layouts.admin.sidebarAdminIndex')
    <main class="main" id="main">
        <div class="pagetitle">
            <h1>Profil</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item active">Profil</li>
                </ol>
            </nav>

        </div>
        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Aperçu</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edition du
                                Profile</button>
                        </li>

                        {{-- <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-settings">Settings</button>
                        </li> --}}

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer
                                le mot de passe</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            {{-- <h5 class="card-title">About</h5>
                            <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque
                                temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae
                                quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> --}}

                            <h5 class="card-title">Detail du profil</h5>
                            @if (isset($success))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ $success }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                {{-- <div></div> --}}
                            @endif
                            @if (isset($value))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $value }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                {{-- <div></div> --}}
                            @endif

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Nom</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->name }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Poste</div>
                                @if (Auth::user()->profil_id == 0)
                                    <div class="col-lg-9 col-md-8">Super Admin</div>
                                @elseif (Auth::user()->profil_id == 1)
                                    <div class="col-lg-9 col-md-8">Doyen Ecole Doctorat</div>
                                @elseif (Auth::user()->profil_id == 2)
                                    <div class="col-lg-9 col-md-8">Chef du departement</div>
                                @elseif (Auth::user()->profil_id == 3)
                                    <div class="col-lg-9 col-md-8">Enseignant</div>
                                @elseif (Auth::user()->profil_id == 4)
                                    <div class="col-lg-9 col-md-8">Secretaire</div>
                                @elseif (Auth::user()->profil_id==5)
                                    <div class="col-lg-9 col-md-8">Charge de Td</div>
                                @else
                                <div class="col-lg-9 col-md-8">Aucun profil</div>
                                @endif
                            </div>
                            {{-- <div class="row">
                                <div class="col-lg-3 col-md-4 label">Country</div>
                                <div class="col-lg-9 col-md-8">USA</div>
                            </div> --}}
                            @if (Auth::user()->profil_id < 5)
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Bureau</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->enseignant['bureau'] }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Telephone</div>
                                    <div class="col-lg-9 col-md-8">(237) {{ Auth::user()->enseignant['telephone'] }} </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                </div>
                            @else
                                @if (Auth::user()->profil_id == 5)
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Telephone</div>
                                        <div class="col-lg-9 col-md-8">(237) {{ Auth::user()->charge_td['telephone'] }}
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form action="{{ route('Admin.user.store') }}" method="POST">
                                @csrf

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" id="fullName"
                                            value="{{ Auth::user()->name }}" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                @if (Auth::user()->profil_id < 5)
                                    <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Bureau</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="bureau" type="text"
                                                class="form-control @error('bureau') is-invalid @enderror" id="bureau"
                                                value="{{ Auth::user()->enseignant['bureau'] }}">
                                        </div>
                                        @error('telephone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Telephone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="telephone" type="number"
                                                class="form-control @error('telephone') is-invalid @enderror" id="Phone"
                                                value="{{ Auth::user()->enseignant['telephone'] }}">
                                        </div>
                                        @error('telephone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @else
                                    @if (Auth::user()->profil_id == 5)
                                        <div class="row mb-3">
                                            <label for=""
                                                class="col-md-4 col-lg-3 col-form-label">Telephone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="telephone" type="number"
                                                    class="form-control @error('telephone') is-invalid @enderror"
                                                    id="Phone" value="{{ Auth::user()->charge_td['telephone'] }}">
                                            </div>
                                            @error('telephone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    @endif
                                @endif
                                {{--  --}}

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" required
                                            class="form-control @error('email') is-invalid @enderror" id="Email"
                                            value="{{ Auth::user()->email }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Enregistrer les changement</button>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane fade pt-3" id="profile-change-password">

                            <!-- Change Password Form -->
                            <form action="{{ route('Admin.user.storePassword') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Mot de passe
                                        Actuel</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input required autofocus name="cpassword" type="password"
                                            class="form-control @error('cpassword') is-invalid @enderror"
                                            id="currentPassword">
                                    </div>
                                    @error('cpassword')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau Mot de
                                        passe</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input required name="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-entrez le
                                        nouveau Mot de passe</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input required name="password_confirmation" type="password" class="form-control"
                                            id="renewPassword">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Changer le Mot de passe</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </main>
@endsection
