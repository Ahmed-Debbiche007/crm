@extends('welcome')
@section('title', 'Résidences')
@section('styles')

@endsection

@section('content')
    <div class="content-wrapper p-2">
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
                @if (Auth::user()->role == 1)
                    <button type="button" data-bs-toggle="modal" data-bs-target="#inlineResEdit" id="resEd"
                        class=" btn btn-warning mb-1 mt-1">Modifier</button>
                @endif
                <h5 class="card-title">Étages:</h5>
                @if (Auth::user()->role == 1)
                    <button type="button" data-bs-toggle="modal" data-bs-target="#inlineEtage" id="resEd"
                        class="btn btn-primary mb-1 mt-1">Ajouter</button>
                @endif
                <div class="row d-flex flex-wrap">
                    @foreach ($residence->etage as $etage)
                        <div class="w-50">
                            <div class="card m-2">
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
                            @if (Auth::user()->role == 1)
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>

                                        <th scope="col">Place Parking</th>
                                        <th scope="col">Numéro</th>
                                        <th scope="col">Client</th>
                                        @if (Auth::user()->role == 1)
                                            <th scope="col" class="noExport">Actions</th>
                                        @endif
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
                                            @if (Auth::user()->role == 1)
                                                <td>

                                                    <div class="d-flex">
                                                        <button id="{{ $parking->id }}" class="btn btn-warning edit m-1"
                                                            data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                                data-feather="editCellier"></i>Modifier</button>

                                                        <form method="GET"
                                                            action="{{ route('parkings.destroy', $parking->id) }}">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger m-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#inlineParkingDelete{{ $parking->id }}"><i
                                                                    data-feather="trash"></i>Supprimer</button>
                                                            <div class="modal fade"
                                                                id="inlineParkingDelete{{ $parking->id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Confirmation</h5>
                                                                            <button type="button" class="close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Êtes-vous sûr de vouloir supprimer ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Annuler</button>
                                                                            <button id="deleteButton" type="submit"
                                                                                class="btn btn-danger">Confirmer</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </td>
                                            @endif
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
                                        <select name="name" class="form-control">
                                            <option value="Sous Sol">Sous Sol</option>
                                            <option value="Rez de chaussée">Rez de chaussée</option>
                                            <option value="Mezzanine">Mezzanine</option>
                                            <option value="Étage 1">Étage 1</option>
                                            <option value="Étage 2">Étage 2</option>
                                            <option value="Étage 3">Étage 3</option>
                                            <option value="Étage 4">Étage 4</option>
                                            <option value="Étage 5">Étage 5</option>
                                            <option value="Étage 6">Étage 6</option>
                                            <option value="Étage 7">Étage 7</option>
                                            <option value="Étage 8">Étage 8</option>
                                        </select>
                                    </div>
                                    <label>Plan: </label>
                                    <input type="file" name="plan" class="image-preview-filepondEtage" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">

                                        <span class="d-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">

                                        <span class="d-block text-white">Ajouter</span>
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
                                    <label>Residence: </label>
                                    <div class="form-group">
                                        <select name="residence_id" class="form-control" id="residencesAdd">
                                            <option value="{{ $residence->id }}">{{ $residence->name }}
                                            </option>
                                        </select>
                                    </div>
                                    <label>Etage: </label>
                                    <div class="form-group">
                                        <select name="etage_id" id="addetage" class="form-control">
                                            @foreach ($residence->etage as $etage)
                                                <option value="{{ $etage->id }}">{{ $etage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label>Bien Immobilier: </label>
                                    <div class="form-group">
                                        <select name="appart_id" id="appartAdd" class="form-control">

                                        </select>
                                    </div>
                                    <div class="d-flex"><label class="mx-1">Client: </label>
                                        <p id="clientAdd"></p>
                                    </div>
                                    <input type="hidden" name="client_id" id="clientAddInput">
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
                                    </div>
                                    <label>Surface: </label>
                                    <div class="form-group">
                                        <input type="number" name="surface" placeholder="Surface" class="form-control" step="0.001">
                                    </div>
                                    <label>Prix: </label>
                                    <div class="form-group">
                                        <input type="number" name="price" placeholder="Prix" step="0.001"
                                            class="form-control">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">

                                        <span class="d-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">

                                        <span class="d-block text-white">Ajouter</span>
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
                                    <label>Residence: </label>
                                    <div class="form-group">
                                        <select name="residence_id" class="form-control" id="residencesEdit">
                                            <option value="{{ $residence->id }}">
                                                {{ $residence->name }}</option>
                                        </select>
                                    </div>
                                    <label>Etage: </label>
                                    <div class="form-group">
                                        <select name="etage_id" id="editetage" class="form-control">
                                            @foreach ($residence->etage as $etage)
                                                <option value="{{ $etage->id }}">{{ $etage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label>Bien Immobilier: </label>
                                    <div class="form-group">
                                        <select name="appart_id" id="appartEdit" class="form-control">

                                        </select>
                                    </div>
                                    <div class="d-flex"><label class="mx-1">Client: </label>
                                        <p id="detailsEdit"></p>
                                    </div>
                                    <input type="hidden" name="client_id" id="clientAddInput">
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
                                    </div>
                                    <label>Surface: </label>
                                    <div class="form-group">
                                        <input type="number" name="surface" placeholder="Surface" class="form-control" step="0.001">
                                    </div>
                                    <label>Prix: </label>
                                    <div class="form-group">
                                        <input type="number" name="price" placeholder="Prix" step="0.001"
                                            class="form-control">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">

                                        <span class="d-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">

                                        <span class="d-block text-white">Modifier</span>
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
                            @if (Auth::user()->role == 1)
                                <button type="button" data-bs-toggle="modal" data-bs-target="#cellier"
                                    class="btn btn-primary">Ajouter</button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>

                                        <th scope="col">Numéro</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Surface</th>
                                        <th scope="col">Prix</th>
                                        @if (Auth::user()->role == 1)
                                            <th scope="col" class="noExport">Actions</th>
                                        @endif
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
                                            <td>{{ $cellier->surface }}</td>
                                            <td>{{ number_format(floatval($cellier->price), 3, '.', ' ') }}</td>
                                            @if (Auth::user()->role == 1)
                                                <td>

                                                    <div class="d-flex">
                                                        <button id="{{ $cellier->id }}"
                                                            class="btn btn-warning editCellier m-1" data-bs-toggle="modal"
                                                            data-bs-target="#cellierEdit"><i
                                                                data-feather="edit"></i>Modifier</button>

                                                        <form method="GET"
                                                            action="{{ route('celliers.destroy', $cellier->id) }}">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger m-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#inlineCellierDelete{{ $cellier->id }}"><i
                                                                    data-feather="trash"></i>Supprimer</button>
                                                            <div class="modal fade"
                                                                id="inlineCellierDelete{{ $cellier->id }}"
                                                                tabindex="-1" role="dialog"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Confirmation</h5>
                                                                            <button type="button" class="close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Êtes-vous sûr de vouloir supprimer ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Annuler</button>
                                                                            <button id="deleteButton" type="submit"
                                                                                class="btn btn-danger">Confirmer</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade text-left " id="garage" tabindex="-1" role="dialog"
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
                            <form method="POST" action="{{ route('garages.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <label>Residence: </label>
                                    <div class="form-group">
                                        <select name="residence_id" class="form-control" id="residencesAddGarage">
                                            <option value="{{ $residence->id }}">{{ $residence->name }}
                                            </option>
                                        </select>
                                    </div>
                                    <label>Etage: </label>
                                    <div class="form-group">
                                        <select name="etage_id" id="addetageGarage" class="form-control">
                                            @foreach ($residence->etage as $etage)
                                                <option value="{{ $etage->id }}">{{ $etage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label>Bien Immobilier: </label>
                                    <div class="form-group">
                                        <select name="appart_id" id="appartAddGarage" class="form-control">

                                        </select>
                                    </div>
                                    <div class="d-flex"><label class="mx-1">Client: </label>
                                        <p id="clientAddGarage"></p>
                                    </div>
                                    <input type="hidden" name="client_id" id="clientAddInputGarage">
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
                                    </div>
                                    <label>Surface: </label>
                                    <div class="form-group">
                                        <input type="number" name="surface" placeholder="Surface" class="form-control" step="0.001">
                                    </div>
                                    <label>Prix: </label>
                                    <div class="form-group">
                                        <input type="number" name="price" placeholder="Prix" step="0.001"
                                            class="form-control">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">

                                        <span class="d-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">

                                        <span class="d-block text-white">Ajouter</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade text-left " id="garageEdit" tabindex="-1" role="dialog"
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
                            <form id="formEditGarage" method="POST" enctype="multipart/form-data">

                                @csrf
                                <div class="modal-body">
                                    <label>Residence: </label>
                                    <div class="form-group">
                                        <select name="residence_id" class="form-control" id="residencesEditGarage">
                                            <option value="{{ $residence->id }}">
                                                {{ $residence->name }}</option>
                                        </select>
                                    </div>
                                    <label>Etage: </label>
                                    <div class="form-group">
                                        <select name="etage_id" id="editetageGarage" class="form-control">
                                            @foreach ($residence->etage as $etage)
                                                <option value="{{ $etage->id }}">{{ $etage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label>Bien Immobilier: </label>
                                    <div class="form-group">
                                        <select name="appart_id" id="appartEditGarage" class="form-control">

                                        </select>
                                    </div>
                                    <div class="d-flex"><label class="mx-1">Client: </label>
                                        <p id="detailsEditGarage"></p>
                                    </div>
                                    <input type="hidden" name="client_id" id="clientAddInputGarage">
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
                                    </div>
                                    <label>Surface: </label>
                                    <div class="form-group">
                                        <input type="number" name="surface" placeholder="Surface" class="form-control" step="0.001">
                                    </div>
                                    <label>Prix: </label>
                                    <div class="form-group">
                                        <input type="number" name="price" placeholder="Prix" step="0.001"
                                            class="form-control">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">

                                        <span class="d-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">

                                        <span class="d-block text-white">Modifier</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-3">
                            <h5 class="card-title">Garages</h5>
                            @if (Auth::user()->role == 1)
                                <button type="button" data-bs-toggle="modal" data-bs-target="#garage"
                                    class="btn btn-primary">Ajouter</button>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>

                                        <th scope="col">Numéro</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Surface</th>
                                        <th scope="col">Prix</th>
                                        @if (Auth::user()->role == 1)
                                            <th scope="col" class="noExport">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residence->garage as $garage)
                                        <tr>

                                            <td>{{ $garage->name }}</td>
                                            <td>
                                                @if ($garage->client)
                                                    {{ $garage->client->name }} {{ $garage->client->lastName }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>{{ $garage->surface }}</td>
                                            <td>{{ number_format(floatval($garage->price), 3, '.', ' ') }}</td>
                                            @if (Auth::user()->role == 1)
                                                <td>

                                                    <div class="d-flex">
                                                        <button id="{{ $garage->id }}"
                                                            class="btn btn-warning garageEdit m-1" data-bs-toggle="modal"
                                                            data-bs-target="#garageEdit"><i
                                                                data-feather="edit"></i>Modifier</button>

                                                        <form method="GET"
                                                            action="{{ route('garages.destroy', $garage->id) }}">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger m-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#inlineGarageDelete{{ $garage->id }}"><i
                                                                    data-feather="trash"></i>Supprimer</button>
                                                            <div class="modal fade"
                                                                id="inlineGarageDelete{{ $garage->id }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="exampleModalLabel">
                                                                                Confirmation</h5>
                                                                            <button type="button" class="close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Êtes-vous sûr de vouloir supprimer ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Annuler</button>
                                                                            <button id="deleteButton" type="submit"
                                                                                class="btn btn-danger">Confirmer</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </td>
                                            @endif
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
                                        <th scope="col">CIN/MF</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Date Réservation</th>
                                        <th scope="col">Commentaires</th>
                                        @if (Auth::user()->role == 1)
                                            <th scope="col" class="noExport">Actions</th>
                                        @endif
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
                                                    @if (Auth::user()->role == 1)
                                                        <td>
                                                            <button id="{{ $appart->client->id }}"
                                                                class="btn btn-warning editClient" data-bs-toggle="modal"
                                                                data-bs-target="#inlineFormEditClient"><i
                                                                    data-feather="edit"></i>Modifier</button>

                                                            <form method="GET"
                                                                action="{{ route('clients.destroy', $appart->client->id) }}">
                                                                @csrf
                                                                <button type="button" class="btn btn-danger m-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#inlineClientDelete{{ $appart->client->id }}"><i
                                                                        data-feather="trash"></i>Supprimer</button>
                                                                <div class="modal fade"
                                                                    id="inlineClientDelete{{ $appart->client->id }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">
                                                                                    Confirmation</h5>
                                                                                <button type="button" class="close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Êtes-vous sûr de vouloir supprimer ?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                                <button id="deleteButton" type="submit"
                                                                                    class="btn btn-danger">Confirmer</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    @endif
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

                                        <span class="d-block">Annuler</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-1">

                                        <span class="d-block text-white">Modifier</span>
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
                                        <th scope="col" class="noExport">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{ number_format(floatval($total_echance), 3, '.', ',') }}</td>
                                        <td>{{ number_format(floatval($total_echeance), 3, '.', ',') }}</td>
                                        <td>{{ number_format(floatval($total_echance - $total_echeance), 3, '.', ',') }}
                                        </td>


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

                                        <th scope="col">Total Foncier</th>
                                        <th scope="col">Total</th>
                                        <th scope="col" class="noExport">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>{{ number_format(floatval($total_sonede), 3, '.', ',') }}</td>
                                        <td>{{ number_format(floatval($total_syndic), 3, '.', ',') }}</td>

                                        <td>{{ number_format(floatval($total_contrat), 3, '.', ',') }}</td>
                                        <td>{{ number_format(floatval($total_foncier), 3, '.', ',') }}</td>
                                        <td>{{ number_format(floatval($total_sonede + $total_syndic + $total_avocat + $total_contrat + $total_foncier), 3, '.', ',') }}
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

                                    <span class="d-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">

                                    <span class="d-block text-white">Ajouter</span>
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

                                    <span class="d-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">

                                    <span class="d-block text-white">Modifier</span>
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

                                    <span class="d-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ml-1">

                                    <span class="d-block text-white">Modifier</span>
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



    <script src="{{ asset('dist/js/DataTables/datatables.js') }}"></script>
    <script src="{{ asset('dist/js/vendors.js') }}"></script>



    <script>
        const editButtons = document.getElementsByClassName('editCellier');
        editButtons.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('editCellier')) {
                const form = document.getElementById('formEdit');
                const editButton = target;
                let base = '{{ route('celliers.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const etage_idInput = form.querySelector('select[name="etage_id"]')
                const appart_idInput = form.querySelector('select[name="appart_id"]')
                const cleintInput = form.querySelector('input[name="client_id"]')
                const surfaceInput = form.querySelector('input[name="surface"]')
                const priceInput = form.querySelector('input[name="price"]')

                url = "{{ route('celliers.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;

                    nameInput.value = appart.name;
                    residence_idInput.value = appart.residence_id;
                    loadEtages(residence_idInput.value, 'editetage');

                    etage_idInput.value = appart.etage_id;
                    
                    loadApparts(etage_idInput.value, 'appartEdit');
                    appart_idInput.value = appart.appart_id;

                    cleintInput.value = appart.client_id;
                    surfaceInput.value = appart.surface;
                    priceInput.value = appart.price

                    const divDetails = document.getElementById('detailsEdit');
                    const clientInput = divDetails.parentElement.parentElement.querySelector(
                        'input[name="client_id"]')
                    const detailsClient = document.createElement('h4');

                    divDetails.innerHTML = '';
                    if (appart.client) {
                        detailsClient.innerHTML = ' ' + appart.client.name + ' ' + appart.client.lastName;
                        clientInput.value = appart.client.id;
                    } else {
                        detailsClient.innerHTML = ' Pas de client';
                        clientInput.value = '';
                    }
                    divDetails.appendChild(detailsClient);
                }).catch((error) => {
                    console.log(error)
                })
            };
            if (target.classList.contains('garageEdit')) {
                const form = document.getElementById('formEditGarage');
                const editButton = target;
                let base = '{{ route('garages.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const etage_idInput = form.querySelector('select[name="etage_id"]')
                const appart_idInput = form.querySelector('select[name="appart_id"]')
                const cleintInput = form.querySelector('input[name="client_id"]')
                const surfaceInput = form.querySelector('input[name="surface"]')
                const priceInput = form.querySelector('input[name="price"]')

                url = "{{ route('garages.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;


                    nameInput.value = appart.name;
                    residence_idInput.value = appart.residence_id;
                    loadEtages(residence_idInput.value, 'editetageGarage');

                    etage_idInput.value = appart.etage_id;
                    
                    loadApparts(etage_idInput.value, 'appartEditGarage');
                    appart_idInput.value = appart.appart_id;

                    cleintInput.value = appart.client_id;
                    surfaceInput.value = appart.surface;
                    priceInput.value = appart.price

                    const divDetails = document.getElementById('detailsEditGarage');
                    const clientInput = divDetails.parentElement.parentElement.querySelector(
                        'input[name="client_id"]')
                    const detailsClient = document.createElement('h4');

                    divDetails.innerHTML = '';
                    if (appart.client) {
                        detailsClient.innerHTML = ' ' + appart.client.name + ' ' + appart.client.lastName;
                        clientInput.value = appart.client.id;
                    } else {
                        detailsClient.innerHTML = ' Pas de client';
                        clientInput.value = '';
                    }
                    divDetails.appendChild(detailsClient);
                }).catch((error) => {
                    console.log(error)
                })
            };
        })
    </script>

    <script>
        const editButtonsParking = document.getElementsByClassName('edit');
        editButtonsParking.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const form = document.getElementById('formEditParking');
                const editButton = target;
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
            };
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
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('editClient')) {
                const form = document.getElementById('editForm');
                const editButton = target;
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
            };
        })
    </script>
    <script>
        const residence = @json($residence);
        const data = [residence];

        function loadEtages(id, etageId) {
            const selectEtage = document.getElementById(etageId)
            selectEtage.innerHTML = ''
            data.forEach(residence => {
                if (residence.id == id) {
                    residence.etage.sort((a, b) => {
                        if (a.name < b.name) {
                            return -1;
                        }
                        if (a.name > b.name) {
                            return 1;
                        }
                        return 0;
                    })
                    residence.etage.forEach(e => {
                        const option = document.createElement('option')
                        option.value = e.id
                        option.innerHTML = e.name
                        selectEtage.appendChild(option)
                    })
                }
            })
        }

        function loadApparts(id, appartId) {
            const selectAppart = document.getElementById(appartId)
            
            selectAppart.innerHTML = ''
            data.forEach(residence => {
                residence.etage.forEach((etage) => {
                    if (etage.id == id) {
                        etage.appart.sort((a, b) => {
                            if (a.name < b.name) {
                                return -1;
                            }
                            if (a.name > b.name) {
                                return 1;
                            }
                            return 0;
                        })
                        etage.appart.forEach(appart => {
                            const option = document.createElement('option')
                            option.value = appart.id
                            option.innerHTML = appart.name
                            selectAppart.appendChild(option)
                        })
                    }
                })
            })
        }

        const getDetailsAppart = (id, select) => {
            let route = '{{ route('apparts.get', '5') }}';
            route = route.replace('5', id);
            axios.get(route).then((reponse) => {
                const appart = reponse.data;
                const divDetails = document.getElementById(select);
                const clientInput = divDetails.parentElement.parentElement.querySelector(
                    'input[name="client_id"]')
                const detailsClient = document.createElement('h4');
                divDetails.innerHTML = '';
                if (appart.client) {
                    detailsClient.innerHTML = ' ' + appart.client.name + ' ' + appart.client.lastName;
                    clientInput.value = appart.client.id;
                } else {
                    detailsClient.innerHTML = ' Pas de client';
                    clientInput.value = '';
                }
                divDetails.appendChild(detailsClient);



            }).catch((error) => {
                console.log(error)
            })
        }

        const selectEtages = document.getElementById('residencesAdd')
        const listApparts = document.getElementById('appartAdd');
        loadEtages(selectEtages.value, 'addetage');
        const selectApparts = document.getElementById('addetage');
        loadApparts(selectApparts.value, 'appartAdd');
        getDetailsAppart(listApparts.value, 'clientAdd')
        selectEtages.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'addetage')
            const selectApparts = document.getElementById('addetage');
            loadApparts(selectApparts.value, 'appartAdd');
            getDetailsAppart(listApparts.value, 'clientAdd')
        })
        selectApparts.addEventListener('change', (e) => {
            const id = e.target.value
            loadApparts(id, 'appartAdd');
            getDetailsAppart(listApparts.value, 'clientAdd')
        })
        listApparts.addEventListener('change', (e) => {
            const id = e.target.value;
            getDetailsAppart(id, 'clientAdd');

        })
        const selectEtagesEdit = document.getElementById('residencesEdit')
        const selectAppartsEdit = document.getElementById('editetage');
        const listAppartsEdit = document.getElementById('appartEdit');

        selectEtagesEdit.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'editetage')
            const selectApparts = document.getElementById('editetage');
            loadApparts(selectApparts.value, 'appartEdit');

            getDetailsAppart(listAppartsEdit.value, 'detailsEdit');
        })
        selectAppartsEdit.addEventListener('change', (e) => {
            const id = e.target.value;
            loadApparts(id, 'appartEdit');
            getDetailsAppart(listAppartsEdit.value, 'detailsEdit')

        })

        listAppartsEdit.addEventListener('change', (e) => {
            const id = e.target.value;
            getDetailsAppart(id, 'detailsEdit');

        })



        ///////////////


        const selectEtagesGarage = document.getElementById('residencesAddGarage')
        const listAppartsGarage = document.getElementById('appartAddGarage');
        loadEtages(selectEtagesGarage.value, 'addetageGarage');
        const selectAppartsGarage = document.getElementById('addetageGarage');
        loadApparts(selectAppartsGarage.value, 'appartAddGarage');
        getDetailsAppart(listAppartsGarage.value, 'clientAddGarage')
        selectEtagesGarage.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'addetageGarage')
            const selectAppartsGarage = document.getElementById('addetageGarage');
            loadApparts(selectAppartsGarage.value, 'appartAddGarage');
            getDetailsAppart(listAppartsGarage.value, 'clientAddGarage')
        })
        selectAppartsGarage.addEventListener('change', (e) => {
            const id = e.target.value
            loadApparts(id, 'appartAddGarage');
            getDetailsAppart(listAppartsGarage.value, 'clientAddGarage')
        })
        listAppartsGarage.addEventListener('change', (e) => {
            const id = e.target.value;
            getDetailsAppart(id, 'clientAddGarage');

        })
        const selectEtagesEditGarage = document.getElementById('residencesEditGarage')
        const selectAppartsEditGarage = document.getElementById('editetageGarage');
        const listAppartsEditGarage = document.getElementById('appartEditGarage');

        selectEtagesEditGarage.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'editetageGarage')
            const selectAppartsGarage = document.getElementById('editetageGarage');
            loadApparts(selectAppartsGarage.value, 'appartEditGarage');

            getDetailsAppart(listAppartsEditGarage.value, 'detailsEditGarage');
        })
        selectAppartsEditGarage.addEventListener('change', (e) => {
            const id = e.target.value;
            loadApparts(id, 'appartEditGarage');
            getDetailsAppart(listAppartsEditGarage.value, 'detailsEditGarage')

        })

        listAppartsEditGarage.addEventListener('change', (e) => {
            const id = e.target.value;
            getDetailsAppart(id, 'detailsEditGarage');

        })
    </script>
@endsection
