@extends('welcome')
@section('title', 'Parkings')
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
                                <h5 class="card-title">Parkings</h5>
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
                                            <th scope="col">Place Parking</th>
                                            <th scope="col">Numéro</th>
                                            <th scope="col">Client</th>
                                            @if (Auth::user()->role == 1)
                                                <th scope="col" class="noExport">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($parkings as $parking)
                                            <tr>
                                                <td id="{{ $parking->residence->id }}">{{ $parking->residence->name }}</td>
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
                                                    <td>

                                                        <div class="d-flex">
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
                                                                    id="inlineChargeDelete{{ $parking->id }}"
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
            <!--End Row-->



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
        const data = @json($residences);
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


        const selectEtages = document.getElementById('residencesAdd')
        const listApparts = document.getElementById('appartAdd');
        loadEtages(selectEtages.value, 'addetage');
        const selectApparts = document.getElementById('addetage');
        loadApparts(selectApparts.value, 'appartAdd');
        getDetailsAppart(listApparts.value, 'clientAdd')
        selectEtages.addEventListener('change', (e) => {
            const id = e.target.value
            loadEtages(id, 'addetage')
            loadImage(id)
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
            loadImageEdit(id, e.id)
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
                window.location.href = "{{ route('parkings') }}";
            else
                window.location.href = "{{ route('parkings') }}" + "?res=" + this.value;
        })
    </script>
@endsection
