@extends('welcome')
@section('title', 'Etages')
@section('styles')
    <link href="{{ asset('dist/css/hotspot/hotspot.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/hotspot/style.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12">

                    <div class="d-flex justify-content-between flex-wrap">
                        <h5 class="card-title">Résidence: {{ $etage->building->name }}</h5>
                        <h5 class="card-title">Étage: {{ $etage->name }}</h5>
                        <h5 class="card-title">Nombre de biens immobiliers: {{ $etage->appart->count() }}</h5>
                    </div>
                    <h5 class="card-title">Plan:</h5>
                    <div class="pb-5">
                        <main class="main_plan" style="display: block;">

                        </main>
                    </div>
                    <div class="p-1">
                        @if (Auth::user()->role == 1)
                            <button id="{{ $etage->id }}" class="btn btn-warning editEt" data-bs-toggle="modal"
                                data-bs-target="#inlineEtageEdit"><i data-feather="edit"></i>Modifier</button>
                        @endif
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Biens Immobiliers</h5>
                                @if (Auth::user()->role == 1)
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                        class="btn btn-primary" id="addAppart">Ajouter</button>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col" id="appartOrder">Bien Immobilier</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Etage</th>
                                            <th scope="col">Résidence</th>
                                            <th scope="col">Surface</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Prix</th>
                                            <th scope="col">Statut</th>
                                            <th scope="col">Commentaire</th>
                                            <th scope="col" class="noExport">Charges</th>
                                            <th scope="col" class="noExport">Échanciers</th>

                                            <th scope="col" class="noExport">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($etage->appart as $appart)
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
                                                    @if ($appart->type == 0)
                                                        Commerce
                                                    @endif
                                                    @if ($appart->type == 1)
                                                        Duplex
                                                    @endif
                                                    @if ($appart->type == 2)
                                                        Duplex - 1
                                                    @endif
                                                    @if ($appart->type == 3)
                                                        S+1
                                                    @endif
                                                    @if ($appart->type == 4)
                                                        S+2
                                                    @endif
                                                    @if ($appart->type == 5)
                                                        S+3
                                                    @endif
                                                </td>
                                                <td>{{ number_format(floatval($appart->price), 3, '.', ' ') }}</td>
                                                <td>
                                                    @if ($appart->bs == 0)
                                                        A vendre
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
                                                    <a href="{{ route('apparts.show', $appart->id) }}"
                                                        class="btn btn-primary"><i
                                                            data-feather="plus-circle"></i>Details</a>
                                                    @if (Auth::user()->role == 1)
                                                        <button id="{{ $appart->id }}" class="btn btn-warning edit"
                                                            data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                                data-feather="edit"></i>Modifier</button>


                                                        <form method="GET"
                                                            action="{{ route('apparts.destroy', $appart->id) }}">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger m-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#inlineChargeDelete{{ $appart->id }}"><i
                                                                    data-feather="trash"></i>Supprimer</button>
                                                            <div class="modal fade"
                                                                id="inlineChargeDelete{{ $appart->id }}" tabindex="-1"
                                                                role="dialog" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                                Confirmation</h5>
                                                                            <button type="button" class="close"
                                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Êtes-vous sûr de vouloir supprimer ?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Annuler</button>
                                                                            <button id="deleteButton" type="submit"
                                                                                class="btn btn-danger">Confirmer</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <form id="delete" action="#">
                                    @csrf

                                </form>
                                <!--End Row-->

                                <div class="modal fade text-left " id="inlineForm" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('apparts.store') }}" id="formmm"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Nom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="Nom"
                                                            id="nomAppart" class="form-control">
                                                    </div>

                                                    <label>Résidence: </label>
                                                    <div class="form-group">
                                                        <select name="residence_id" class="form-control"
                                                            id="residencesAdd">
                                                            @foreach ($residences as $residence)
                                                                <option value="{{ $residence->id }}">
                                                                    {{ $residence->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label>Etages: </label>
                                                    <div class="form-group">
                                                        <select name="etage_id" id="addetage" class="form-control">

                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <main class="cd__main addImage" style="display: none;">

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
                                                            step="0.001" class="form-control">
                                                    </div>
                                                    <label>Client: </label>
                                                    <div class="form-group">
                                                        <select name="client_id" class="form-control">
                                                            <option value="">--</option>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ $client->id }}">
                                                                    {{ $client->name }} {{ $client->lastName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <label>Statut: </label>
                                                    <div class="form-group">
                                                        <select name="bs" class="form-control">
                                                            <option value= "0"> A vendre </option>
                                                            <option value= "1"> Loué </option>
                                                            <option value= "2"> Réservé </option>
                                                            <option value= "3"> Vendu </option>
                                                        </select>
                                                    </div>
                                                    <label>Gallery </label>
                                                    <input type="file" name="gallery[]"
                                                        class="multiple-files-filepond" multiple>
                                                    <label>Commentaires: </label>
                                                    <div class="form-group">
                                                        <textarea name="comments" cols="30" rows="10" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        
                                                        <span class="d-block">Annuler</span>
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
                                    aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
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
                                                    <input type="hidden" name="etage_id" value="{{ $etage->id }}">
                                                    <label>Nom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="Nom"
                                                            id="nomAppartEdit" class="form-control">
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
                                                    <input type="hidden" name="id" class="form-control">
                                                    <div class="form-group">
                                                        <main class="EditImg" style="display: none;">

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
                                                            class="form-control" step="0.001">
                                                    </div>
                                                    <label>Client: </label>
                                                    <div class="form-group">
                                                        <select name="client_id" class="form-control">
                                                            <option value="">--</option>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ $client->id }}">
                                                                    {{ $client->name }} {{ $client->lastName }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <label>Statut: </label>
                                                    <div class="form-group">
                                                        <select name="bs" class="form-control">
                                                            <option value="0"> A vendre </option>
                                                            <option value="1"> Loué </option>
                                                            <option value="2"> Réservé </option>
                                                            <option value="3"> Vendu </option>
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade text-left " id="inlineEtageEdit" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel44" aria-hidden="true">
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
                            <form id="formEtage" method="POST" enctype="multipart/form-data">

                                @csrf
                                <div class="modal-body">
                                    <label>Residence: </label>
                                    <div class="form-group">
                                        <select name="residence_id" class="form-control">
                                            @foreach ($residences as $residence)
                                                <option value="{{ $residence->id }}">
                                                    {{ $residence->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
                                    <button type="button" class="btn btn-light-secondary close" data-bs-dismiss="modal"
                                        label="Close">
                                        
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



            </div>
            <!--End Row-->
            <div class="modal fade" id="imageCarouselModal" tabindex="-1" role="dialog"
                aria-labelledby="imageCarouselModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageCarouselModalLabel">Gallerie</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                                </svg>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="imageCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" id="galleryCarrousel">
                                    <!-- Add your images here -->

                                    <!-- Add more items as needed -->
                                </div>
                                <a class="carousel-control-prev" href="#imageCarousel" id="carouselPrev" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only text-color-black">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#imageCarousel" id="carouselNext" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only text-color-black">Next</span>
                                </a>
                            </div>
                        </div>
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
        const etageData = @json($etage);
        const selectEtages = document.getElementById('residencesAdd')
        const selectEtagesEdit = document.getElementById('residencesEdit')
        const addSelect = document.getElementById('addetage')
        const etagesSelectEdit = document.getElementById('editetage')
        selectEtages.value = etageData.residence_id;
        loadEtages(selectEtages.value, 'addetage');


        selectEtages.addEventListener('change', (e) => {
            const id = e.target.value

            loadEtages(id, 'addetage')
        })

        selectEtagesEdit.addEventListener('change', (e) => {
            const id = e.target.value

            loadEtages(id, 'editetage')
        })
        addSelect.addEventListener('change', (e) => {
            const id = e.target.value
            loadImageEdit(id, null, '.addImage')
        })
        etagesSelectEdit.addEventListener('change', (e) => {
            const id = e.target.value
            const appart = document.getElementById('formEdit').querySelector('input[name="id"]')?.value
            loadImageEdit(id, appart, '.EditImg')
        })

        function loadEtages(id, etageId) {
            const selectEtage = document.getElementById(etageId)
            selectEtage.innerHTML = ''
            const data = @json($residences);
            data.forEach(residence => {
                if (residence.id == id) {
                    // sort etages by name 
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

        function loadImageEdit(id, appart_id, mainId) {
            const main = document.querySelector(mainId);
            axios.get("{{ route('etages.get', 5) }}".replace(5, id)).then(res => {
                const etage = res.data;
                const w = 900;


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
                        const divText = document.createElement('div');
                        let t = ap.y - 10;
                        let l = ap.x - 10;
                        t += 10;
                        l += 12;
                        divText.setAttribute('style', 'top: ' + t + '%; left: ' + l +
                            '%;  ');
                        divText.innerHTML = '<div>' + ap.name + '</div>';
                        divText.classList.add('hotspot-label');

                        appart.classList.add('hotspot');
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
                };
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

        let nameAppart = "";
        const inputNom = document.getElementById('nomAppart');
        inputNom.addEventListener('change', (e) => {
            nameAppart = e.target.value;
        })
        const inputNomEdit = document.getElementById('nomAppartEdit');
        inputNomEdit.addEventListener('change', (e) => {
            nameAppart = e.target.value;
        })
        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const form = document.getElementById('formEdit');
                const editButton = target;
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
                const client_idInput = form.querySelector('select[name="client_id"]')
                const bsInput = form.querySelector('select[name="bs"]')
                const xInput = form.querySelector('input[name="x"]')
                const yInput = form.querySelector('input[name="y"]')
                const commentsInput = form.querySelector('textarea[name="comments"]')

                url = "{{ route('apparts.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;
                    idInput.value = appart.id
                    residence_idInput.value = appart.etage.residence_id
                    loadEtages(residence_idInput.value, 'editetage')
                    loadImageOnEdit(appart.id)
                    etage_idInput.value = appart.etage_id
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
            };
        })
        const editButtonEt = document.getElementsByClassName('editEt');
        editButtonEt.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('editEt')) {
                const form = document.getElementById('formEtage');
                const editButton = target;
                let base = '{{ route('etages.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const resInput = form.querySelector('select[name="residence_id"]');
                const numberInput = form.querySelector('select[name="name"]');

                url = "{{ route('etages.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const etage = reponse.data;
                    resInput.value = etage.residence_id
                    numberInput.value = etage.name;
                    const options = {
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
                    }
                    if (etage.plan) {
                        options.files = [{
                            source: '{{ route('dashboard') }}/' + etage.plan
                        }]
                    }
                    FilePond.create(document.querySelector('.image-preview-filepondEtage'),
                        options);
                }).catch((error) => {
                    console.log(error)
                })
            };
        })

        const main = document.querySelector('.main_plan');
        const etage = @json($etage);
        const ratio = etage.wplan / etage.hplan
        main.style.width = '1000px';
        main.style.height = (1000 / ratio) + 'px';
        const div = document.createElement('div');
        div.classList.add('containerD');
        const wid = 1000;
        const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
        div.setAttribute('style', "background-image: url('" + path + "'); height: " + wid / ratio +
            "px; width: " + wid + "px;");
        etage.appart.forEach((ap) => {
            const appart = document.createElement('div');
            appart.classList.add('hotspot');

            appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
            let statut = "";
            let color = "";
            switch (ap.bs) {
                case 0:
                    statut = "A vendre";
                    color = "#005841";
                    break;
                case 1:
                    statut = "Loué";
                    color = "#fe8900";
                    break;
                case 2:
                    statut = "Réservé";
                    color = "#fde25e";
                    break;
                case 3:
                    statut = "Vendu";
                    color = "#850000";
                    break;
            }
            const link = "{{ route('apparts.show', 5) }}".replace('5', ap.id);
            const ht = document.createElement('div');
            ht.classList.add('icon');
            ht.classList.add('hotspot');
            ht.setAttribute('style', 'background-color: ' + color + ';');
            ht.innerHTML = "+";
            ht.addEventListener('click', function() {
                axios.get("{{ route('apparts.get', 5) }}".replace(5, ap.id)).then(res => {

                    const galleryImages = res.data.image;
                    const gallery = document.getElementById('galleryCarrousel');
                    gallery.innerHTML = '';

                    galleryImages.forEach((img) => {
                        const div = document.createElement('div');
                        div.classList.add('carousel-item');
                        if (img == galleryImages[0]) {
                            div.classList.add('active');
                        }
                        div.innerHTML = '<img src="{{ route('dashboard') }}/' + img.path +
                            '" class="d-block w-100" alt="...">';
                        gallery.appendChild(div);
                    })
                    $('#imageCarouselModal').modal('show');
                    var carousel = new bootstrap.Carousel(document.getElementById(
                        'imageCarousel'), {
                        interval: false // Disable automatic sliding
                    });
                    document.getElementById('carouselPrev').addEventListener('click', function() {
                        carousel.prev();
                    });

                    // Next button click event
                    document.getElementById('carouselNext').addEventListener('click', function() {
                        carousel.next();
                    });
                })
            });
            const content = document.createElement('div');
            content.classList.add('content');
            content.setAttribute('style', 'background-color: ' + color + ';');
            content.innerHTML = '<h4>' + ap.name + '</h4><p>' + statut + '</p><a href="' + link +
                '" class="btn">Voir</a>';

            const divText = document.createElement('div');
            let t = ap.y - 10;
            let l = ap.x - 10;
            t += 10;
            l += 12;
            divText.setAttribute('style', 'top: ' + t + '%; left: ' + l + '%; background-color: ' + color + '; ');
            divText.innerHTML = '<div>' + ap.name + '</div>';
            divText.classList.add('hotspot-label');
            div.appendChild(divText);
            appart.appendChild(ht);
            appart.appendChild(content);
            div.appendChild(appart);
        })

        // create a container having the color codes an explanations
        const container = document.createElement('div');
        container.classList.add('container');
        container.classList.add('d-flex');
        container.classList.add('justify-content-between');
        const textLibre = document.createElement('div');
        textLibre.innerHTML = "A vendre";
        const labelLibre = document.createElement('div');
        labelLibre.classList.add('icon');
        labelLibre.classList.add('d-flex');
        labelLibre.classList.add('justify-content-center');
        labelLibre.classList.add('align-items-center');
        labelLibre.classList.add('mx-2');
        labelLibre.setAttribute('style',
            'background-color: #005841; border-radius: 50% 50%; color: white;width: 30px; height: 30px; overflow: hidden;'
        );
        labelLibre.innerHTML = "+";
        const divLibre = document.createElement('div');
        divLibre.classList.add('d-flex');
        divLibre.classList.add('justify-content-center');
        divLibre.classList.add('align-items-center');
        divLibre.appendChild(labelLibre)
        divLibre.appendChild(textLibre)
        const textLoué = document.createElement('div');
        textLoué.innerHTML = "Loué";
        const labelLoué = document.createElement('div');
        labelLoué.classList.add('icon');
        labelLoué.classList.add('d-flex');
        labelLoué.classList.add('justify-content-center');
        labelLoué.classList.add('align-items-center');
        labelLoué.classList.add('mx-2');
        labelLoué.setAttribute('style',
            'background-color: #fe8900; border-radius: 50% 50%; color: white;width: 30px; height: 30px; overflow: hidden;'
        );
        labelLoué.innerHTML = "+";
        const divLoué = document.createElement('div');
        divLoué.classList.add('d-flex');
        divLoué.classList.add('justify-content-center');
        divLoué.classList.add('align-items-center');
        divLoué.appendChild(labelLoué)
        divLoué.appendChild(textLoué)
        const textRéservé = document.createElement('div');
        textRéservé.innerHTML = "Réservé";
        const labelRéservé = document.createElement('div');
        labelRéservé.classList.add('icon');
        labelRéservé.classList.add('d-flex');
        labelRéservé.classList.add('justify-content-center');
        labelRéservé.classList.add('align-items-center');
        labelRéservé.classList.add('mx-2');
        labelRéservé.setAttribute('style',
            'background-color: #fde25e; border-radius: 50% 50%; color: white;width: 30px; height: 30px; overflow: hidden;'
        );
        labelRéservé.innerHTML = "+";
        const divRéservé = document.createElement('div');
        divRéservé.classList.add('d-flex');
        divRéservé.classList.add('justify-content-center');
        divRéservé.classList.add('align-items-center');
        divRéservé.appendChild(labelRéservé)
        divRéservé.appendChild(textRéservé)
        const textVendu = document.createElement('div');
        textVendu.innerHTML = "Vendu";
        const labelVendu = document.createElement('div');
        labelVendu.classList.add('icon');
        labelVendu.classList.add('d-flex');
        labelVendu.classList.add('justify-content-center');
        labelVendu.classList.add('align-items-center');
        labelVendu.classList.add('mx-2');
        labelVendu.setAttribute('style',
            'background-color: #850000; border-radius: 50% 50%; color: white;width: 30px; height: 30px; overflow: hidden;'
        );
        labelVendu.innerHTML = "+";
        const divVendu = document.createElement('div');
        divVendu.classList.add('d-flex');
        divVendu.classList.add('justify-content-center');
        divVendu.classList.add('align-items-center');
        divVendu.appendChild(labelVendu)
        divVendu.appendChild(textVendu)
        container.appendChild(divLibre)
        container.appendChild(divLoué)
        container.appendChild(divRéservé)
        container.appendChild(divVendu)
        container.classList.add('mt-2');


        main.appendChild(div);
        main.appendChild(container);
    </script>
    <script>
        function loadImage(id) {
            const main = document.querySelector('.cd__main');


            const wid = 900;

            if (etage.hplan != 'undefined' && etage.wplan != 'undefined') {
                main.style.display = 'block'
                main.innerHTML = ''
                const imageUrl = "../../" + etage.plan;
                const div = document.createElement('div');
                const ratio = etage.wplan / etage.hplan;

                main.setAttribute('style', 'height: ' + wid / ratio +
                    'px; width: ' + wid + 'px;');


                div.classList.add('containerH');

                const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
                div.setAttribute('style', 'background-image: url("' + path + '"); height: ' + wid / ratio + 'px; width: ' +
                    wid + 'px;');

                etage.appart.forEach((ap) => {
                    const appart = document.createElement('div');
                    appart.classList.add('hotspot');

                    appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
                    appart.innerHTML = '<div class="icon">+</div><div class="content"><h4>' + ap.name +
                        '</h4><p>' + ap.comments + '</p><a class="btn">Voir</a></div>';
                    const divText = document.createElement('div');
                    let t = ap.y - 10;
                    let l = ap.x - 10;
                    t += 10;
                    l += 14;
                    divText.setAttribute('style', 'top: ' + t + '%; left: ' + l + '%; ');
                    divText.innerHTML = '<div>' + ap.name + '</div>';
                    divText.classList.add('hotspot-label');
                    div.appendChild(divText);
                    div.appendChild(appart);
                })
                main.appendChild(div);
            };
        }
        loadImage();

        function loadImageOnEdit(appart_id) {
            const main = document.querySelector('.EditImg ');



            if (etage.hplan != 'undefined' && etage.wplan != 'undefined') {
                main.style.display = 'block'
                main.innerHTML = ''
                const imageUrl = "../../" + etage.plan;
                const div = document.createElement('div');
                const ratio = etage.wplan / etage.hplan;

                main.setAttribute('style', 'height: ' + wid / ratio + 'px; width: ' + wid + 'px;');


                div.classList.add('addedContainer');
                div.classList.add('containerH');


                const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
                div.setAttribute('style', "background-image: url('" + path + "'); height: " + wid / ratio +
                    "px; width: " + wid + "px;");

                etage.appart.forEach((ap) => {
                    const appart = document.createElement('div');
                    appart.classList.add('hotspot');
                    const divText = document.createElement('div');
                    let t = ap.y - 10;
                    let l = ap.x - 10;
                    t += 10;
                    l += 14;
                    divText.setAttribute('style', 'top: ' + t + '%; left: ' + l + '%;  ');
                    divText.innerHTML = '<div>' + ap.name + '</div>';
                    divText.classList.add('hotspot-label');
                    if (ap.id == appart_id) {
                        appart.classList.add('added');
                        divText.classList.add('added');
                    }
                    appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
                    appart.innerHTML = '<div class="icon">+</div><div class="content"><h4>' + ap.name +
                        '</h4><p>' + ap.comments + '</p><a class="btn">Voir</a></div>';

                    div.appendChild(divText);
                    div.appendChild(appart);

                })
                main.appendChild(div);
            };

        }


        $(document).on("click", ".addedContainer", function(e) {
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
                `<div class='hotspot-label added' style='top: ${t}%; left: ${l}%;'>
                    <div>${nameAppart}</div>
                    </div>
                <div class='hotspot added' style='top: ${offsetYPercent-1}%; left: ${offsetXPercent-1}%;'>
      <div class='icon'>+</div>
     
    </div>`
            );
            document.getElementById("formmm").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formmm").querySelector("input[name='y']").value = offsetYPercent;
            document.getElementById("formEdit").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formEdit").querySelector("input[name='y']").value = offsetYPercent;

            container.append(newElement);
        });

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

            const newElement =
                `<div class='hotspot-label added' style='top: ${t}%; left: ${l}%;'>
                    <div>${nameAppart}</div>
                    </div>
                <div class='hotspot added' style='top: ${offsetYPercent-1}%; left: ${offsetXPercent-1}%;'>
      <div class='icon'>+</div> </div>`;
            document.getElementById("formmm").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formmm").querySelector("input[name='y']").value = offsetYPercent;
            document.getElementById("formEdit").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formEdit").querySelector("input[name='y']").value = offsetYPercent;

            container.append(newElement);
        });
    </script>
@endsection
