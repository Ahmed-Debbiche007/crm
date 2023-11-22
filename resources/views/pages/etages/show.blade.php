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
                    <button id="{{ $etage->id }}" class="btn btn-warning editEt" data-bs-toggle="modal"
                        data-bs-target="#inlineEtageEdit"><i data-feather="edit"></i>Modifier</button>
                    <h5 class="card-title">Résidence: {{ $etage->building->name }}</h5>
                    <h5 class="card-title">Étage: {{ $etage->name }}</h5>
                    <h5 class="card-title">Nombre d'appartements: {{ $etage->appart->count() }}</h5>
                    <h5 class="card-title">Plan:</h5>
                    <div class="pb-5">
                        <main class="main_plan" style="display: block;">

                        </main>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Appartements</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
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
                                                    <a href="{{ route('apparts.show', $appart->id) }}"
                                                        class="btn btn-primary"><i
                                                            data-feather="plus-circle"></i>Details</a>
                                                    <button id="{{ $appart->id }}" class="btn btn-warning edit"
                                                        data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                            data-feather="edit"></i>Modifier</button>
                                                    <button onclick="deleteClient({{ $appart->id }})"
                                                        class="btn btn-danger"><i
                                                            data-feather="trash"></i>Supprimer</button>
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
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
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
                                                            class="form-control">
                                                    </div>

                                                    <label>Résidence: </label>
                                                    <div class="form-group">
                                                        <select name="residence_id" class="form-control" id="residencesAdd">
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
                                                        <main class="cd__main" style="display: none;">

                                                        </main>
                                                        <input type="hidden" name="x">
                                                        <input type="hidden" name="y">

                                                    </div>

                                                    <label>Surface: </label>
                                                    <div class="form-group">
                                                        <input type="number" name="surface" placeholder="Numéro CIN"
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
                                                        <input type="number" name="price" placeholder="Numéro CIN"
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
                                                        class="multiple-files-filepond" multiple>
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
                                                        <span class="d-none d-sm-block text-white">Ajouter</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade text-left " id="inlineFormEdit" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
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
                                            <form method="POST" id="formEdit" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Nom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="Nom"
                                                            class="form-control">
                                                    </div>
                                                    <label>Résidence: </label>
                                                    <div class="form-group">
                                                        <select name="residence_id" class="form-control" id="residencesEdit">
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
                                                        <input type="number" name="surface" placeholder="Numéro CIN"
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
                                                        <input type="number" name="price" placeholder="Numéro CIN"
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
                                                        <span class="d-none d-sm-block text-white">Ajouter</span>
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
                                        <input type="text" name="name" placeholder="Addresse"
                                            class="form-control">
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



            </div>
            <!--End Row-->



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

const selectEtages = document.getElementById('residencesAdd')
        const selectEtagesEdit = document.getElementById('residencesEdit')
        const addSelect = document.getElementById('addetage')
        const etagesSelectEdit = document.getElementById('editetage')
        loadEtages(selectEtages.value, 'addetage');
        
        
        selectEtages.addEventListener('change', (e) => {
            const id = e.target.value

            loadEtages(id, 'addetage')
        })

        selectEtagesEdit.addEventListener('change', (e) => {
            const id = e.target.value

            loadEtages(id, 'editetage')
        })
        etagesSelectEdit.addEventListener('change', (e) => {
            const id = e.target.value
            const appart = document.getElementById('formEdit').querySelector('input[name="id"]')?.value
            
        })
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





        function deleteClient(id) {
            var form = document.getElementById('delete');
            let base = '{{ route('apparts.destroy', '5') }}';
            base = base.replace('5', id);
            form.action = base;
            form.method = 'DELETE';
            form.submit();
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
                    loadEtages(appart.etage_id, 'editetage')
                    loadImageOnEdit(appart.id)
                    nameInput.value = appart.name
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
        const editButtonEt = document.getElementsByClassName('editEt');
        editButtonEt.forEach = Array.prototype.forEach;
        editButtonEt.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEtage');

                let base = '{{ route('etages.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const resInput = form.querySelector('select[name="residence_id"]');
                const numberInput = form.querySelector('input[name="name"]');

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
            });
        })

        const main = document.querySelector('.main_plan');
        const etage = @json($etage);
        const ratio = etage.wplan / etage.hplan
        main.style.width = '500px';
        main.style.height = (500 / ratio) + 'px';
        const div = document.createElement('div');
        div.classList.add('containerD');
        const wid = 458;
        const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
        div.setAttribute('style', "background-image: url('" + path + "'); height: " + wid / ratio +
            "px; width: " + wid + "px;");
        etage.appart.forEach((ap) => {
            const appart = document.createElement('div');
            appart.classList.add('hotspot');

            appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
            let statut = "";
            switch (ap.bs) {
                case 0:
                    statut = "Libre";
                    break;
                case 1:
                    statut = "Loué";
                    break;
                case 2:
                    statut = "Réservé";
                    break;
                case 3:
                    statut = "Vendu";
                    break;
            }
            const link = "{{ route('apparts.show', 5) }}".replace('5', ap.id);
            const ht = document.createElement('div');
            ht.classList.add('icon');
            ht.classList.add('hotspot');
            ht.innerHTML = "+"  ;
            ht.addEventListener('click', function() {
                var parent = this.parentElement;
                parent.classList.toggle('open');

                var hotspots = document.querySelectorAll('.hotspot.open');
                hotspots.forEach(function(hotspot) {
                    if (hotspot !== parent) {
                        hotspot.classList.remove('open');
                    }
                });
            });
            const content = document.createElement('div');
            content.classList.add('content');
            content.innerHTML = '<h4>' + ap.name + '</h4><p>' + statut + '</p><a href="' + link +
                '" class="btn">Voir</a>';

            appart.appendChild(ht);
            appart.appendChild(content);
            div.appendChild(appart);
        })

        main.appendChild(div);
    </script>
    <script>
        function loadImage(id) {
            const main = document.querySelector('.cd__main');


            const wid = 458;

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
                    if (ap.id == appart_id) {
                        appart.classList.add('added');
                    }
                    appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
                    appart.innerHTML = '<div class="icon">+</div><div class="content"><h4>' + ap.name +
                        '</h4><p>' + ap.comments + '</p><a class="btn">Voir</a></div>';
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

            const newElement = $(
                `<div class='hotspot added' style='top: ${offsetYPercent-1}%; left: ${offsetXPercent-1}%;'>
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

            const newElement = $(
                `<div class='hotspot added' style='top: ${offsetYPercent-1}%; left: ${offsetXPercent-1}%;'>
      <div class='icon'>+</div>
     
    </div>`
            );
            document.getElementById("formmm").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formmm").querySelector("input[name='y']").value = offsetYPercent;
            document.getElementById("formEdit").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formEdit").querySelector("input[name='y']").value = offsetYPercent;

            container.append(newElement);
        });
    </script>
@endsection
