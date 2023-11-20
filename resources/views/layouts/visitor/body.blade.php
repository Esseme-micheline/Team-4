<!DOCTYPE html>
<html lang="fr">
@include('layouts.visitor.header')
<?php
    $domaines = config('global.constants.domaines');
?>
<!-- TTtetnetetdfdf -->
<!--Main Navigation-->
<header>

  <!-- Sidebar -->

  <nav id="sidebarMenu" class="d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
        <p>{{ __("Memoires") }}</p>
      <div class="list-group list-group-flush mx-3 mt-4">
        <a href="{{route('visiteur.all')}}" class="list-group-item list-group-item-action py-2 ripple active">
          <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>{{ __("Memoires Recent") }}</span>
        </a>
        <a href="{{route('visiteur.creer')}}" class="list-group-item list-group-item-action py-2 ripple ">
          <i class="fas fa-chart-area fa-fw me-3"></i><span>{{ __("Soummision") }}</span>
        </a>
        <a href="{{route('visiteur.creerFinale')}}" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-lock fa-fw me-3"></i><span>{{ __("Code Soumission") }}</span></a>
        <a href="{{route('visiteur.search')}}" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-search fa-fw me-3"></i><span>{{ __("Rechercher") }}</span></a>

        <br>
        <p>Different Categories :</p>
        @foreach($domaines as $dom)
        <a href="{{route('visiteur.all.category',$dom)}}" class="list-group-item list-group-item-action py-2 ripple">
            <i class="bi bi-archive-fill me-3"></i>
            <!-- <i class="fas fa-search fa-fw me-3"></i> -->
            <span>{{$dom}}</span></a>
        @endforeach
      </div>
    </div>
  </nav>
  <!-- Sidebar -->
<!-- Font Awesome -->

<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css"
  rel="stylesheet"
/>
<script type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"
></script>
<style>
  .list-group {
  --mdb-list-group-active-color:#ff8400;
  }
  .nav-tabs .nav-link {
  --mdb-nav-tabs-link-active-color:#222222;
  --mdb-nav-tabs-link-active-border-color:#ff8400;
  }
  .btn-primary {
    --bs-btn-hover-bg: #008374;
    --bs-btn-hover-border-color: #008374;
    --bs-btn-active-bg: #008374;
    --bs-btn-active-border-color: #008374;
    --mdb-btn-bg: #008374;
    --mdb-btn-box-shadow: 0 4px 9px -4px #008374;
   
  }
  .btn-success {
    --mdb-btn-bg: #008374;
    --mdb-btn-color: #fff;
    --mdb-btn-box-shadow: 0 4px 9px -4px #008374;
    --mdb-btn-hover-bg: #008374;
    --mdb-btn-hover-color: #fff;
    --mdb-btn-focus-bg: #008374;
    --mdb-btn-focus-color: #fff;
    --mdb-btn-active-bg: ##008374;
    --mdb-btn-active-color: #fff;
    --mdb-btn-box-shadow-state: 0 8px 9px -4px rgba(20,164,77,0.3),0 4px 18px 0 rgba(20,164,77,0.2);
}
.btn-danger {
    --mdb-btn-bg: #ff8400;
    --mdb-btn-color: #fff;
    --mdb-btn-box-shadow: 0 4px 9px -4px #ff8400;
    --mdb-btn-hover-bg: #ff8400;
    --mdb-btn-hover-color: #fff;
    --mdb-btn-focus-bg: #ff8400;
    --mdb-btn-focus-color: #fff;
    --mdb-btn-active-bg: #ff8400;
    --mdb-btn-active-color: #fff;
    --mdb-btn-box-shadow-state: 0 8px 9px -4px rgba(220,76,100,0.3),0 4px 18px 0 rgba(220,76,100,0.2);
}
  :root{
    --mdb-primary: #ff8400;
    --mdb-primary-rgb: 0,131,116;
  }
  .back-to-top{
    background:#008374;
  }
  </style>
  <!-- Navbar -->
  <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light fixed-top"
    style="background-color: #232323;box-shadow: 0 5px 10px -5px;height:80px;"
  >
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button class="navbar-toggler"
              data-mdb-toggle="collapse"
              data-mdb-target="#sidebarMenu"
              aria-controls="sidebarMenu"
              aria-expanded="false"
              aria-label="Toggle navigation">
        <i class="fas fa-bars" id="barsIcon" style="color: azure"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand" href="#">
        <img src="https://mdbootstrap.com/img/logo/COF-transaprent-noshadows.png" height="25" alt="" loading="lazy" />
      </a>
      <!-- Search form -->
      <div>
        <img src="{{asset('assets/img/te-sea1.png')}}" height="50"/>
      </div>
      <div class="d-none d-md-flex col-lg-12 col-sm-12 col-xd-12 col-md-8 input-group w-auto my-auto">
        <!-- <h4>PUBLICATION DES TRAVAUX ETUDIANTS</h4> -->
        <h4 style="font-weight:800;" class="text-white" >{{ __("Publication Des Travaux De Recherche Scientifique Et Professionnels") }}</h4>
      </div>
      
      
      
      <li style="padding-top:0px; padding-left: 270px;list-style-type: none;">
        <div class="dropdown" style="margin-top:0px; margin-left: 300px" id="localization-switcher" class="locale-switcher  align-items-center action-btns btn text-end d-sm-none d-xs-none d-lg-block bg-light">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #009688; color:white;">
            {{ __("TRADUIRE") }}
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="locale/fr">Français</a></li>
            <li><a class="dropdown-item" href="locale/en">English</a></li>
          </ul>
        </div>
      </li>


      <ul class="navbar-nav ms-auto d-flex flex-row">
      </ul>
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
  <style></style>
