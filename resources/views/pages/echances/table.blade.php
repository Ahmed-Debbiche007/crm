@extends('welcome')
@section('title', 'Echanciers')
@section('styles')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Echéanciers</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="d-flex justify-content-start m-3 col-12 col-md-3">
                                <h5 class="card-title m-3">Résidence: </h5>
                                <select name="" id="resSelect" class="form-control">
                                    <option value="0">Tout</option>
                                    @foreach ($residences as $residence)
                                        <option value="{{ $residence->id }}">{{ $residence->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between align-items-start m-3 col-5">
                                <h5 class="card-title mx-3">Promesse: </h5>
                                <div class="d-flex flex-column justify-content-start">
                                    <div class='form-check'>
                                        <div class="checkbox">
                                            <input type="checkbox" id="checkedLivrée" class="form-check-input">
                                            <label>Livrée </label>
                                        </div>
                                    </div>
                                    <div class='form-check'>
                                        <div class="checkbox">
                                            <input type="checkbox" id="checkedLégalisée" class="form-check-input">
                                            <label>Légalisée </label>
                                        </div>
                                    </div>

                                </div>
                                <h5 class="card-title mx-3">Contrat: </h5>
                                <div class="d-flex flex-column justify-content-start">
                                    <div class='form-check'>
                                        <div class="checkbox">
                                            <input type="checkbox" id="checkedLivré" class="form-check-input">
                                            <label>Livré </label>
                                        </div>
                                    </div>
                                    <div class='form-check'>
                                        <div class="checkbox">
                                            <input type="checkbox" id="checkedEnregistré" class="form-check-input">
                                            <label>Enregistré </label>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Residence</th>
                                            <th scope="col">Bien Immobilier</th>
                                            <th scope="col">Client</th>

                                            <th scope="col">Date</th>
                                            <th scope="col">Prix</th>
                                            <th scope="col">Montant Payé</th>
                                            <th scope="col">Montant Restant</th>
                                            <th scope="col">Avance</th>
                                            <th scope="col">Promesse</th>
                                            <th scope="col">Contrat</th>
                                            <th scope="col">Acte de précision</th>
                                            <th scope="col" class="noExport">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($echances as $echance)
                                            <tr>
                                                <td id="{{ $echance->appart->etage->building->id }}">
                                                    {{ $echance->appart->etage->building->name }}</td>
                                                <td>{{ $echance->appart->name }}</td>
                                                <td>

                                                    @if ($echance->appart->client != null)
                                                        {{ $echance->appart->client->name }}
                                                        {{ $echance->appart->client->lastName }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $echance->date ? \Illuminate\Support\Carbon::parse($echance->date)->format('d-m-Y') : '' }}
                                                </td>
                                                <td>{{ number_format(floatval($echance->appart->price), 3, '.', ',') }}</td>
                                                @php
                                                    $totalEchances = 0;
                                                    $echance->echeance->each(function ($item) use (&$totalEchances) {
                                                        if ($item->payed == 1) {
                                                            $totalEchances += $item->montant;
                                                        }
                                                    });
                                                @endphp
                                                <td>{{ number_format(floatval($echance->amount_avance + $totalEchances), 3, '.', ',') }}
                                                </td>
                                                <td>{{ number_format(floatval($echance->appart->price - ($echance->amount_avance + $totalEchances)), 3, '.', ',') }}
                                                </td>
                                                </td>

                                                <td>

                                                    <div
                                                        class="d-flex flex-column justify-items-center align-items-center ">
                                                        <div>
                                                            {{ number_format(floatval($echance->amount_avance), 3, '.', ',') }}
                                                        </div>
                                                        @if ($echance->preuve_avance != null)
                                                            <div>
                                                                <a href="{{ asset($echance->preuve_avance) }}" target="_blank"
                                                                    download class="btn btn-success"><i
                                                                        data-feather="download"></i> Télécharger</a>
                                                            </div>
                                                        @endif



                                                    </div>
                                                </td>
                                                <td data-legal="{{ $echance->date_promesse_legal }}"
                                                    data-livre="{{ $echance->date_promesse_livre }}">
                                                    <div
                                                        class="d-flex flex-column justify-items-center align-items-center ">
                                                        @if ($echance->promesse != null)
                                                            <div>
                                                                <a href="{{ asset($echance->promesse) }}" target="_blank"
                                                                    download class="btn btn-success"><i
                                                                        data-feather="download"></i> Télécharger</a>
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
                                                <td data-enreg="{{ $echance->date_contrat_enregistre }}"
                                                    data-livre="{{ $echance->date_contrat_livre }}">
                                                    <div
                                                        class="d-flex flex-column justify-items-center align-items-center ">
                                                        @if ($echance->contrat != null)
                                                            <div>
                                                                <a href="{{ asset($echance->contrat) }}" target="_blank"
                                                                    download class="btn btn-success"><i
                                                                        data-feather="download"></i> Télécharger</a>
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
                                                    <div
                                                        class="d-flex flex-column justify-items-center align-items-center ">
                                                        @if ($echance->acte != null)
                                                            <div>
                                                                <a href="{{ asset($echance->acte) }}" target="_blank"
                                                                    download class="btn btn-success"><i
                                                                        data-feather="download"></i> Télécharger</a>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            @if ($echance->date_acte_enreg != null)
                                                                Enregistré: {{ $echance->date_acte_enreg }}
                                                            @endif
                                                        </div>
                                                        <div>
                                                            @if ($echance->date_acte_livre != null)
                                                                Livré: {{ $echance->date_acte_livre }}
                                                            @endif
                                                        </div>

                                                    </div>
                                                </td>

                                                <td>

                                                    <div class="d-flex">
                                                        <a href="{{ route('echances.show', $echance->id) }}"
                                                            class="btn btn-primary edit m-1"><i
                                                                data-feather="plus-circle"></i>Details</a>
                                                        <button id="{{ $echance->id }}" class="btn btn-warning edit m-1"
                                                            data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
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
            <div class="modal fade text-left " id="inlineForm" tabindex="-1" role="dialog"
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
                                <label>Residence: </label>
                                <div class="form-group">
                                    <select name="residence_id" id="residencesAdd" class="form-control">
                                        @foreach ($residences as $residence)
                                            <option value="{{ $residence->id }}">{{ $residence->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label>Etage: </label>
                                <div class="form-group">
                                    <select name="etage_id" id="addetage" class="form-control">

                                    </select>
                                </div>
                                <label>Bien Immobilier: </label>
                                <div class="form-group">
                                    <select name="appart_id" id="appartAdd" class="form-control">

                                    </select>
                                </div>
                                <div id="details" class="d-flex justify-content-between"></div>
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

                                <label>Acte de précision: </label>
                                <input type="file" name="acte" class="image-preview-filepondActe" />
                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="livraisonActe" class="form-check-input">
                                        <label>Date Livraison: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="livraisonActeDate" disabled name="date_acte_livre"
                                        class="form-control">
                                </div>

                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="enregistreActe" class="form-check-input">
                                        <label>Date Enregistrement: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="enregistreDateActe" disabled name="date_acte_enreg"
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
            <div class="modal fade text-left " id="inlineFormEdit" tabindex="-1" role="dialog"
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
                                <label>Residence: </label>
                                <div class="form-group">
                                    <select name="residence_id" id="residencesEdit" class="form-control">
                                        @foreach ($residences as $residence)
                                            <option value="{{ $residence->id }}">{{ $residence->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <label>Etage: </label>
                                <div class="form-group">
                                    <select name="etage_id" id="editetage" class="form-control">

                                    </select>
                                </div>
                                <label>Bien Immobilier: </label>
                                <div class="form-group">
                                    <select name="appart_id" id="appartEdit" class="form-control">

                                    </select>
                                </div>
                                <div id="detailsEdit" class="d-flex justify-content-between"></div>
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

                                <label>Acte de précision: </label>
                                <input type="file" name="acte" class="image-preview-filepondActeEdit" />
                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="livraisonActeEdit" class="form-check-input">
                                        <label>Date Livraison: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="livraisonActeDateEdit" disabled name="date_acte_livre"
                                        class="form-control">
                                </div>

                                <div class='form-check'>
                                    <div class="checkbox">
                                        <input type="checkbox" id="enregistreEditActe" class="form-check-input">
                                        <label>Date Enregistrement: </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="enregistreDateEditActe" disabled name="date_acte_enreg"
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
        </div>


        <!--start overlay-->
        <div class="overlay toggle-menu"></div>
        <!--end overlay-->
    </div>
    <!-- End container-fluid-->
    </div>
@endsection

@section('scripts')




    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="{{ asset('dist/js/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('dist/js/vendors.js') }}"></script>



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
        createFileInput(".image-preview-filepondActe");

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
        const getDetailsAppart = (id, select) => {
            let route = '{{ route('apparts.get', '5') }}';
            route = route.replace('5', id);
            axios.get(route).then((reponse) => {
                const appart = reponse.data;
                const divDetails = document.getElementById(select);
                const detailsClient = document.createElement('h4');
                const detailsPrice = document.createElement('h4');
                divDetails.innerHTML = '';
                if (appart.client) {
                    detailsClient.innerHTML = 'Client: ' + appart.client.name + ' ' + appart.client.lastName;
                    divDetails.appendChild(detailsClient);
                }
                if (appart.price) {
                    detailsPrice.innerHTML = 'Prix: ' + appart.price + 'TND';
                    divDetails.appendChild(detailsPrice);
                }



            }).catch((error) => {
                console.log(error)
            })
        }

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

        function loadApparts(id, appartId) {
            const selectAppart = document.getElementById(appartId)
            selectAppart.innerHTML = ''
            const data = @json($residences);
            data.forEach(residence => {
                residence.etage.forEach((etage) => {
                    if (etage.id == id) {
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

        const selectEtages = document.getElementById('residencesAdd')
        const listApparts = document.getElementById('appartAdd');
        const listAppartsEdit = document.getElementById('appartEdit');
        loadEtages(selectEtages.value, 'addetage');
        const selectApparts = document.getElementById('addetage');
        loadApparts(selectApparts.value, 'appartAdd');
        getDetailsAppart(listApparts.value, 'details');
        selectEtages.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'addetage')
            const selectApparts = document.getElementById('addetage');
            loadApparts(selectApparts.value, 'appartAdd');
            getDetailsAppart(listApparts.value, 'details');
        })
        selectApparts.addEventListener('change', (e) => {
            const id = e.target.value
            loadApparts(id, 'appartAdd');
            getDetailsAppart(listApparts.value, 'details')
        })

        const selectEtagesEdit = document.getElementById('residencesEdit')
        const selectAppartsEdit = document.getElementById('editetage');
        selectEtagesEdit.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'editetage')
            const selectApparts = document.getElementById('editetage');
            loadApparts(selectApparts.value, 'appartEdit');
            getDetailsAppart(listAppartsEdit.value, 'detailsEdit');
        })
        selectAppartsEdit.addEventListener('change', (e) => {
            const id = e.target.valueOf()
            loadApparts(id, 'appartEdit');
            getDetailsAppart(listAppartsEdit.value, 'detailsEdit')

        })

        listApparts.addEventListener('change', (e) => {
            const id = e.target.value;
            getDetailsAppart(id, 'details');

        })

        listAppartsEdit.addEventListener('change', (e) => {
            const id = e.target.value;
            getDetailsAppart(id, 'detailsEdit');

        })
        const resSelect = document.getElementById('resSelect');
        const resId = window.location.search.split('=')[1];
        if (resId) {
            resSelect.value = resId;
            selectEtages.value = resId;
            loadEtages(selectEtages.value, 'addetage');
            loadApparts(selectApparts.value, 'appartAdd');
            getDetailsAppart(listApparts.value, 'details');

        } else {
            resSelect.value = 0;
            selectEtages.value = 1;
            loadEtages(selectEtages.value, 'addetage');
            loadApparts(selectApparts.value, 'appartAdd');
            getDetailsAppart(listApparts.value, 'details');
        }
        resSelect.addEventListener('change', function() {
            if (this.value == 0)
                window.location.href = "{{ route('echances') }}";
            else
                window.location.href = "{{ route('echances') }}" + "?res=" + this.value;
        })


        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const form = document.getElementById('editForm');
                const editButton = target;
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
                const date_acte_livre = form.querySelector('input[name="date_acte_livre"]');
                const date_acte_enreg = form.querySelector('input[name="date_acte_enreg"]');
                const livraisonDateEdit = form.querySelector("input[id=livraisonEdit]")
                const legalDateEdit = form.querySelector("input[id=legalEdit]")
                const livraisonPromesseDateEdit = form.querySelector("input[id=livraisonPromesseEdit]")
                const enregistreDateEdit = form.querySelector("input[id=enregistreEdit]")
                const livraisonActeDateEdit = form.querySelector("input[id=livraisonActeEdit]")
                const enregistreDateActeEdit = form.querySelector("input[id=enregistreEditActe]")

                url = "{{ route('echances.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const client = reponse.data;
                    const data = @json($residences);
                    data.forEach((residence) => {
                        residence.etage.forEach((etage) => {
                            etage.appart.forEach((appart) => {
                                if (appart.id == client.appart_id) {
                                    residence_idInput.value = residence.id;
                                    loadEtages(residence.id, 'editetage');
                                    etage_idInput.value = etage.id;
                                    loadApparts(etage.id, 'appartEdit');
                                    appart_idInput.value = appart.id;
                                    getDetailsAppart(appart.id, 'detailsEdit');
                                }
                            })
                        })
                    })
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
                    if (client.date_acte_livre) {
                        livraisonActeDateEdit.checked = true;
                        date_acte_livre.disabled = false;
                    } else {
                        date_acte_livre.disabled = true
                        livraisonActeDateEdit.checked = false;
                    }
                    date_acte_livre.value = client.date_acte_livre
                    if (client.date_acte_enreg) {
                        enregistreDateActeEdit.checked = true;
                        date_acte_enreg.disabled = false;
                    } else {
                        date_acte_enreg.disabled = true
                        enregistreDateActeEdit.checked = false;
                    }
                    date_acte_enreg.value = client.date_acte_enreg
                    date_contrat_enregistre.value = client.date_contrat_enregistre
                    createFileInputEdit(".image-preview-filepondAvanceEdit", client.preuve_avance);
                    createFileInputEdit(".image-preview-filepondPromesseEdit", client.promesse);
                    createFileInputEdit(".image-preview-filepondContratEdit", client.contrat);
                    createFileInputEdit(".image-preview-filepondActeEdit", client.acte);
                }).catch((error) => {
                    console.log(error)
                })
            };
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

        const livraisonActe = document.getElementById("livraisonActe");
        livraisonActe.addEventListener('click', () => {
            const livraisonActeDate = document.getElementById("livraisonActeDate");
            livraisonActeDate.disabled = livraisonActe.checked ? false : true;
        })
        const enregistreActe = document.getElementById("enregistreActe");
        enregistreActe.addEventListener('click', () => {
            const enregistreDateActe = document.getElementById("enregistreDateActe");
            enregistreDateActe.disabled = enregistreActe.checked ? false : true;
        })



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

        const checkedLivrée = document.getElementById('checkedLivrée');
        const checkedLégalisée = document.getElementById('checkedLégalisée');

        const checkedLivré = document.getElementById('checkedLivré');
        const checkedEnregistré = document.getElementById('checkedEnregistré');

        checkedLivrée.addEventListener('click', function() {
            const table = document.getElementById('table1');
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach = Array.prototype.forEach;
            rows.forEach((row) => {
                const livraison = row.querySelector('td:nth-child(9)').getAttribute('data-livre');
                console.log(livraison)
                if (checkedLivrée.checked) {
                    if (livraison != "") {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                } else {
                    row.style.display = 'table-row';
                }
            })
        })
        checkedLégalisée.addEventListener('click', function() {
            const table = document.getElementById('table1');
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach = Array.prototype.forEach;
            rows.forEach((row) => {
                const legalisation = row.querySelector('td:nth-child(9)').getAttribute('data-legal');
                if (checkedLégalisée.checked) {
                    if (legalisation != "") {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                } else {
                    row.style.display = 'table-row';
                }
            })
        })

        checkedLivré.addEventListener('click', function() {
            const table = document.getElementById('table1');
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach = Array.prototype.forEach;
            rows.forEach((row) => {
                const livraison = row.querySelector('td:nth-child(10)').getAttribute('data-livre');
                if (checkedLivré.checked) {
                    if (livraison != "") {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                } else {
                    row.style.display = 'table-row';
                }
            })
        })
        checkedEnregistré.addEventListener('click', function() {
            const table = document.getElementById('table1');
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach = Array.prototype.forEach;
            rows.forEach((row) => {
                const legalisation = row.querySelector('td:nth-child(10)').getAttribute('data-enreg');
                if (checkedEnregistré.checked) {
                    if (legalisation != "") {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                } else {
                    row.style.display = 'table-row';
                }
            })
        })
    </script>
@endsection
