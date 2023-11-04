@extends('welcome')
@section('title', 'Appartements')
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
                                                <td>{{ $appart->etage->number }}</td>
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
                                                <td>
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
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('apparts.store') }}">
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
                                                            <option>--</option>
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
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form method="POST" id="formEdit">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Nom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="Nom"
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
                                                            <option>--</option>
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
    <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/vendors.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        const selectEtages = document.getElementById('residencesAdd')
        const selectEtagesEdit = document.getElementById('residencesEdit')
        loadEtages(selectEtages.value, 'addetage');
        selectEtages.addEventListener('change', (e) => {
            const id = e.target.value

            loadEtages(id, 'addetage')
        })

        selectEtagesEdit.addEventListener('change', (e) => {
            const id = e.target.value

            loadEtages(id, 'editetage')
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
                        option.innerHTML = e.number
                        selectEtage.appendChild(option)
                    })
                }
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
        editButtons.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEdit');

                let base = '{{ route('apparts.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const etage_idInput = form.querySelector('select[name="etage_id"]')
                const surfaceInput = form.querySelector('input[name="surface"]')
                const typeInput = form.querySelector('select[name="type"]')
                const priceInput = form.querySelector('input[name="price"]')
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
                                etage_idInput.value = e.id
                            }
                        })
                    })
                    nameInput.value = appart.name
                    surfaceInput.value = appart.surface
                    typeInput.value = appart.type
                    priceInput.value = appart.price
                    client_idInput.value = appart.client_id
                    bsInput.value = appart.bs
                    commentsInput.value = appart.comments
                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
@endsection
