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
                                <h5 class="card-title">Echanciers</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Residence</th>
                                            <th scope="col">Appartement</th>
                                            <th scope="col">Modalité</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Montant</th>
                                            <th scope="col">Date Avance</th>
                                            <th scope="col">Montant Avance</th>
                                            <th scope="col">Statut</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($echances as $echance)
                                            <tr>
                                                <td>{{ $echance->appart->etage->building->name }}</td>
                                                <td>{{ $echance->appart->name }}</td>
                                                <td>{{ $echance->type }}</td>
                                                <td>{{ $echance->date }}</td>
                                                <td>{{ $echance->amount }}</td>
                                                <td>{{ $echance->date_avance }}</td>
                                                <td>{{ $echance->amount_avance }}</td>
                                                <td>
                                                    @if ($echance->payed)
                                                        <span class="badge bg-success">Payé</span>
                                                    @else
                                                        <span class="badge bg-danger">Non Payé</span>
                                                    @endif
                                                </td>
                                                <td>

                                                    <div class="d-flex">
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
                                <label>Modalité: </label>
                                <div class="form-group">
                                    <select name="type" class="form-control">
                                        <option value="Chèque">Chèque</option>
                                        <option value="Crédit">Crédit</option>
                                        <option value="Espèces">Espèces</option>
                                        <option value="Virement">Virement</option>
                                        <option value="Versement">Versement</option>
                                    </select>
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input type="number" name="amount" placeholder="Numero" class="form-control">
                                </div>
                                <label>Avance: </label>
                                <div class="form-group">
                                    <input type="number" name="amount_avance" placeholder="Numero" class="form-control">
                                </div>
                                <label>Date de l'avance: </label>
                                <div class="form-group">
                                    <input type="date" name="date_avance" placeholder="Numero" class="form-control">
                                </div>
                                <label>Statut: </label>
                                <div class="form-group">
                                    <select name="payed" class="form-control">
                                        <option value="0">Non Payé</option>
                                        <option value="1">Payé</option>
                                    </select>
                                </div>
                                <label>Preuve Avance: </label>
                                <input type="file" name="preuve_avance" class="image-preview-filepondAvance" />
                                <label>Promesse: </label>
                                <input type="file" name="promesse" class="image-preview-filepondPromesse" />
                                <label>Contrat: </label>
                                <input type="file" name="contrat" class="image-preview-filepondContrat" />

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
                                <label>Modalité: </label>
                                <div class="form-group">
                                    <select name="type" class="form-control">
                                        <option value="Chèque">Chèque</option>
                                        <option value="Crédit">Crédit</option>
                                        <option value="Espèces">Espèces</option>
                                        <option value="Virement">Virement</option>
                                        <option value="Versement">Versement</option>
                                    </select>
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input name="amount" type="number" placeholder="Numero" class="form-control">
                                </div>
                                <label>Avance: </label>
                                <div class="form-group">
                                    <input name="amount_avance" type="number" placeholder="Numero"
                                        class="form-control">
                                </div>
                                <label>Date de l'avance: </label>
                                <div class="form-group">
                                    <input name="date_avance" type="date" placeholder="Numero" class="form-control">
                                </div>
                                <label>Statut: </label>
                                <div class="form-group">
                                    <select name="payed" class="form-control">
                                        <option value="0">Non Payé</option>
                                        <option value="1">Payé</option>
                                    </select>
                                </div>
                                <label>Preuve Avance: </label>
                                <input type="file" name="preuve_avance" class="image-preview-filepond image-preview-filepondAvanceEdit" />
                                <label>Promesse: </label>
                                <input type="file" name="promesse" class="image-preview-filepond image-preview-filepondPromesseEdit" />
                                <label>Contrat: </label>
                                <input type="file" name="contrat" class="image-preview-filepond image-preview-filepondContratEdit" />

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
    <!-- End container-fluid-->
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
                labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action">Browse</span></span>`,
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
                labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action">Browse</span></span>`,
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
                const typeInput = form.querySelector('select[name="type"]')
                const amountInput = form.querySelector('input[ name="amount"]')
                const amount_avanceInput = form.querySelector('input[ name="amount_avance"]')
                const date_avanceInput = form.querySelector('input[ name="date_avance"]')
                const payedInput = form.querySelector('select[name="payed"]')
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
                    typeInput.value = client.type;
                    amountInput.value = client.amount;
                    amount_avanceInput.value = client.amount_avance;
                    date_avanceInput.value = client.date_avance;
                    payedInput.value = client.payed;
                    createFileInputEdit(".image-preview-filepondAvanceEdit", client.preuve_avance);
                    createFileInputEdit(".image-preview-filepondPromesseEdit", client.promesse);
                    createFileInputEdit(".image-preview-filepondContratEdit", client.contrat);
                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
@endsection
