@extends('welcome')
@section('title', 'Résidences')
@section('styles')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="mt-3">
                <div class="d-flex justify-content-evenly flex-wrap ">
                    <h5 class="card-title">Residence: {{ $residence->name }}</h5>
                    <h5 class="card-title">Adresse: {{ $residence->address }}</h5>
                    <h5 class="card-title">N° du titre Foncier: {{ $residence->nfoncier }}</h5>
                    <h5 class="card-title">Emplacement: {{ $residence->emplacemnt }}</h5>
                    <h5 class="card-title">N° du permis de bâtir: {{ $residence->npermis }}</h5>
                    <h5 class="card-title">Détail Municipalité: {{ $residence->detailMunicipal }}</h5>
                </div>
                @if ($residence->file && count($residence->file) > 0)
                    <h5 class="card-title">Détails Résidence: </h5> <br>
                    <div class="d-flex flex-wrap">
                        @foreach ($residence->file as $file)
                            <a href="{{ asset($file->path) }}" target="_blank" download class="btn btn-primary m-1 "><i
                                    data-feather="download"></i> {{ $file->name }}</a>
                            <br>
                        @endforeach
                    </div>
                @endif
                <h5 class="card-title">Gallery:</h5>
                @if ($residence->image && count($residence->image) > 0)

                    <div id="carouselExample" class="carousel slide m-3">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset($residence->image[0]->path) }}" class="d-block w-100"
                                    style="height: 500px; object-fit: contain;">
                            </div>
                            @foreach ($residence->image as $key => $image)
                                @if ($key > 0)
                                    <div class="carousel-item">
                                        <img src="{{ asset($image->path) }}" class="d-block w-100"
                                            style="height: 500px; object-fit: contain;">
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @else
                    <h6 class="card-title ml-5">Pas de photos</h6>
                @endif
                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineResEdit" id="resEd"
                    class=" btn btn-warning mb-1 mt-1">Modifier</button>
                <h5 class="card-title">Étages:</h5>
                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineEtage" id="resEd"
                    class="btn btn-primary mb-1 mt-1">Ajouter</button>
                <div class="row d-flex flex-wrap">
                    @foreach ($residence->etage as $etage)
                        <div class="container w-50">
                            <div class="card m-3">
                                <div class="card-header">

                                    <div>
                                        <div>
                                            <h5 class="card-title">{{ $etage->name }}</h5>
                                        </div>
                                        <br>
                                        <div class="d-none d-md-inline-block"><a
                                                href="{{ route('etages.show', $etage->id) }}"
                                                class="btn btn-primary ml-auto">Details</a>
                                        </div>

                                        <div class="d-inline-block d-md-none"><a
                                                href="{{ route('etages.show', $etage->id) }}"
                                                class="btn btn-primary ml-auto">+</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <img src="{{ asset($etage->plan) }}" height="300px" style="object-fit: contain"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-3">
                            <h5 class="card-title">Parkings</h5>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                class="btn btn-primary">Ajouter</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>

                                        <th scope="col">Place Parking</th>
                                        <th scope="col">Numéro</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residence->parking as $parking)
                                        <tr>

                                            <td>{{ $parking->name }}</td>
                                            <td>{{ $parking->number }}</td>
                                            <td>
                                                @if ($parking->client)
                                                    {{ $parking->client->name }} {{ $parking->client->lastName }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>

                                                <div class="d-flex">
                                                    <button id="{{ $parking->id }}" class="btn btn-warning edit m-1"
                                                        data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                            data-feather="editCellier"></i>Modifier</button>
                                                    <form method="GET"
                                                        action="{{ route('parkings.destroy', $parking->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger m-1"><i
                                                                data-feather="trash"></i>Supprimer</button>
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade text-left " id="inlineEtage" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path
                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                    </svg>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('etages.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="residence_id" value={{ $residence->id }}>
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
                                    </div>
                                    <label>Plan: </label>
                                    <input type="file" name="plan" class="image-preview-filepondEtage" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block text-white">Ajouter</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade text-left " id="cellier" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path
                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                    </svg>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('celliers.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
                                    </div>
                                    <label>Client: </label>
                                    <div class="form-group">
                                        <select name="client_id" class="form-control">
                                            <option value="">--</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">
                                                    {{ $client->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block text-white">Ajouter</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade text-left " id="cellierEdit" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel44" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title" id="myModalLabel33">Modifier </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path
                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                    </svg>
                                </button>
                            </div>
                            <form id="formEdit" method="POST" enctype="multipart/form-data">

                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
                                    </div>
                                    <label>Client: </label>
                                    <div class="form-group">
                                        <select name="client_id" class="form-control">
                                            <option value="">--</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">
                                                    {{ $client->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block text-white">Modifier</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-3">
                            <h5 class="card-title">Celliers</h5>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#cellier"
                                class="btn btn-primary">Ajouter</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>

                                        <th scope="col">Numéro</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residence->cellier as $cellier)
                                        <tr>

                                            <td>{{ $cellier->name }}</td>
                                            <td>
                                                @if ($cellier->client)
                                                    {{ $cellier->client->name }} {{ $cellier->client->lastName }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>

                                                <div class="d-flex">
                                                    <button id="{{ $cellier->id }}"
                                                        class="btn btn-warning editCellier m-1" data-bs-toggle="modal"
                                                        data-bs-target="#cellierEdit"><i
                                                            data-feather="edit"></i>Modifier</button>
                                                    <form method="GET"
                                                        action="{{ route('celliers.destroy', $cellier->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger m-1"><i
                                                                data-feather="trash"></i>Supprimer</button>
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-3">
                            <h5 class="card-title">Clients</h5>

                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Prénom</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Numéro de téléphone</th>
                                        <th scope="col">CIN</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Date Réservation</th>
                                        <th scope="col">Commentaires</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residence->etage as $etage)
                                        @foreach ($etage->appart as $appart)
                                            @if ($appart->client)
                                                <tr>
                                                    <td>{{ $appart->client->name }}</td>
                                                    <td>{{ $appart->client->lastName }}</td>
                                                    <td>{{ $appart->client->email }}</td>
                                                    <td>{{ $appart->client->phone }}</td>
                                                    <td>{{ $appart->client->cin }}</td>
                                                    <td>
                                                        @if ($appart->client->type == 0)
                                                            Client
                                                        @else
                                                            Prospect
                                                        @endif
                                                    </td>
                                                    <td>{{ $appart->client->date_res }}</td>
                                                    <td>{{ $appart->client->comments }}</td>
                                                    <td>
                                                        <button id="{{ $client->id }}"
                                                            class="btn btn-warning editClient" data-bs-toggle="modal"
                                                            data-bs-target="#inlineFormEditClient"><i
                                                                data-feather="edit"></i>Modifier</button>
                                                        <button onclick="deleteClient({{ $client->id }})"
                                                            class="btn btn-danger"><i
                                                                data-feather="trash"></i>Supprimer</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade text-left " id="inlineFormEditClient" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel44" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel33">Modifier </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                        <path
                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                    </svg>
                                </button>
                            </div>
                            <form id="editForm" method="POST" action="{{ route('clients.store') }}">
                                @csrf
                                <div class="modal-body">
                                    <label>Nom: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Nom" class="form-control">
                                    </div>
                                    <label>Prenom: </label>
                                    <div class="form-group">
                                        <input type="text" name="lastName" placeholder="Prénom" class="form-control">
                                    </div>
                                    <label>Numéro de téléphone: </label>
                                    <div class="form-group">
                                        <input type="text" name="phone" placeholder="Numéro de téléphone"
                                            class="form-control">
                                    </div>
                                    <label>Numéro CIN: </label>
                                    <div class="form-group">
                                        <input type="text" name="cin" placeholder="Numéro CIN"
                                            class="form-control">
                                    </div>
                                    <label>Email: </label>
                                    <div class="form-group">
                                        <input type="text" name="email" placeholder="Email" class="form-control">
                                    </div>
                                    <label>Type: </label>
                                    <div class="form-group">
                                        <select name="type" id="" class="form-control">
                                            <option value="0">Client</option>
                                            <option value="1">Prospect</option>
                                        </select>
                                    </div>
                                    <label>Date Réservation: </label>
                                    <div class="form-group">
                                        <input type="date" name="date_res" placeholder="Numéro CIN"
                                            class="form-control">
                                    </div>
                                    <label>Commentaires: </label>
                                    <div class="form-group">
                                        <textarea name="comments" id="" cols="30" rows="10" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="edit" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Annuler</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block text-white">Modifier</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-3">
                            <h5 class="card-title">Échéanciers</h5>

                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>
                                        <th scope="col">Total Échanciers</th>
                                        <th scope="col">Total Payé</th>
                                        <th scope="col">Total Restant</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{ $total_echance }}</td>
                                        <td>{{ $total_echeance }}</td>
                                        <td>{{ $total_echance - $total_echeance }}</td>


                                        <td>

                                            <div class="d-flex">
                                                <a href="{{ route('echances') }}?res={{ $residence->id }}"
                                                    class="btn btn-primary edit m-1"><i
                                                        data-feather="plus-circle"></i>Details</a>
                                            </div>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-3">
                            <h5 class="card-title">Charges</h5>

                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>
                                        <th scope="col">Total Sonede</th>
                                        <th scope="col">Total Syndic</th>
                                        <th scope="col">Total Avocat</th>
                                        <th scope="col">Total Contrat</th>
                                        <th scope="col">Total Fncier</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{ $total_sonede }}</td>
                                        <td>{{ $total_syndic }}</td>
                                        <td>{{ $total_avocat }}</td>
                                        <td>{{ $total_contrat }}</td>
                                        <td>{{ $total_foncier }}</td>
                                        <td>{{ $total_sonede + $total_syndic + $total_avocat + $total_contrat + $total_foncier }}
                                        </td>


                                        <td>

                                            <div class="d-flex">
                                                <a href="{{ route('charges') }}?res={{ $residence->id }}"
                                                    class="btn btn-primary edit m-1"><i
                                                        data-feather="plus-circle"></i>Details</a>
                                            </div>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
            <!--End Row-->
            <div class="modal fade text-left " id="inlineForm" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                </svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('parkings.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                                <label>Place Parking: </label>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Place Parking"
                                        class="form-control">
                                </div>
                                <label>Numero: </label>
                                <div class="form-group">
                                    <input type="text" name="number" placeholder="Numero" class="form-control">
                                </div>
                                <label>Client: </label>
                                <div class="form-group">
                                    <select name="client_id" class="form-control">
                                        <option value="">--</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block text-white">Ajouter</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade text-left " id="inlineFormEdit" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel44" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="card-title" id="myModalLabel33">Modifier </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                </svg>
                            </button>
                        </div>
                        <form id="formEditParking" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="modal-body">
                                <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                                <label>Place Parking: </label>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Place Parking"
                                        class="form-control">
                                </div>
                                <label>Numero: </label>
                                <div class="form-group">
                                    <input type="text" name="number" placeholder="Numero" class="form-control">
                                </div>
                                <label>Client: </label>
                                <div class="form-group">
                                    <select name="client_id" class="form-control">
                                        <option value="">--</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block text-white">Modifier</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade text-left " id="inlineResEdit" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel44" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="card-title" id="myModalLabel33">Modifier </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                </svg>
                            </button>
                        </div>
                        <form id="resEdit" method="POST" action="{{ route('residences.update', $residence->id) }}"
                            enctype="multipart/form-data">

                            @csrf
                            <div class="modal-body">
                                <label>Nom de la résidence: </label>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Nom de la résidence"
                                        class="form-control">
                                </div>
                                <label>Addresse: </label>
                                <div class="form-group">
                                    <input type="text" name="address" placeholder="Addresse" class="form-control">
                                </div>

                                <label>N° du titre Foncier: </label>
                                <div class="form-group">
                                    <input type="text" name="nfoncier" placeholder="N° du titre Foncier"
                                        class="form-control">
                                </div>

                                <label>Emplacement: </label>
                                <div class="form-group">
                                    <input type="text" name="emplacemnt" placeholder="Emplacement"
                                        class="form-control">
                                </div>

                                <label>N° du permis de bâtir: </label>
                                <div class="form-group">
                                    <input type="text" name="npermis" placeholder="N° du permis de bâtir"
                                        class="form-control">
                                </div>

                                <label>Détail Municipalité: </label>
                                <div class="form-group">
                                    <input type="text" name="detailMunicipal" placeholder="Détail Municipalité"
                                        class="form-control">
                                </div>
                                <label>Detail Résidence </label>
                                <input type="file" name="details[]" class="image-preview-filepondEdit" />

                                <label>Gallery </label>
                                <input type="file" name="gallery[]" class="multiple-files-filepondEdit" multiple>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block text-white">Modifier</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>




            <!--start overlay-->
            <div class="overlay toggle-menu"></div>
            <!--end overlay-->
        </div>
        <!-- End container-fluid-->
    </div>
@endsection

@section('scripts')




    <script src="{{ asset('dist/js/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('dist/js/vendors.js') }}"></script>



    <script>
        const editButtons = document.getElementsByClassName('editCellier');
        editButtons.forEach = Array.prototype.forEach;
        editButtons.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEdit');

                let base = '{{ route('celliers.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const cleintInput = form.querySelector('select[name="client_id"]')

                url = "{{ route('celliers.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;

                    nameInput.value = appart.name;
                    cleintInput.value = appart.client_id;

                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>

    <script>
        const editButtonsParking = document.getElementsByClassName('edit');
        editButtonsParking.forEach = Array.prototype.forEach;
        editButtonsParking.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEditParking');

                let base = '{{ route('parkings.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const numberInput = form.querySelector('input[name="number"]')
                const cleintInput = form.querySelector('select[name="client_id"]')

                url = "{{ route('parkings.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;
                    nameInput.value = appart.name;
                    numberInput.value = appart.number;
                    cleintInput.value = appart.client_id;

                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
    <script>
        const forms = document.querySelectorAll('form');

        forms.forEach((form) => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                if (form.method != 'get') {
                    fetch(form.action, {
                            method: form.method,
                            body: formData,
                        })
                        .then((response) => {
                            window.location.reload();
                        })
                        .catch((error) => {
                            console.error('An error occurred:', error);
                        });
                } else {
                    axios.get(form.action).then((reponse) => {
                        window.location.reload();
                    }).catch((error) => {
                        console.log(error)
                    })
                }
            });
        });
    </script>
    <script>
        const editButtonsRes = document.getElementById('resEd');


        editButtonsRes.addEventListener('click', function() {
            const form = document.getElementById('resEdit');



            const nameInput = form.querySelector('input[name="name"]');
            const adressInput = form.querySelector('input[name="address"]');
            const nfoncierInput = form.querySelector('input[name="nfoncier"]');
            const emplacemntInput = form.querySelector('input[name="emplacemnt"]');
            const npermisInput = form.querySelector('input[name="npermis"]');
            const detailMunicipalInput = form.querySelector('input[name="detailMunicipal"]');
            url = "{{ route('residences.get', 5) }}";
            url = url.replace('5', '{{ $residence->id }}');
            axios.get(url).then((reponse) => {
                const residence = reponse.data;
                nameInput.value = residence.name;
                adressInput.value = residence.address;
                nfoncierInput.value = residence.nfoncier;
                emplacemntInput.value = residence.emplacemnt;
                npermisInput.value = residence.npermis;
                detailMunicipalInput.value = residence.detailMunicipal;
                const options2 = {
                    credits: null,
                    allowImagePreview: false,
                    allowImageFilter: false,
                    allowImageExifOrientation: false,
                    allowMultiple: true,
                    required: false,
                    storeAsFile: true,
                    fileValidateTypeDetectType: (source, type) =>
                        new Promise((resolve, reject) => {
                            resolve(type);
                        }),
                    labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
                }
                if (residence.file) {
                    const files = []
                    residence.file.forEach((img) => {

                        files.push({
                            source: '{{ route('dashboard') }}/' + img.path,
                        })
                    })
                    options2.files = files
                }
                FilePond.create(document.querySelector('.image-preview-filepondEdit'),
                    options2);


                const options = {
                    credits: null,
                    allowImagePreview: true,
                    allowImageFilter: false,
                    allowImageExifOrientation: false,
                    allowMultiple: true,
                    required: false,
                    storeAsFile: true,
                    acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
                    fileValidateTypeDetectType: (source, type) =>
                        new Promise((resolve, reject) => {
                            resolve(type);
                        }),
                    labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action">Browse</span></span>`,
                }
                if (residence.image) {
                    const files = []
                    residence.image.forEach((img) => {

                        files.push({
                            source: '{{ route('dashboard') }}/' + img.path,
                        })
                    })
                    options.files = files
                }

                FilePond.create(document.querySelector(".multiple-files-filepondEdit"),
                    options);


            }).catch((error) => {
                console.log(error)
            })
        });

        function createFileInput(className) {
            FilePond.create(document.querySelector(className), {
                credits: null,
                allowImagePreview: true,
                allowImageFilter: false,
                allowImageExifOrientation: false,
                allowImageCrop: false,
                acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
                fileValidateTypeDetectType: (source, type) =>
                    new Promise((resolve, reject) => {
                        resolve(type);
                    }),
                storeAsFile: true,
                labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
            });
        }
        createFileInput(".image-preview-filepondEtage");

        function deleteClient(id) {
            var form = document.getElementById('delete');
            let base = '{{ route('clients.destroy', '5') }}';
            base = base.replace('5', id);
            form.action = base;
            form.method = 'DELETE';
            form.submit();
        }

        const editClient = document.getElementsByClassName('editClient');
        editClient.forEach = Array.prototype.forEach;
        editClient.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('editForm');

                let base = '{{ route('clients.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]');
                const lastNameInput = form.querySelector('input[name="lastName"]');
                const phoneInput = form.querySelector('input[name="phone"]');
                const cinInput = form.querySelector('input[name="cin"]');
                const emailInput = form.querySelector('input[name="email"]');
                const resInput = form.querySelector('input[name="date_res"]');
                const typeInput = form.querySelector('select[name="type"]');
                const commentsArea = form.querySelector('textarea[name="comments"]');
                url = "{{ route('clients.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const client = reponse.data;
                    nameInput.value = client.name;
                    lastNameInput.value = client.lastName;
                    phoneInput.value = client.phone;
                    cinInput.value = client.cin;
                    emailInput.value = client.email;
                    typeInput.value = client.type;
                    resInput.value = client.date_res;
                    commentsArea.innerHTML = client.comments
                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
@endsection
