<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (Auth::user()->profil_id != 1)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('Admin.index') }}">
                    <i class="fa-solid fa-chart-column"></i>
                    <span>Statisque</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->profil_id == 0 || Auth::user()->profil_id == 1)
            <li class="nav-item">
                <a class="nav-link" data-bs-target="#table-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-graduation-cap"></i><span>Ecole Doctorat</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="table-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('Ecole_Doctorat.reporting') }}"
                            @if (isset($reporting)) class="active" @endif>
                            <i class="bi bi-circle"></i><span>Reporting</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Ecole_Doctorat.dossier.index') }}"
                            @if (isset($projets_count) || isset($selectedProject)) class="active" @endif>
                            <i class="bi bi-circle"></i><span>Dossier @if (isset($dossier_nombre_1))
                                    @if ($dossier_nombre_1 != 0)
                                        <span class="text-success">{{ $dossier_nombre_1 }}</span>
                                    @endif

                                @endif
                            </span>
                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('Ecole_Doctorat.Inscription.index') }}"@if (isset($inscription_i)) class="active" @endif>
                            <i class="bi bi-circle"></i><span>Inscription @if (isset($dossier_nombre))
                                    @if ($dossier_nombre != 0)
                                        <span class="text-success">{{ $dossier_nombre }}</span>
                                    @endif
                                @endif </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Ecole_Doctorat.jury.index') }}"
                            @if (isset($jury_s)) class="active" @endif>
                            <i class="bi bi-circle"></i><span>Jury</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Ecole_Doctorat.message.index') }}"
                            @if (isset($message_i)) class="active" @endif>
                            <i class="bi bi-circle"></i><span>Message</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Ecole_Doctorat.archive.index') }}"
                            @if (isset($archive_i)) class="active" @endif>
                            <i class="bi bi-circle"></i><span>Archive</span>
                        </a>
                    </li>

                </ul>
            </li>
        @endif

        @if (Auth::user()->profil_id == 1)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-database"></i><span>Donnée de base</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('Admin.etudiant.create') }}">
                            <i class="bi bi-circle"></i><span> Ajouter un Etudiant</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Ecole_Doctorat.unite_recherche.create') }}">
                            <i class="bi bi-circle"></i><span> Ajouter une Unite de Recherche</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-table-list"></i><span> Faculte </span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('Ecole_Doctorat.unite_recherche.index') }}">
                            <i class="bi bi-circle"></i><span>Gestions des Unites de Recherches</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Ecole_Doctorat.unite_recherche.index') }}">
                            <i class="bi bi-circle"></i><span>Gestions des Unites de Recherches</span>
                        </a>
                    </li>

                </ul>
            </li>
        @endif

        @if (Auth::user()->profil_id == 0 || Auth::user()->profil_id == 2 || Auth::user()->profil_id == 4)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-database"></i><span>Donnée de base</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('Admin.etudiant.create') }}">
                            <i class="bi bi-circle"></i><span> Ajouter un Etudiant</span>
                        </a>
                    </li>
                    @if (Auth::user()->profil_id == 0)
                        <li>
                            <a href="{{ route('Admin.departement.create') }}">
                                <i class="bi bi-circle"></i><span> Ajouter un Departement</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Admin.niveau.create') }}">
                                <i class="bi bi-circle"></i><span> Ajouter un Niveau</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('Ecole_Doctorat.unite_recherche.create') }}">
                                <i class="bi bi-circle"></i><span> Ajouter une Unite de Recherche</span>
                            </a>
                        </li>
                    @endif

                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-table-list"></i><span>Faculte</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('Admin.departement.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Departements</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.filiere.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Filieres</span>
                        </a>
                    </li>
                    @if (Auth::user()->profil_id == 0)
                        <li>
                            <a href="{{ route('Admin.niveau.index') }}">
                                <i class="bi bi-circle"></i><span>Gestion des Niveaux</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('Admin.etudiant.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Etudiants</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.ue.index') }}">
                            <i class="bi bi-circle"></i><span>Gestions des UEs</span>
                        </a>
                    </li>
                    @if (Auth::user()->profil_id == 0)
                        <li>
                            <a href="{{ route('Ecole_Doctorat.unite_recherche.index') }}">
                                <i class="bi bi-circle"></i><span>Gestions des Unites de Recherches</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('Admin.attribution.index') }}">
                            <i class="bi bi-circle"></i><span>Gestions des Attributions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.groupeTD.index') }}">
                            <i class="bi bi-circle"></i><span>Gestions des Groupes de TD</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.enseignant.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Enseignants</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.ChargeTd.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Charge de TD</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.club.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Clubs</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.requete.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Requetes</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if (Auth::user()->profil_id == 3 || Auth::user()->profil_id == 5)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa-solid fa-table-list"></i><span> Faculte </span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('Admin.departement.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Departements</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.filiere.index') }}">
                            <i class="bi bi-circle"></i><span>Gestion des Filieres</span>
                        </a>
                    </li>
                    @if (Auth::user()->profil_id == 0)
                        <li>
                            <a href="{{ route('Admin.niveau.index') }}">
                                <i class="bi bi-circle"></i><span>Gestion des Niveaux</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route('Admin.ue.index') }}">
                            <i class="bi bi-circle"></i><span>Gestions des UEs</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.attribution.index') }}">
                            <i class="bi bi-circle"></i><span>Gestions des Attributions</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('Admin.groupeTD.index') }}">
                            <i class="bi bi-circle"></i><span>Gestions des Groupes de TD</span>
                        </a>
                    </li>
                    @if (Auth::user()->profil_id == 3)
                        <li>
                            <a href="{{ route('Admin.requete.index') }}">
                                <i class="bi bi-circle"></i><span>Gestion des Requetes</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('Admin.user.index') }}">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>
        </li>
        @if (Auth::user()->profil_id == 0 || Auth::user()->profil_id == 2 || Auth::user()->profil_id == 4)
            <li class="nav-item">
                <a class="nav-link @if (!isset($utilisateur_c)) collapsed @endif "
                    href="{{ route('Admin.Utilisateur.create') }}">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span>Ajout Utilisateur</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (!isset($utilisateur_c)) collapsed @endif "
                    href="{{ route('Admin.Utilisateur.index') }}">
                    <i class="fa-solid fa-users-between-lines"></i>
                    <span>Liste des Utilisateurs</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->profil_id == 6)
        <li class="nav-item">
                <a class="nav-link @if (!isset($utilisateur_c)) collapsed @endif "
                    href="{{ route('Admin.Utilisateur.create') }}">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    <span>Gerer mon Dossier</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link @if (!isset($utilisateur_c)) collapsed @endif "
                    href="{{ route('Admin.Utilisateur.index') }}">
                    <i class="fa-solid fa-users-between-lines"></i>
                    <span>Gerer mon Dossier</span>
                </a>
            </li> -->
        @endif


    </ul>

</aside>
