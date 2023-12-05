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
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Appartements</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="d-flex justify-content-start m-3 col-3">
                                <h5 class="card-title m-3">Résidence: </h5>
                                <select name="" id="resSelect" class="form-control">
                                    <option value="0">Tout</option>
                                    @foreach ($residences as $residence )
                                    <option value="{{$residence->id}}">{{$residence->name}}</option>
                                    @endforeach
                                </select>                                
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Appartement</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">N° Téléphone</th>
                                            <th scope="col">N° CIN</th>
                                            <th scope="col">Etage</th>
                                            <th scope="col">Résidence</th>
                                            <th scope="col">Surface</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Prix</th>
                                            <th scope="col">Statut</th>
                                            
                                            <th scope="col">Charges</th>
                                            <th scope="col">Échanciers</th>

                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($apparts as $appart)
                                            <tr>
                                                <td>{{ $appart->name }}</td>
                                                <td>
                                                    @if ($appart->client)
                                                        {{ $appart->client->name }} {{ $appart->client->lastName }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($appart->client)
                                                        {{ $appart->client->phone }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($appart->client)
                                                        {{ $appart->client->cin }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td id="{{ $appart->etage->id }}">{{ $appart->etage->name }}</td>
                                                <td id="{{ $appart->etage->building->id }}">{{ $appart->etage->building->name }}</td>
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
                                            <form method="POST" action="{{ route('apparts.store') }}"
                                                enctype="multipart/form-data" id="formmm">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Nom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="Nom"
                                                            id="nomAppart" class="form-control">
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
                                                        <input type="text" name="name" placeholder="Nom" id="nomAppartEdit"
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
                                                        <main class="cd__main editHotspot" style="display: none;">

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
        loadImage(addSelect.value);

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

            loadImage(id)
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

        function loadImage(id) {
            const main = document.querySelector('.cd__main');
            const etages = @json($etages);

            const w = 458;
            etages.forEach((etage) => {
                if (etage.id == id) {
                    if (etage.hplan != 'undefined' && etage.wplan != 'undefined') {
                        main.style.display = 'block'
                        main.innerHTML = ''
                        const imageUrl = "../../" + etage.plan;
                        const div = document.createElement('div');
                        const ratio = etage.wplan / etage.hplan;

                        main.setAttribute('style', 'height: ' + w / ratio +
                            'px; width: ' + w + 'px;');


                        div.classList.add('containerH');

                        const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
                        div.setAttribute('style', "background-image: url('" + path + "'); height: " + w / ratio +
                            "px; width: " + w + "px;");

                        etage.appart.forEach((ap) => {
                            const appart = document.createElement('div');
                            appart.classList.add('hotspot');
                            appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
                            appart.innerHTML = '<div class="icon">+</div><div class="content"><h4>' + ap
                                .name +
                                '</h4><p>' + ap.comments + '</p><a class="btn">Voir</a></div>';
                            const divText = document.createElement('div');
                            let t = ap.y - 10;
                            let l = ap.x - 10;
                            t += 10;
                            l += 14;
                            divText.setAttribute('style', 'top: ' + t + '%; left: ' + l + '%;  ');
                            divText.innerHTML = '<div>' + ap.name + '</div>';
                            divText.classList.add('hotspot-label');
                            div.appendChild(divText);
                            div.appendChild(appart);
                        })
                        main.appendChild(div);
                    }
                }
            });
        }

        function loadImageEdit(id, appart_id) {
            const main = document.querySelector('.editHotspot');
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
                            const divText = document.createElement('div');
                            let t = ap.y - 10;
                            let l = ap.x - 10;
                            t += 10;
                            l += 14;
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
                    }
                }
            });
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
        inputNom.addEventListener('change', (e)=>{
            nameAppart = e.target.value;
        } )
        const inputNomEdit = document.getElementById('nomAppartEdit');
        inputNomEdit.addEventListener('change', (e)=>{
            nameAppart = e.target.value;
        } )
        

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
                                loadImageEdit(e.id, appart.id)
                                etage_idInput.value = e.id
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
                `<div class='hotspot-label added' style='top: ${t}%; left: ${l}%;'>
                    <div>${nameAppart}</div>
                    </div>
                <div class='hotspot added' style='top: ${offsetYPercent-1}%; left: ${offsetXPercent-1}%;'>
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
            document.getElementById("formmm").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formmm").querySelector("input[name='y']").value = offsetYPercent;
            document.getElementById("formEdit").querySelector("input[name='x']").value = offsetXPercent;
            document.getElementById("formEdit").querySelector("input[name='y']").value = offsetYPercent;

            container.append(newElement);
        });

        const resSelect = document.getElementById('resSelect');
        resSelect.addEventListener('change', function() {
            const table = document.getElementById('table1');
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach = Array.prototype.forEach;
            rows.forEach((row) => {
                const residence = row.querySelector('td:nth-child(6)').id;
                if (resSelect.value == 0) {
                    row.style.display = 'table-row';
                } else {
                    if (resSelect.value == residence) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }}
                
            })
        })
    </script>
@endsection
