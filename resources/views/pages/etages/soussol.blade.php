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
                        <h5 class="card-title">Nombre de parkings: {{ $etage->building->parking->count() }}</h5>
                        <h5 class="card-title">Nombre de celliers: {{ $etage->building->cellier->count() }}</h5>
                        <h5 class="card-title">Nombre de garages: {{ $etage->building->garage->count() }}</h5>
                    </div>
                    <h5 class="card-title">Plan:</h5>
                    <div class="pb-5">
                        <main class="main_plan" style="display: block;">

                        </main>
                    </div>
                    <div class="p-1 m-5">
                        @if (Auth::user()->role == 1)
                            <button id="{{ $etage->id }}" class="btn btn-warning editEt" data-bs-toggle="modal"
                                data-bs-target="#inlineEtageEdit"><i data-feather="edit"></i>Modifier</button>
                        @endif
                    </div>
                    <div class="card m-5">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Parkings</h5>
                                @if (Auth::user()->role == 1)
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                        class="btn btn-primary" id="addAppart">Ajouter</button>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col" id="appartOrder">Parking</th>
                                            <th scope="col">Numéro</th>
                                            <th scope="col">Client</th>
                                            @if (Auth::user()->role == 1)
                                                <th scope="col" class="noExport">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($etage->building->parking as $parking)
                                            <tr>

                                                <td>{{ $parking->name }}</td>
                                                <td>{{ $parking->number }}</td>
                                                <td>
                                                    @if ($parking->client)
                                                        {{ $parking->client->name }} {{ $parking->client->lastName }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>


                                                @if (Auth::user()->role == 1)
                                                    <td class="d-flex flex-row">
                                                        <button id="{{ $parking->id }}"
                                                            class="btn btn-warning edit m-1" data-bs-toggle="modal"
                                                            data-bs-target="#inlineFormEdit"><i
                                                                data-feather="edit"></i>Modifier</button>


                                                        <form method="GET"
                                                            action="{{ route('parkings.destroy', $parking->id) }}">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger m-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#inlineChargeDelete{{ $parking->id }}"><i
                                                                    data-feather="trash"></i>Supprimer</button>
                                                            <div class="modal fade"
                                                                id="inlineChargeDelete{{ $parking->id }}" tabindex="-1"
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
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                <!--End Row-->
                                <div class="modal fade text-left " id="inlineForm" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
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
                                        <form id="formmm" method="POST" action="{{ route('parkings.store') }}"
                                            enctype="multipart/form-data">
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
                                                <label>Place Parking: </label>
                                                <div class="form-group">
                                                    <input type="text" name="name" id="nameAdd"
                                                        placeholder="Place Parking" class="form-control">
                                                </div>
                                                <label>Numero: </label>
                                                <div class="form-group">
                                                    <input type="text" name="number" placeholder="Numero"
                                                        class="form-control">
                                                </div>
                                                <label>Emplacement: </label>
                                                <div class="form-group">
                                                    <main class="cd__main" style="display: none;">
        
                                                    </main>
                                                    <input type="hidden" name="x">
                                                    <input type="hidden" name="y">
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
                                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
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
                                                <label>Place Parking: </label>
                                                <div class="form-group">
                                                    <input type="text" name="name" placeholder="Place Parking"
                                                        class="form-control">
                                                </div>
                                                <label>Numero: </label>
                                                <div class="form-group">
                                                    <input type="text" name="number" placeholder="Numero"
                                                        class="form-control">
                                                </div>
                                                <label>Emplacement: </label>
                                                <div class="form-group">
                                                    <main class="cd__main editHotspot" style="display: none;">
        
                                                    </main>
                                                    <input type="hidden" name="x">
                                                    <input type="hidden" name="y">
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
        const data = @json($residences);
        const etageData = @json($etage);
        const selectEtages = document.getElementById('residencesAdd')
        const selectEtagesEdit = document.getElementById('residencesEdit')
        const addSelect = document.getElementById('addetage')
        const etagesSelectEdit = document.getElementById('editetage')
        const listApparts = document.getElementById('appartAdd');
        selectEtages.value = etageData.residence_id;
        loadEtages(selectEtages.value, 'addetage');
        loadImage(etageData.residence_id);
        const selectApparts = document.getElementById('addetage');
        loadApparts(selectApparts.value, 'appartAdd');
        getDetailsAppart(listApparts.value, 'clientAdd')

        selectEtages.addEventListener('change', (e) => {
            const id = e.target.value

            loadEtages(id, 'addetage')
            const selectApparts = document.getElementById('addetage');
            loadImage(id);
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

        selectEtagesEdit.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'editetage')
            loadImageEdit(id, e.id);
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

        function loadImage(id) {
            const main = document.querySelector('.cd__main');


            axios.get("{{ route('etages.soussol', 5) }}".replace('5', id)).then((reponse) => {
                const etage = reponse.data;
                const w = 900;

                if (etage.hplan != 'undefined' && etage.wplan != 'undefined') {
                    main.style.display = 'block'
                    main.innerHTML = ''
                    main.classList.add('mt-3')
                    const imageUrl = "{{ route('dashboard') }}" + etage.plan;
                    const div = document.createElement('div');

                    const ratio = etage.wplan / etage.hplan;
                    main.setAttribute('style', 'height: ' + w / ratio +
                        'px; width: ' + w + 'px;');


                    div.classList.add('containerH');

                    const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
                    div.setAttribute('style', "background-image: url('" + path +
                        "'); background-size: cover; height: " + w / ratio + "px; width: " + w + "px;");

                    etage.building.parking.forEach((ap) => {
                        const appart = document.createElement('div');
                        appart.classList.add('hotspot');
                        appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
                        appart.innerHTML = '<div class="icon">P</div><div class="content"><h4>' + ap
                            .name +
                            '</h4><p>' + ap.comments + '</p><a class="btn">Voir</a></div>';
                        const divText = document.createElement('div');
                        let t = ap.y - 10;
                        let l = ap.x - 10;
                        t += 10;
                        l += 12;
                        divText.setAttribute('style', 'top: ' + t + '%; left: ' + l + '%;  ');
                        divText.innerHTML = '<div>' + ap.name + '</div>';
                        divText.classList.add('hotspot-label');
                        div.appendChild(divText);
                        div.appendChild(appart);
                    })
                    main.appendChild(div);
                };
            }).catch((error) => {
                console.log(error)
            })
        }

        function loadImageEdit(id, appart_id) {
            const main = document.querySelector('.editHotspot');
            axios.get("{{ route('etages.soussol', 5) }}".replace('5', id)).then((reponse) => {
                const etage = reponse.data;
                const w = 900;

                if (etage.hplan != 'undefined' && etage.wplan != 'undefined') {
                    main.style.display = 'block'
                    main.innerHTML = ''
                    main.classList.add('mt-3')
                    const imageUrl = "{{ route('dashboard') }}" + etage.plan;
                    const div = document.createElement('div');

                    const ratio = etage.wplan / etage.hplan;
                    main.setAttribute('style', 'height: ' + w / ratio +
                        'px; width: ' + w + 'px;');


                    div.classList.add('containerH');

                    const path = "{{ asset('favicon.ico') }}".replace("favicon.ico", etage.plan)
                    div.setAttribute('style', "background-image: url('" + path +
                        "'); background-size: cover; height: " + w / ratio + "px; width: " + w + "px;");

                    etage.building.parking.forEach((ap) => {
                        const appart = document.createElement('div');
                        appart.classList.add('hotspot');
                        appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
                        appart.innerHTML = '<div class="icon">P</div><div class="content"><h4>' + ap
                            .name +
                            '</h4><p>' + ap.comments + '</p><a class="btn">Voir</a></div>';
                        const divText = document.createElement('div');
                        let t = ap.y - 10;
                        let l = ap.x - 10;
                        t += 10;
                        l += 12;
                        divText.setAttribute('style', 'top: ' + t + '%; left: ' + l + '%;  ');
                        divText.innerHTML = '<div>' + ap.name + '</div>';
                        divText.classList.add('hotspot-label');
                        if (ap.id == appart_id) {
                            appart.classList.add('added');
                            divText.classList.add('added');
                        }
                        div.appendChild(divText);
                        div.appendChild(appart);
                    })
                    main.appendChild(div);
                };
            }).catch((error) => {
                console.log(error)
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

        
        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const form = document.getElementById('formEdit');
                const editButton = target;
                let base = '{{ route('parkings.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const numberInput = form.querySelector('input[name="number"]')
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const etage_idInput = form.querySelector('select[name="etage_id"]')
                const appart_idInput = form.querySelector('select[name="appart_id"]')
                const cleintInput = form.querySelector('input[name="client_id"]')
                const xInput = form.querySelector('input[name="x"]')
                const yInput = form.querySelector('input[name="y"]')

                url = "{{ route('parkings.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;
                    nameInput.value = appart.name;
                    numberInput.value = appart.number;
                    residence_idInput.value = appart.residence_id;
                    xInput.value = appart.x;
                    yInput.value = appart.y;
                    loadEtages(appart.residence_id, 'editetage');
                    loadImageEdit(appart.residence_id, appart.id);
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

        function addHotspot(ap, letter) {
            const appart = document.createElement('div');
            appart.classList.add('hotspot');

            appart.setAttribute('style', 'top: ' + ap.y + '%; left: ' + ap.x + '%;');
            let statut = "";
            let color = "";
            if (ap.client_id == null) {
                statut = "Libre";
                color = "#005841";
            } else {
                statut = "Réservé";
                color = "#850000";
            }

            const link = "{{ route('apparts.show', 5) }}".replace('5', ap.id);
            const ht = document.createElement('div');
            ht.classList.add('icon');
            ht.classList.add('hotspot');
            ht.setAttribute('style', 'background-color: ' + color + ';');
            ht.innerHTML = letter;
            ht.addEventListener('click', function() {
                var parent = this.parentElement;
                parent.classList.toggle('open');
                parent.setAttribute('style', parent.getAttribute('style') +
                    'background-color: ' + color +
                    '; color:white; ');
                var hotspots = document.querySelectorAll('.hotspot.open');
                hotspots.forEach(function(hotspot) {
                    if (hotspot !== parent) {
                        hotspot.classList.remove('open');
                    }
                });
            });
            const content = document.createElement('div');
            content.classList.add('content');
            content.setAttribute('style', 'background-color: ' + color + ';');
            content.innerHTML = '<h4>' + ap.name + '</h4><p>' + statut + '</p>';
            if (letter != "P"){
                content.innerHTML += '<br><p> Prix: '+ap.price+'TND <br>Surface: '+ap.surface +' </p>';    
            }

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
        }

        etage.building.parking.forEach(ap=>addHotspot(ap,"P"));
        // etage.building.cellier.forEach(ap=>addHotspot(ap,"C"));
        // etage.building.garage.forEach(ap=>addHotspot(ap,"G"));

        // create a container having the color codes an explanations
        const container = document.createElement('div');
        container.classList.add('container');
        container.classList.add('d-flex');
        container.classList.add('justify-content-between');
        const textLibre = document.createElement('div');
        textLibre.innerHTML = "Libre";
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

        const textRéservé = document.createElement('div');
        textRéservé.innerHTML = "Réservé";
        const labelRéservé = document.createElement('div');
        labelRéservé.classList.add('icon');
        labelRéservé.classList.add('d-flex');
        labelRéservé.classList.add('justify-content-center');
        labelRéservé.classList.add('align-items-center');
        labelRéservé.classList.add('mx-2');
        labelRéservé.setAttribute('style',
            'background-color: #850000; border-radius: 50% 50%; color: white;width: 30px; height: 30px; overflow: hidden;'
        );
        labelRéservé.innerHTML = "+";
        const divRéservé = document.createElement('div');
        divRéservé.classList.add('d-flex');
        divRéservé.classList.add('justify-content-center');
        divRéservé.classList.add('align-items-center');
        divRéservé.appendChild(labelRéservé)
        divRéservé.appendChild(textRéservé)

        container.appendChild(divLibre)

        container.appendChild(divRéservé)

        container.classList.add('mt-2');


        main.appendChild(div);
        main.appendChild(container);
    </script>
    <script>




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
            // console.log the parent elemnt 


            const containerRect = container[0].getBoundingClientRect();

            const offsetXPercent =
                ((e.clientX - containerRect.left) / containerRect.width) * 100;
            const offsetYPercent =
                ((e.clientY - containerRect.top) / containerRect.height) * 100;



            $('.added').each((index, el) => {
                $(el).remove(); // Remove each element with the class .added
            });
            let nameAppart = $('#nameAdd').val();
            if (container.parent()[0].parentElement.parentElement.parentElement.id == "formEdit") {
                nameAppart = $('#formEdit').find('input[name="name"]').val();
            }
            
            let t = offsetYPercent - 10;
            let l = offsetXPercent - 10;
            t += 9;
            l += 11;
            const newElement = $(
                `<div class='hotspot-label added' style='top: ${t}%; left: ${l}%;'>
                    <div>${nameAppart}</div>
                    </div>
                <div class='hotspot added' style='top: ${offsetYPercent-1}%; left: ${offsetXPercent-1}%;'>
      <div class='icon'>P</div>
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
    </script>
@endsection
