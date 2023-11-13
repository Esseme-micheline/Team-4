@extends('layouts.admin.body')
@section('content')
@include('layouts.admin.sidebarEcoleDoctorat')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Messages</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('Admin.index') }}">Admin</a></li>
                    <li class="breadcrumb-item">Ecole Doctorat</li>
                    <li class="breadcrumb-item active">Messages</li>
                </ol>
            </nav>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-center text-capitalize" style="font-size: 40px">Messages Envoyée</h1>

                    <!-- Horizontal Form -->
                    <!-- End Horizontal Form -->

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    @if ($messages->count() > 0)
                        <br>




                        <br>

                        <!-- Dark Table -->
                        <table class="table table-hover text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Date d'envoie</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbodys">
                                @foreach ($messages as $message)
                                    <tr id="sid{{ $message->id }}">
                                        <th scope="row">{{ $n }}</th>
                                        <td class=" text-break" style="width:25rem">{{ $message->titre }}</td>
                                        <td>{{ $message->created_at }}</td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="voirMessage({{ $message->id }})" class="btn btn-success"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Voir plus</a>&ensp;
                                            <a href="javascript:void(0)" onclick="editMessage({{ $message->id }})"
                                                class="btn btn-danger"><i class="fa fa-edit" aria-hidden="true"></i> Update</a>&ensp;
                                            <a onclick="return confirm('Voulez vous supprimer se message et avec tout sont contenu?')"
                                                href="{{ route('Ecole_Doctorat.message.delete', $message->id) }}"
                                                class="btn btn-secondary"><i class="fa fa-trash"
                                                    aria-hidden="true"></i></i>Delete</a>
                                        </td>

                                    </tr>
                                    <div style="display:none;">{{ $n += 1 }}</div>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">
                            {{ $messages->links() }}
                        </div>
                        <!-- End Dark Table -->
                    @else
                        <div>Vous n'avez pas encore ajouter de Message</div>
                    @endif
                </div>
            </div>
        </section>

    </main>
@endsection
@section('modals')
@include('ecoleDoctorat.message.voir')
@include('layouts.modals.dossiermessageupdate')
@endsection
@section('scripts')
    <script src="{{ asset('js/ecoleDoctorat/message.js') }}">
    </script>
@endsection
