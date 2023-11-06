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

                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Residence</th>
                                            <th scope="col">Appartement</th>
                                            <th scope="col">Client</th>
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

                                        <tr>
                                            <td>{{ $echance->appart->etage->building->name }}</td>
                                            <td>{{ $echance->appart->name }}</td>
                                            <td>

                                                @if ($echance->client != null)
                                                    {{ $echance->client->name }}
                                                    {{ $echance->client->lastName }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>{{ $echance->date }}</td>
                                            <td>{{ $echance->amount_avance }}</td>
                                            <td>{{ $echance->date_avance }}</td>
                                            <td>
                                                <div class="d-flex flex-column justify-items-center align-items-center ">
                                                    @if ($echance->preuve_avance != null)
                                                        <div>
                                                            <a href="/" class="btn btn-success">Télécharger</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-items-center align-items-center ">
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
                                                <div class="d-flex flex-column justify-items-center align-items-center ">
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
                                                        class="btn btn-primary edit"><i
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
                                <i data-feather="x"></i>
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
                                <label>Appartement: </label>
                                <div class="form-group">
                                    <select name="appart_id" id="appartAdd" class="form-control">

                                    </select>
                                </div>
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Numero" class="form-control">
                                </div>
                                <label>Avance: </label>
                                <div class="form-group">
                                    <input type="number" name="amount_avance" placeholder="Numero" class="form-control">
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
                            <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
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
                                <label>Appartement: </label>
                                <div class="form-group">
                                    <select name="appart_id" id="appartEdit" class="form-control">

                                    </select>
                                </div>
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Numero" class="form-control">
                                </div>
                                <label>Avance: </label>
                                <div class="form-group">
                                    <input type="number" name="amount_avance" placeholder="Numero"
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
                                    <span class="d-none d-sm-block text-white">Ajouter</span>
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
    <div class="content-wrapper mt-0" style="padding-top: 0px ">
        <div class="container-fluid mt-0">
            <div class="row mt-0">
                <div class="col-lg-12 mt-0">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Echéances</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineFormEcheance"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Montant</th>
                                            <th scope="col">Statut</th>
                                            <th scope="col">Modalité</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($echance->echeance as $echeance)
                                            <tr>

                                                <td>{{ $echeance->date }}</td>
                                                <td>{{ $echeance->montant }}</td>
                                                <td>
                                                    @if ($echeance->payed)
                                                        Payé
                                                    @else
                                                        Non Payé
                                                    @endif
                                                </td>
                                                <td>{{ $echeance->modalite }}</td>
                                                <td>
                                                    <div class="d-flex">
                                                        <button id="{{ $echeance->id }}"
                                                            class="btn btn-warning editEcheances m-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#inlineFormEcheanceEdit"><i
                                                                data-feather="edit"></i>Modifier</button>
                                                        <form method="GET"
                                                            action="{{ route('echeances.destroy', $echeance->id) }}">
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
            <div class="modal fade text-left " id="inlineFormEcheance" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('echeances.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="echance_id" value="{{ $echance->id }}">
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Numero" class="form-control">
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input type="number" name="montant" placeholder="Numero" class="form-control">
                                </div>
                                <label>Modalité: </label>
                                <div class="form-group">
                                    <select name="modalite" class="form-control">
                                        <option value="Chèque">Chèque</option>
                                        <option value="Crédit">Crédit</option>
                                        <option value="Espèces">Espèces</option>
                                        <option value="Virement">Virement</option>
                                        <option value="Versement">Versement</option>
                                    </select>
                                </div>
                                <label>Statut: </label>
                                <div class="form-group">
                                    <select name="payed" class="form-control">
                                        <option value="0">Non Payé</option>
                                        <option value="1">Payé</option>
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
            <div class="modal fade text-left " id="inlineFormEcheanceEdit" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel44" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form method="POST" id="editFormEcheance" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="echance_id" value="{{ $echance->id }}">
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Numero" class="form-control">
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input type="number" name="amount" placeholder="Numero" class="form-control">
                                </div>
                                <label>Modalité: </label>
                                <div class="form-group">
                                    <select name="modalite" class="form-control">
                                        <option value="Chèque">Chèque</option>
                                        <option value="Crédit">Crédit</option>
                                        <option value="Espèces">Espèces</option>
                                        <option value="Virement">Virement</option>
                                        <option value="Versement">Versement</option>
                                    </select>
                                </div>
                                <label>Statut: </label>
                                <div class="form-group">
                                    <select name="payed" class="form-control">
                                        <option value="0">Non Payé</option>
                                        <option value="1">Payé</option>
                                    </select>
                                </div>

                            </div>
                        </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/vendors.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

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
        loadEtages(selectEtages.value, 'addetage');
        const selectApparts = document.getElementById('addetage');
        loadApparts(selectApparts.value, 'appartAdd');
        selectEtages.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'addetage')
            const selectApparts = document.getElementById('addetage');
            loadApparts(selectApparts.value, 'appartAdd');
        })
        selectApparts.addEventListener('change', (e) => {
            const id = e.target.value
            loadApparts(id, 'appartAdd')
        })

        const selectEtagesEdit = document.getElementById('residencesEdit')
        const selectAppartsEdit = document.getElementById('editetage');
        selectEtagesEdit.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'editetage')
            const selectApparts = document.getElementById('editetage');
            loadApparts(selectApparts.value, 'appartEdit');
        })
        selectAppartsEdit.addEventListener('change', (e) => {
            const id = e.target.valueOf()
            loadApparts(id, 'appartEdit')
        })

        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        editButtons.forEach((editButton) => {
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

        const editEcheances = document.getElementsByClassName('editEcheances');
        editEcheances.forEach = Array.prototype.forEach;
        editEcheances.forEach((editEcheance) => {
            editEcheance.addEventListener('click', function() {

                const form = document.getElementById('editFormEcheance');

                let base = '{{ route('echeances.update', '5') }}';
                base = base.replace('5', editEcheance.id);
                form.action = base;
                const dateInput = form.querySelector('input[ name="date"]')
                const montantInput = form.querySelector('input[ name="amount"]')
                const modaliteInput = form.querySelector('select[name="modalite"]')
                const payedInput = form.querySelector('select[name="payed"]')

                url = "{{ route('echeances.get', 5) }}";
                url = url.replace('5', editEcheance.id);
                axios.get(url).then((reponse) => {
                    console.log("object")
                    const client = reponse.data;
                    console.log(client)
                    dateInput.value = client.date;
                    montantInput.value = client.montant;
                    modaliteInput.value = client.modalite;
                    payedInput.value = client.payed;
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
@endsection
