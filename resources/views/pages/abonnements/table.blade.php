@extends('welcome')
@section('title', 'Frais Syndic')
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
                                <h5 class="card-title">Frais Syndic</h5>
                                @if (Auth::user()->role == 1)
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                        class="btn btn-primary">Ajouter</button>
                                @endif
                            </div>
                            <div class="d-flex justify-content-start flex-wrap flex-row m-3 col-sm-4 col-12">
                                <div class="d-flex flex-column align-items-start mx-2">
                                    <h5 class="card-title mb-2">Annee:</h5>
                                    <select name="annee" class="form-control" id="anneeSelect">
                                        <option value="0">Tout</option>
                                        @for ($i = 2021; $i <= 2100; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="d-flex flex-column align-items-start mx-2">
                                    <h5 class="card-title mb-2">Client:</h5>
                                    <select name="client" class="form-control" id="clientSelect">
                                        <option value="0">Tout</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }} {{ $client->lastName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex flex-column align-items-end justify-content-end mx-2">
                                    <button class="btn btn-primary" id="chercher">Chercher</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Année</th>
                                            <th scope="col">Bien Immobilier</th>
                                            <th scope="col">Client</th>
                                            <th scope="col" id="summable">Montant à Payer</th>
                                            <th scope="col" id="summable">Montant Payé</th>
                                            <th scope="col" id="summable">Montant Restant</th>

                                            <th scope="col" class="noExport">Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($apparts as $appart)
                                            @if ($appart->abonnements->isNotEmpty())
                                                @foreach ($appart->abonnements as $abonnement)
                                                    <tr>
                                                        <td id="{{ $abonnement->id }}">
                                                            {{ $abonnement->annee }}</td>
                                                        <td>{{ $abonnement->appart->name }}</td>
                                                        <td>{{ $abonnement->appart->client ? $abonnement->appart->client->lastName . ' ' . $abonnement->appart->client->name : '' }}
                                                        </td>
                                                        <td>{{ number_format($abonnement->amount, 3, '.', ' ') }}</td>
                                                        <td>{{ number_format($abonnement->reglements->sum('amount'), 3, '.', ' ') }}
                                                        </td>
                                                        <td>{{ number_format($abonnement->amount - $abonnement->reglements->sum('amount'), 3, '.', ' ') }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('reglements.index', $abonnement->id) }}"
                                                                class="btn btn-primary">
                                                                <i data-feather="plus-circle"></i>Details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td>{{ Request::query('annee') ?? \Carbon\Carbon::now()->format('Y') }}</td>
                                                    <td>{{ $appart->name }}</td>
                                                    <td>{{ $appart->client ? $appart->client->lastName . ' ' . $appart->client->name : '' }}
                                                    </td>
                                                    <td>{{ number_format($settings->amount, 3, '.', ' ') }}</td>
                                                    <td>{{ number_format(0, 3, '.', ' ') }}</td>
                                                    <td>{{ number_format($settings->amount, 3, '.', ' ') }}</td>
                                                    <td></td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th scope="col"><b>Total:</b></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col" style="color:#ff0000"></th>
                                        <th scope="col" style="color:#ff0000"></th>
                                        <th scope="col" style="color:#ff0000"></th>

                                        <th scope="col" class="noExport"></th>
                                    </tfoot>
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
                        <form method="POST" action="{{ route('abonnements.store') }}" enctype="multipart/form-data">
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
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Numero" class="form-control">
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input type="number" step="0.001" name="amount" placeholder="Montant"
                                        class="form-control">
                                </div>
                                <label>Année: </label>
                                <div class="form-group">
                                    <select name="annee" id="" class="form-control">
                                        @for ($i = 2021; $i <= 2100; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
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

                let base = '{{ route('abonnements.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const etage_idInput = form.querySelector('select[name="etage_id"]')
                const appart_idInput = form.querySelector('select[name="appart_id"]')
                const cleintInput = form.querySelector('input[name="client_id"]')

                url = "{{ route('abonnements.get', 5) }}";
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



        const chercher = document.getElementById('chercher');
        chercher.addEventListener('click', (e) => {
            const annee = document.getElementById('anneeSelect').value;
            const client = document.getElementById('clientSelect').value;

            let url = window.location.href;

            url = url.split('?')[0];

            if (annee != 0 && client != 0) {
                url = url + '?annee=' + annee + '&client=' + client;
            } else if (annee != 0) {
                url = url + '?annee=' + annee;
            } else if (client != 0) {
                url = url + '?client=' + client;
            }
            window.location.href = url;
        })
        // get current query string
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const anneeSearch = urlParams.get('annee');
        const clientSearch = urlParams.get('client');
        if (anneeSearch != null) {
            document.getElementById('anneeSelect').value = anneeSearch;
        }
        if (clientSearch != null) {
            document.getElementById('clientSelect').value = clientSearch;
        }
    </script>
@endsection
