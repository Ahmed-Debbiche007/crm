@extends('welcome')
@section('title', 'Celliers')
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
                                <h5 class="card-title">Celliers</h5>
                                @if (Auth::user()->role == 1)
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                        class="btn btn-primary">Ajouter</button>
                                @endif
                            </div>
                            <div class="d-flex justify-content-start m-3 col-sm-4 col-12">
                                <h5 class="card-title m-3">Résidence: </h5>
                                <select name="" id="resSelect" class="form-control">
                                    <option value="0">Tout</option>
                                    @foreach ($residences as $residence)
                                        <option value="{{ $residence->id }}">{{ $residence->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Residence</th>
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
                                        @foreach ($celliers as $cellier)
                                            <tr>
                                                <td id="{{ $cellier->residence->id }}">{{ $cellier->residence->name }}</td>
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
                                                                class="btn btn-warning edit m-1" data-bs-toggle="modal"
                                                                data-bs-target="#inlineFormEdit"><i
                                                                    data-feather="edit"></i>Modifier</button>

                                                            <form method="GET"
                                                                action="{{ route('celliers.destroy', $cellier->id) }}">
                                                                @csrf
                                                                <button type="button" class="btn btn-danger m-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#inlineChargeDelete{{ $cellier->id }}"><i
                                                                        data-feather="trash"></i>Supprimer</button>
                                                                <div class="modal fade"
                                                                    id="inlineChargeDelete{{ $cellier->id }}"
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-x-lg" viewBox="0 0 16 16">
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
                                    <input type="number" name="surface" placeholder="Surface" class="form-control">
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
                        <form id="formEdit" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="modal-body">
                                <label>Residence: </label>
                                <div class="form-group">
                                    <select name="residence_id" class="form-control" id="residencesEdit">
                                        @foreach ($residences as $residence)
                                            <option value="{{ $residence->id }}">
                                                {{ $residence->name }}</option>
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
                                    <input type="number" name="surface" placeholder="Surface" class="form-control">
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
        const data = @json($residences);
        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const editButton = target;
                const form = document.getElementById('formEdit');

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
        })




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

        const resSelect = document.getElementById('resSelect');
        const resId = window.location.search.split('=')[1];
        if (resId) {
            resSelect.value = resId;
            selectEtages.value = resId;
            loadEtages(selectEtages.value, 'addetage');
            loadApparts(selectApparts.value, 'appartAdd');


        } else {
            resSelect.value = 0;
            selectEtages.value = 1;
            loadEtages(selectEtages.value, 'addetage');
            loadApparts(selectApparts.value, 'appartAdd');

        }
        resSelect.addEventListener('change', function() {
            if (this.value == 0)
                window.location.href = "{{ route('celliers') }}";
            else
                window.location.href = "{{ route('celliers') }}" + "?res=" + this.value;
        })
    </script>
@endsection
