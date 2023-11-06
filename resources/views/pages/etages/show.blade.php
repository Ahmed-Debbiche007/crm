@extends('welcome')
@section('title', 'Etages')
@section('styles')

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
                    <img src="{{ asset($etage->plan) }}" alt="" class="m-3"
                        style="height: 500px; object-fit: contain;">
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
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('apparts.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Nom: </label>
                                                    <div class="form-group">
                                                        <input  type="text" name="name" placeholder="Nom"
                                                            class="form-control">
                                                    </div>

                                                    <input type="hidden" name="residence_id" class="form-control"
                                                        value="{{ $etage->residence_id }}">

                                                    <input type="hidden" name="etage_id" value="{{ $etage->id }}"
                                                        class="form-control">

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
                                                    <i data-feather="x"></i>
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
                                                    <input type="hidden" name="residence_id" class="form-control"
                                                        value="{{ $etage->residence_id }}">

                                                    <input type="hidden" name="etage_id" value="{{ $etage->id }}"
                                                        class="form-control">
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
                                                            <option value="">--</option>                                                            @foreach ($clients as $client)
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
                                    <i data-feather="x"></i>
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
    <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/vendors.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        

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
                    
                    nameInput.value = appart.name
                    surfaceInput.value = appart.surface
                    typeInput.value = appart.type
                    priceInput.value = appart.price
                    client_idInput.value = appart.client_id
                    bsInput.value = appart.bs
                    commentsInput.value = appart.comments

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
    </script>
@endsection
