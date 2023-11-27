<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

       <div>
        <img src="{{asset('assets/img/te-sea1.png')}}" height="50"/>
      </div>
      <div class="d-none d-md-flex col-lg-12 col-sm-12 col-xd-12 col-md-8 input-group w-auto my-auto">
        <!-- <h4>PUBLICATION DES TRAVAUX ETUDIANTS</h4> -->
        <h4 style="font-weight:800;" class="text-white" >{{ __("Publication Des Travaux De Recherche Scientifique Et Professionnels") }}</h4>
      </div><!-- End Logo -->

     


    {{-- <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar --> --}}

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            {{-- <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon--> --}}




            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    {{-- <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle"> --}}
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->email }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('Admin.user.index') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                   
{{--
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li> --}}
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}"
                            >
                            @csrf
                            <span> <button type="submit" class="dropdown-item d-flex align-items-center"><i class="bi bi-box-arrow-right"></i>log
                                    Out</button> </span>
                            {{-- <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    <i class="bi bi-box-arrow-right"></i><span>log Out</span>
                                </x-responsive-nav-link> --}}
                        </form>

                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
