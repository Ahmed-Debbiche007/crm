@extends('welcome')
@section('title', 'Charges')
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
                                <h5 class="card-title">Charges</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="d-flex justify-content-start m-3 col-3">
                                <h5 class="card-title m-3">Résidence: </h5>
                                <select name="" id="resSelect" class="form-control">
                                    <option value="0">Tout</option>
                                    @foreach ($residences as $residence)
                                        <option value="{{ $residence->id }}">{{ $residence->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="table-responsive" >
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Residence</th>
                                            <th scope="col">Etage</th>
                                            <th scope="col">Bien Immobilier</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Sonède & Gaz</th>
                                            <th scope="col">Syndic</th>
                                            
                                            <th scope="col">Avocat </th>
                                            <th scope="col">Titre Foncier</th>
                                            <th scope="col" class="noExport">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($charges as $charge)
                                            <tr>
                                                <td id="{{ $charge->appart->etage->building->id }}">
                                                    {{ $charge->appart->etage->building->name }}</td>
                                                <td>{{ $charge->appart->etage->name }}</td>
                                                <td>{{ $charge->appart->name }}</td>
                                                <td>
                                                    @if ($charge->appart->client)
                                                        {{ $charge->appart->client->name }}
                                                        {{ $charge->appart->client->lastName }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>{{ number_format(floatval($charge->sonede),3, '.', ',') }}</td>
                                                <td>{{ number_format(floatval($charge->syndic),3, '.', ',') }}</td>
                                                <td>{{ number_format(floatval($charge->contrat),3, '.', ',') }}</td>
                                                <td>{{ number_format(floatval($charge->foncier),3, '.', ',') }}</td>
                                                <td>

                                                    <div class="d-flex">
                                                        <button id="{{ $charge->id }}" class="btn btn-warning edit m-1"
                                                            data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
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
                        <form method="POST" action="{{ route('charges.store') }}" enctype="multipart/form-data">
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
                                <label id="clientAdd"></label>

                                <label>Sonède & Gaz: </label>
                                <div class="form-group">
                                    <input name="sonede" type="number" placeholder="Sonède & Gaz" class="form-control">
                                </div>

                                <label>Syndic: </label>
                                <div class="form-group">
                                    <input name="syndic" type="number" placeholder="Syndic" class="form-control">
                                </div>


                                <label>Avocat : </label>
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
                                <label>Appartement: </label>
                                <div class="form-group">
                                    <select name="appart_id" id="appartEdit" class="form-control">

                                    </select>
                                </div>

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

                                

                                <label>Avocat: </label>
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
            const id = e.target.value;
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
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const editButton = target;
                const form = document.getElementById('editForm');

                let base = '{{ route('charges.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const etage_idInput = form.querySelector('select[name="etage_id"]')
                const appart_idInput = form.querySelector('select[name="appart_id"]')
                const sonedeInput = form.querySelector('input[name="sonede"]');
                const syndicInput = form.querySelector('input[name="syndic"]');
                const contratInput = form.querySelector('input[name="contrat"]');
                const foncierInput = form.querySelector('input[name="foncier"]');
                url = "{{ route('charges.get', 5) }}";
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
                    sonedeInput.value = client.sonede;
                    syndicInput.value = client.syndic;
                    contratInput.value = client.contrat;
                    foncierInput.value = client.foncier;
                }).catch((error) => {
                    console.log(error)
                })
            };
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
                window.location.href = "{{ route('charges') }}";
            else
            window.location.href = "{{ route('charges') }}" + "?res=" + this.value;
        })
    </script>
@endsection
