@extends('welcome')
@section('title', 'Appartements')
@section('styles')
    <link href="{{ asset('dist/css/hotspot/hotspot.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/hotspot/style.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <h5 class="card-title">Gallery:</h5>
                    @if ($appart->image && $appart->image->count() > 0)
                        <div id="carouselExample" class="carousel slide m-3">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset($appart->image[0]->path) }}" class="d-block w-100"
                                        style="height: 500px; object-fit: contain;">
                                </div>
                                @foreach ($appart->image as $key => $image)
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
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Appartement</h5>

                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Appartement</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Etage</th>
                                            <th scope="col">Résidence</th>
                                            <th scope="col">Surface</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Prix</th>
                                            <th scope="col">Statut</th>
                                            <th scope="col">Commentaire</th>
                                            <th scope="col">Charges</th>
                                            <th scope="col">Échanciers</th>

                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>{{ $appart->name }}</td>
                                            <td>
                                                @if ($appart->client)
                                                    {{ $appart->client->name }} {{ $appart->client->lastName }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>{{ $appart->etage->name }}</td>
                                            <td>{{ $appart->etage->building->name }}</td>
                                            <td>{{ $appart->surface }}</td>
                                            <td>
                                                @if ($appart->bs == 0)
                                                    Commerce
                                                @endif
                                                @if ($appart->bs == 1)
                                                    Duplex
                                                @endif
                                                @if ($appart->bs == 2)
                                                    Duplex - 1
                                                @endif
                                                @if ($appart->bs == 3)
                                                    S+1
                                                @endif
                                                @if ($appart->bs == 4)
                                                    S+2
                                                @endif
                                                @if ($appart->bs == 5)
                                                    S+3
                                                @endif
                                            </td>
                                            <td>{{ $appart->price }}</td>
                                            <td>
                                                @if ($appart->bs == 0)
                                                    Libre
                                                @endif
                                                @if ($appart->bs == 1)
                                                    Loué
                                                @endif
                                                @if ($appart->bs == 2)
                                                    Réservé
                                                @endif
                                                @if ($appart->bs == 3)
                                                    Vendu
                                                @endif
                                            </td>

                                            <td>{{ $appart->comments }}</td>
                                            <td> <a href="{{ route('charges') }}?appart={{ $appart->id }}"
                                                    class="badge bg-success">Charges</a> </td>
                                            <td> <a href="{{ route('echances') }}?appart={{ $appart->id }}"
                                                    class="badge bg-success">Échanciers</a> </td>
                                            <td>

                                                <button id="{{ $appart->id }}" class="btn btn-warning edit"
                                                    data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                        data-feather="edit"></i>Modifier</button>

                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                                <form id="delete" action="#">
                                    @csrf

                                </form>
                                <!--End Row-->


                                <div class="modal fade text-left " id="inlineFormEdit" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33">Modifier </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <form method="POST" id="formEdit" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <input type="hidden" name="id">
                                                    <label>Nom: </label>
                                                    <div class="form-group"> 
                                                        <input type="text" name="name" placeholder="Nom" id="nomAppart"
                                                            class="form-control">
                                                    </div>
                                                    <label>Résidence: </label>
                                                    <div class="form-group">
                                                        <select name="residence_id" class="form-control"
                                                            id="residencesEdit">
                                                            @foreach ($residences as $residence)
                                                                <option value="{{ $residence->id }}">
                                                                    {{ $residence->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label>Etages: </label>
                                                    <div class="form-group">
                                                        <select name="etage_id" id="editetage" class="form-control">

                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <main class="cd__main" style="display: none;">

                                                        </main>
                                                        <input type="hidden" name="x">
                                                        <input type="hidden" name="y">

                                                    </div>
                                                    <label>Surface: </label>
                                                    <div class="form-group">
                                                        <input type="number" name="surface" placeholder="Surface"
                                                            class="form-control">
                                                    </div>
                                                    <label>Type: </label>
                                                    <div class="form-group">
                                                        <select name="type" class="form-control">
                                                            <option value="0">Commerce</option>
                                                            <option value="1">Duplex</option>
                                                            <option value="2">Duplex - 1</option>
                                                            <option value="3">S+1</option>
                                                            <option value="4">S+2</option>
                                                            <option value="5">S+3</option>
                                                        </select>
                                                    </div>
                                                    <label>Prix: </label>
                                                    <div class="form-group">
                                                        <input type="number" name="price" placeholder="Prix"
                                                            class="form-control">
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

                                                    <label>Statut: </label>
                                                    <div class="form-group">
                                                        <select name="bs" class="form-control">
                                                            <option value= "0"> Libre </option>
                                                            <option value= "1"> Loué </option>
                                                            <option value= "2"> Réservé </option>
                                                            <option value= "3"> Vendu </option>
                                                        </select>
                                                    </div>
                                                    <label>Gallery </label>
                                                    <input type="file" name="gallery[]"
                                                        class="multiple-files-filepondEdit" multiple>
                                                    <label>Commentaires: </label>
                                                    <div class="form-group">
                                                        <textarea name="comments" cols="30" rows="10" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
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
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Echéanciers</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineEchance"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>

                                            <th scope="col">Client</th>
                                            <th scope="col">N° Téléphone</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Montant Avance</th>
                                            <th scope="col">Date Avance</th>
                                            <th scope="col">Preuve Avance</th>
                                            <th scope="col">Promesse</th>
                                            <th scope="col">Contrat</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appart->echance as $echance)
                                            <tr>

                                                <td>

                                                    @if ($echance->appart->client != null )
                                                        {{ $echance->appart->client->name }}
                                                        {{ $echance->appart->client->lastName }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>

                                                    @if ($echance->appart->client != null && $echance->appart->client->phone != null )
                                                        {{ $echance->appart->client->phone }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>{{ $echance->date }}</td>
                                                <td>{{ $echance->amount_avance }}</td>
                                                <td>{{ $echance->date_avance }}</td>
                                                <td>
                                                    <div
                                                        class="d-flex flex-column justify-items-center align-items-center ">
                                                        @if ($echance->preuve_avance != null)
                                                            <div>
                                                                <a href="/" class="btn btn-success">Télécharger</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="d-flex flex-column justify-items-center align-items-center ">
                                                        @if ($echance->promesse != null)
                                                            <div>
                                                                <a href="/" class="btn btn-success">Télécharger</a>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            @if ($echance->date_promesse_legal != null)
                                                                Légalisé: {{ $echance->date_promesse_legal }}
                                                            @endif
                                                        </div>
                                                        <div>
                                                            @if ($echance->date_promesse_livre != null)
                                                                Livré: {{ $echance->date_promesse_livre }}
                                                            @endif
                                                        </div>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div
                                                        class="d-flex flex-column justify-items-center align-items-center ">
                                                        @if ($echance->contrat != null)
                                                            <div>
                                                                <a href="/" class="btn btn-success">Télécharger</a>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            @if ($echance->date_contrat_enregistre != null)
                                                                Enregistré: {{ $echance->date_contrat_enregistre }}
                                                            @endif
                                                        </div>
                                                        <div>
                                                            @if ($echance->date_contrat_livre != null)
                                                                Livré: {{ $echance->date_contrat_livre }}
                                                            @endif
                                                        </div>

                                                    </div>
                                                </td>

                                                <td>

                                                    <div class="d-flex">
                                                        <a href="{{ route('echances.show', $echance->id) }}"
                                                            class="btn btn-primary m-1"><i
                                                                data-feather="plus-circle"></i>Details</a>

                                                        <button id="{{ $echance->id }}"
                                                            class="btn btn-warning editEchance m-1" data-bs-toggle="modal"
                                                            data-bs-target="#inlineEchanceEdit"><i
                                                                data-feather="edit"></i>Modifier</button>
                                                        <form method="GET"
                                                            action="{{ route('echances.destroy', $echance->id) }}">
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
                </div>

            </div>
            <!--End Row-->
            <div class="modal fade text-left " id="inlineEchance" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                </svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('echances.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">

                                <input type="hidden" name="appart_id" value="{{ $appart->id }}">
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Date" class="form-control">
                                </div>
                                <label>Avance: </label>
                                <div class="form-group">
                                    <input type="number" name="amount_avance" placeholder="Avance"
                                        class="form-control">
                                </div>
                                <label>Date de l'avance: </label>
                                <div class="form-group">
                                    <input type="date" name="date_avance" placeholder="Date" class="form-control">
                                </div>

                                <label>Preuve Avance: </label>
                                <input type="file" name="preuve_avance" class="image-preview-filepondAvance" />

                                <label>Promesse: </label>
                                <input type="file" name="promesse" class="image-preview-filepondPromesse" />
                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="livraison" class="form-check-input">
                                        <label>Date Livraison: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="livraisonDate" disabled name="date_promesse_livre"
                                        class="form-control">
                                </div>

                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="legal" class="form-check-input">
                                        <label>Date Légalisation: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="legalDate" disabled name="date_promesse_legal"
                                        class="form-control">
                                </div>

                                <label>Contrat: </label>
                                <input type="file" name="contrat" class="image-preview-filepondContrat" />
                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="livraisonPromesse" class="form-check-input">
                                        <label>Date Livraison: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="livraisonPromesseDate" disabled name="date_contrat_livre"
                                        class="form-control">
                                </div>

                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="enregistre" class="form-check-input">
                                        <label>Date Enregistrement: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="enregistreDate" disabled name="date_contrat_enregistre"
                                        class="form-control">
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
            <div class="modal fade text-left " id="inlineEchanceEdit" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel44" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
                        <form id="editForm" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="appart_id" value="{{ $appart->id }}">
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Numero" class="form-control">
                                </div>
                                <label>Avance: </label>
                                <div class="form-group">
                                    <input type="number" name="amount_avance" placeholder="Avance"
                                        class="form-control">
                                </div>
                                <label>Date de l'avance: </label>
                                <div class="form-group">
                                    <input type="date" name="date_avance" placeholder="Numero" class="form-control">
                                </div>

                                <label>Preuve Avance: </label>
                                <input type="file" name="preuve_avance" class="image-preview-filepondAvanceEdit" />

                                <label>Promesse: </label>
                                <input type="file" name="promesse" class="image-preview-filepondPromesseEdit" />
                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="livraisonEdit" class="form-check-input">
                                        <label>Date Livraison: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="livraisonDateEdit" disabled name="date_promesse_livre"
                                        class="form-control">
                                </div>

                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="legalEdit" class="form-check-input">
                                        <label>Date Légalisation: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="legalDateEdit" disabled name="date_promesse_legal"
                                        class="form-control">
                                </div>

                                <label>Contrat: </label>
                                <input type="file" name="contrat" class="image-preview-filepondContratEdit" />
                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="livraisonPromesseEdit" class="form-check-input">
                                        <label>Date Livraison: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="livraisonPromesseDateEdit" disabled
                                        name="date_contrat_livre" class="form-control">
                                </div>

                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="enregistreEdit" class="form-check-input">
                                        <label>Date Enregistrement: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="enregistreDateEdit" disabled name="date_contrat_enregistre"
                                        class="form-control">
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
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Charges</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineCharge"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>

                                            <th scope="col">Client</th>
                                            <th scope="col">Sonède & Gaz</th>
                                            <th scope="col">Syndic</th>
                                            <th scope="col">Avocat - Promesse</th>
                                            <th scope="col">Avocat - Contrat</th>
                                            <th scope="col">Titre Foncier</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appart->charge as $charge)
                                            <tr>

                                                <td>
                                                    @if ($charge->appart->client)
                                                        {{ $charge->appart->client->name }}
                                                        {{ $charge->appart->client->lastName }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>{{ $charge->sonede }}</td>
                                                <td>{{ $charge->syndic }}</td>
                                                <td>{{ $charge->avocat }}</td>
                                                <td>{{ $charge->contrat }}</td>
                                                <td>{{ $charge->foncier }}</td>
                                                <td>

                                                    <div class="d-flex">
                                                        <button id="{{ $charge->id }}"
                                                            class="btn btn-warning editCharge m-1" data-bs-toggle="modal"
                                                            data-bs-target="#inlineChargeEdit"><i
                                                                data-feather="edit"></i>Modifier</button>
                                                        <form method="GET"
                                                            action="{{ route('charges.destroy', $charge->id) }}">
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
                </div>

            </div>
            <!--End Row-->
            <div class="modal fade text-left " id="inlineCharge" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                </svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('charges.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="appart_id" value="{{ $appart->id }}">
                                <label id="clientAdd"></label>

                                <label>Sonède & Gaz: </label>
                                <div class="form-group">
                                    <input name="sonede" type="number" placeholder="Sonède & Gaz"
                                        class="form-control">
                                </div>

                                <label>Syndic: </label>
                                <div class="form-group">
                                    <input name="syndic" type="number" placeholder="Syndic" class="form-control">
                                </div>

                                <label>Avocat Promesse: </label>
                                <div class="form-group">
                                    <input name="avocat" type="number" placeholder="Avocat Promesse"
                                        class="form-control">
                                </div>

                                <label>Avocat Contart: </label>
                                <div class="form-group">
                                    <input name="contrat" type="number" placeholder="Avocat Contart"
                                        class="form-control">
                                </div>

                                <label>Titre Foncier: </label>
                                <div class="form-group">
                                    <input name="foncier" type="number" placeholder="Titre Foncier"
                                        class="form-control">
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
            <div class="modal fade text-left " id="inlineChargeEdit" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel44" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
                        <form id="editChargeForm" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="appart_id" value="{{ $appart->id }}">

                                <label id="clientEdit"></label>
                                <label>Sonède & Gaz: </label>
                                <div class="form-group">
                                    <input name="sonede" type="number" placeholder="Sonède & Gaz"
                                        class="form-control">
                                </div>

                                <label>Syndic: </label>
                                <div class="form-group">
                                    <input name="syndic" type="number" placeholder="Syndic" class="form-control">
                                </div>

                                <label>Avocat Promesse: </label>
                                <div class="form-group">
                                    <input name="avocat" type="number" placeholder="Avocat Promesse"
                                        class="form-control">
                                </div>

                                <label>Avocat Contart: </label>
                                <div class="form-group">
                                    <input name="contrat" type="number" placeholder="Avocat Contart"
                                        class="form-control">
                                </div>

                                <label>Titre Foncier: </label>
                                <div class="form-group">
                                    <input name="foncier" type="number" placeholder="Titre Foncier"
                                        class="form-control">
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
        const selectEtagesEdit = document.getElementById('residencesEdit')
        const etagesSelectEdit = document.getElementById('editetage')

        let nameAppart = "";
        const inputNom = document.getElementById('nomAppart');
        inputNom.addEventListener('change', (e)=>{
            nameAppart = e.target.value;
        } )


        selectEtagesEdit.addEventListener('change', (e) => {
            const id = e.target.value

            loadEtages(id, 'editetage')
        })

        etagesSelectEdit.addEventListener('change', (e) => {
            const id = e.target.value
            const appart = document.getElementById('formEdit').querySelector('input[name="id"]')?.value
            loadImageEdit(id, appart)
        })

        FilePond.create(document.querySelector(".multiple-files-filepond"), {
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
            labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
        });

        function loadEtages(id, etageId) {
            const selectEtage = document.getElementById(etageId)
            selectEtage.innerHTML = ''
            const data = @json($residences);
            data.forEach(residence => {
                if (residence.id == id) {
                    residence.etage.forEach(e => {
                        const option = document.createElement('option')
                        option.value = e.id
                        option.innerHTML = e.name
                        selectEtage.appendChild(option)
                    })
                }
            })
        }



        function deleteClient(id) {
            var form = document.getElementById('delete');
            let base = '{{ route('apparts.destroy', '5') }}';
            base = base.replace('5', id);
            form.action = base;
            form.method = 'DELETE';
            form.submit();
        }

        function loadImageEdit(id, appart_id) {
            const main = document.querySelector('.cd__main');
            const etages = @json($etages);

            const w = 458;
            etages.forEach((etage) => {
                if (etage.id == id) {
                    if (etage.hplan != 'undefined' && etage.wplan != 'undefined') {
                        main.style.display = 'block'
                        main.innerHTML = ''
                        const imageUrl = "../../" + etage.plan;
                        const ratio = etage.wplan / etage.hplan;

                        main.setAttribute('style', 'height: ' + w / ratio +
                            'px; width: ' + w + 'px;');


                        const div = document.createElement('div');
                        div.classList.add('containerH');
                        const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
                        div.setAttribute('style', "background-image: url('" + path + "'); height: " + w / ratio +
                            "px; width: " + w + "px;");

                        etage.appart.forEach((ap) => {
                            const appart = document.createElement('div');
                            appart.classList.add('hotspot');
                            const divText = document.createElement('div');
                            let t = ap.y - 10;
                            let l = ap.x - 10;
                            t += 10;
                            l += 14;
                            divText.setAttribute('style', 'top: ' + t + '%; left: ' + l +
                                '%; ');
                            divText.innerHTML = '<div>' + ap.name + '</div>';
                            divText.classList.add('hotspot-label');
                            if (ap.id == appart_id) {
                                appart.classList.add('added');
                                divText.classList.add('added');
                            }

                            appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
                            appart.innerHTML = '<div class="icon">+</div><div class="content"><h4>' + ap
                                .name +
                                '</h4><p>' + ap.comments + '</p><a class="btn">Voir</a></div>';
                            
                            div.appendChild(divText);
                            div.appendChild(appart);
                        })
                        main.appendChild(div);
                    }
                }
            });
        }

        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        editButtons.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEdit');

                let base = '{{ route('apparts.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const idInput = form.querySelector('input[name="id"]')
                const nameInput = form.querySelector('input[name="name"]')
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const etage_idInput = form.querySelector('select[name="etage_id"]')
                const surfaceInput = form.querySelector('input[name="surface"]')
                const typeInput = form.querySelector('select[name="type"]')
                const priceInput = form.querySelector('input[name="price"]')
                const xInput = form.querySelector('input[name="x"]')
                const yInput = form.querySelector('input[name="y"]')
                const client_idInput = form.querySelector('select[name="client_id"]')
                const bsInput = form.querySelector('select[name="bs"]')
                const commentsInput = form.querySelector('textarea[name="comments"]')

                url = "{{ route('apparts.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;
                    const data = @json($residences);

                    data.forEach(residence => {
                        residence.etage.forEach(e => {
                            if (e.id == appart.etage_id) {
                                residence_idInput.value = residence.id
                                loadEtages(residence.id, 'editetage')
                                etage_idInput.value = e.id;
                                loadImageEdit(e.id, appart.id)
                            }
                        })
                    })
                    idInput.value = appart.id
                    nameInput.value = appart.name
                    nameAppart = appart.name;
                    surfaceInput.value = appart.surface
                    typeInput.value = appart.type
                    priceInput.value = appart.price
                    client_idInput.value = appart.client_id
                    bsInput.value = appart.bs
                    commentsInput.value = appart.comments
                    xInput.value = appart.x
                    yInput.value = appart.y

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
                        labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
                    }
                    if (appart.image) {
                        const files = []
                        appart.image.forEach((img) => {

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
        })
    </script>
    <script>
        function createFileInput(className) {
            const options = {
                credits: null,
                allowImagePreview: false,
                allowMultiple: false,
                allowFileEncode: false,
                required: false,
                storeAsFile: true,
                labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
            }
            FilePond.create(document.querySelector(className), options);
        }
        createFileInput(".image-preview-filepondAvance");
        createFileInput(".image-preview-filepondPromesse");
        createFileInput(".image-preview-filepondContrat");

        function createFileInputEdit(className, image) {
            const options = {
                credits: null,
                allowImagePreview: false,
                allowMultiple: false,
                allowFileEncode: false,
                required: false,
                storeAsFile: true,
                labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
            }
            if (image != null) {
                options.files = [{
                    source: '{{ route('dashboard') }}/' + image,
                }]
            }
            FilePond.create(document.querySelector(className), options);
        }


        const editEchance = document.getElementsByClassName('editEchance');
        editEchance.forEach = Array.prototype.forEach;
        editEchance.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('editForm');

                let base = '{{ route('echances.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const etage_idInput = form.querySelector('select[name="etage_id"]')
                const appart_idInput = form.querySelector('select[name="appart_id"]')
                const amount_avanceInput = form.querySelector('input[ name="amount_avance"]')
                const dateInput = form.querySelector('input[ name="date"]')
                const date_avanceInput = form.querySelector('input[ name="date_avance"]')
                const date_promesse_livre = form.querySelector('input[name="date_promesse_livre"]');
                const date_promesse_legal = form.querySelector('input[name="date_promesse_legal"]');
                const date_contrat_livre = form.querySelector('input[name="date_contrat_livre"]');
                const date_contrat_enregistre = form.querySelector('input[name="date_contrat_enregistre"]');
                const livraisonDateEdit = form.querySelector("input[id=livraisonEdit]")
                const legalDateEdit = form.querySelector("input[id=legalEdit]")
                const livraisonPromesseDateEdit = form.querySelector("input[id=livraisonPromesseEdit]")
                const enregistreDateEdit = form.querySelector("input[id=enregistreEdit]")

                url = "{{ route('echances.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const client = reponse.data;

                    dateInput.value = client.date;
                    date_avanceInput.value = client.date_avance;
                    amount_avanceInput.value = client.amount_avance;
                    if (client.date_promesse_livre) {
                        livraisonDateEdit.checked = true;
                        date_promesse_livre.disabled = false;
                    } else {
                        date_promesse_livre.disabled = true
                        livraisonDateEdit.checked = false;
                    }
                    date_promesse_livre.value = client.date_promesse_livre
                    if (client.date_promesse_legal) {
                        legalDateEdit.checked = true;
                        date_promesse_legal.disabled = false;
                    } else {
                        date_promesse_legal.disabled = true
                        legalDateEdit.checked = false;
                    }
                    date_promesse_legal.value = client.date_promesse_legal
                    if (client.date_contrat_livre) {
                        livraisonPromesseDateEdit.checked = true;
                        date_contrat_livre.disabled = false;
                    } else {
                        date_contrat_livre.disabled = true
                        livraisonPromesseDateEdit.checked = false;
                    }
                    date_contrat_livre.value = client.date_contrat_livre
                    if (client.date_contrat_enregistre) {
                        enregistreDateEdit.checked = true;
                        date_contrat_enregistre.disabled = false;
                    } else {
                        date_contrat_enregistre.disabled = true
                        enregistreDateEdit.checked = false;
                    }
                    date_contrat_enregistre.value = client.date_contrat_enregistre
                    createFileInputEdit(".image-preview-filepondAvanceEdit", client.preuve_avance);
                    createFileInputEdit(".image-preview-filepondPromesseEdit", client.promesse);
                    createFileInputEdit(".image-preview-filepondContratEdit", client.contrat);
                }).catch((error) => {
                    console.log(error)
                })
            });
        })

        const livraison = document.getElementById("livraison");
        const legal = document.getElementById("legal");
        const livraisonPromesse = document.getElementById("livraisonPromesse");
        const enregistre = document.getElementById("enregistre");

        livraison.addEventListener('click', function() {
            const livraisonDate = document.getElementById("livraisonDate");
            if (livraison.checked) {
                livraisonDate.disabled = false;
            } else {
                livraisonDate.disabled = true;
            }
        })
        legal.addEventListener('click', function() {
            const legalDate = document.getElementById("legalDate");
            if (legal.checked) {
                legalDate.disabled = false;
            } else {
                legalDate.disabled = true;
            }
        })
        livraisonPromesse.addEventListener('click', function() {
            const livraisonPromesseDate = document.getElementById("livraisonPromesseDate");
            if (livraisonPromesse.checked) {
                livraisonPromesseDate.disabled = false;
            } else {
                livraisonPromesseDate.disabled = true;
            }
        })
        enregistre.addEventListener('click', function() {
            const enregistreDate = document.getElementById("enregistreDate");
            if (enregistre.checked) {
                enregistreDate.disabled = false;
            } else {
                enregistreDate.disabled = true;
            }
        })

        const livraisonEdit = document.getElementById("livraisonEdit");
        const legalEdit = document.getElementById("legalEdit");
        const livraisonPromesseEdit = document.getElementById("livraisonPromesseEdit");
        const enregistreEdit = document.getElementById("enregistreEdit");

        livraisonEdit.addEventListener('click', function() {
            const livraisonDate = document.getElementById("livraisonDateEdit");
            if (livraisonEdit.checked) {
                livraisonDate.disabled = false;
            } else {
                livraisonDate.disabled = true;
            }
        })
        legalEdit.addEventListener('click', function() {
            const legalDate = document.getElementById("legalDateEdit");
            if (legalEdit.checked) {
                legalDate.disabled = false;
            } else {
                legalDate.disabled = true;
            }
        })
        livraisonPromesseEdit.addEventListener('click', function() {
            const livraisonPromesseDate = document.getElementById("livraisonPromesseDateEdit");
            if (livraisonPromesseEdit.checked) {
                livraisonPromesseDate.disabled = false;
            } else {
                livraisonPromesseDate.disabled = true;
            }
        })
        enregistreEdit.addEventListener('click', function() {
            const enregistreDate = document.getElementById("enregistreDateEdit");
            if (enregistreEdit.checked) {
                enregistreDate.disabled = false;
            } else {
                enregistreDate.disabled = true;
            }
        })

        const editCharge = document.getElementsByClassName('editCharge');
        editCharge.forEach = Array.prototype.forEach;
        editCharge.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const formm = document.getElementById('editChargeForm');
                let base = '{{ route('echances.update', '5') }}';
                base = base.replace('5', editButton.id);
                formm.action = base;

                const sonedeInput = formm.querySelector('input[name="sonede"]');
                const syndicInput = formm.querySelector('input[name="syndic"]');
                const avocatInput = formm.querySelector('input[name="avocat"]');
                const contratInput = formm.querySelector('input[name="contrat"]');
                const foncierInput = formm.querySelector('input[name="foncier"]');
                url = "{{ route('charges.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const client = reponse.data;
                    sonedeInput.value = client.sonede;
                    syndicInput.value = client.syndic;
                    avocatInput.value = client.avocat;
                    contratInput.value = client.contrat;
                    foncierInput.value = client.foncier;
                }).catch((error) => {
                    console.log(error)
                })
            });
        })
        $(document).on("click", ".containerH", function(e) {
            const container = $(this); // Get the clicked container element

            const containerRect = container[0].getBoundingClientRect();

            const offsetXPercent =
                ((e.clientX - containerRect.left) / containerRect.width) * 100;
            const offsetYPercent =
                ((e.clientY - containerRect.top) / containerRect.height) * 100;



            $('.added').each((index, el) => {
                $(el).remove(); // Remove each element with the class .added
            });
            let t = offsetYPercent - 10;
            let l = offsetXPercent - 10;
            t += 9;
            l += 14;

            const newElement = $(
                `
                <div class='hotspot-label added' style='top: ${t}%; left: ${l}%;'>
                    <div>${nameAppart}</div>
                    </div><div class='hotspot added' style='top: ${offsetYPercent-1}%; left: ${offsetXPercent-1}%;'>
      <div class='icon'>+</div>
      <div class='content'>
        <h4>Eros uns eos sind rebum</h4>
        <p>Clita sanctus eirmod eros aliquip. Clita Lorem dolores diam</p>
        <a class='btn'>
          velit dolor
        </a>
      </div>
    </div>`
            );
            document.getElementById("formEdit").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formEdit").querySelector("input[name='y']").value = offsetYPercent;


            container.append(newElement);
        });
    </script>


@endsection