</header>

<body>
<!--Main Navigation-->

<!--Main layout-->
<main style="margin-top: 110px" id="main">
  <div class="container pt-4">
  @yield('content')
  </div>
</main>
<!--Main layout-->
<!-- ererererer -->

    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>GestionEtudiant</span></strong>. All Rights Reserved
        </div>
    </footer>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    @yield('modals')

    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>

    <script>

$(document).ready(function(e){
    var path = window.location.href;
                $("a.list-group-item").each(function(item){


                        var path = window.location.href;
                        var urlSegment = $(this).attr('href').lastIndexOf('/')+1;

                        var urlPath = $(this).attr('href').substring(urlSegment)

                        var current = path.substring(path.lastIndexOf('/')+1);

                        if(current == urlPath){
                            console.log('yeahhh')
                            $("a.list-group-item.active").removeClass('active')
                            $(this).addClass('active')
                        }

                })

});


/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("sidebarMenu").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}


                // $("a.list-group-item").on('click', function(e){
                //     console.log(this)
                //     e.stopImmediatePropagation();
                // $("a.list-group-item.active").removeClass('active');
                //  return $(this).addClass('active')})
    </script>
<style>
        h4{
            font-variant: small-caps;
        }
        .social-linkss a{
            padding-right: 10px;
        }
</style>
    @yield('scripts')


    <!-- <script>
    var i = 0;
    var j = 0;
    $('#addFile').click(function(){
      ++i;
      $('#table').append(
        `<tr>
            <td>
              <input type="file" name="inputs[`+i+`][memoire]" placeholder="Choissir un fichier" class="form-control"/>
            </td>
            <td>
             <button type="button" class="btn btn-danger remove-table-row">-</button>
            </td>
        </tr>`);
    });

    $('#addLien').click(function(){
      ++j;
      $('#tables').append(
        `<tr>
            <td>
              <input type="text" name="inputsl[`+j+`][lien]" placeholder="Entrer votre lien" class="form-control"/>
            </td>
            <td>
             <button type="button" class="btn btn-danger remove-table-row">-</button>
            </td>
        </tr>`);
    });

    $(document).on('click','.remove-table-row', function(){
      $(this).parents('tr').remove();
    })

  </script>  -->

</body>

</html>
