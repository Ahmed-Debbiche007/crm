@extends('welcome')
@section('title', 'Résidences')
@section('styles')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="mt-3">
                <h5 class="card-title">Residence: {{ $residence->name }}</h5>
                <h5 class="card-title">Adresse: {{ $residence->address }}</h5>
                <h5 class="card-title">N° du titre Foncier: {{ $residence->nfoncier }}</h5>
                <h5 class="card-title">Emplacement: {{ $residence->emplacemnt }}</h5>
                <h5 class="card-title">N° du permis de bâtir: {{ $residence->npermis }}</h5>
                <h5 class="card-title">Détail Municipalité: {{ $residence->detailMunicipal }}</h5>
                <h5 class="card-title">Détails Résidence: <a href="{{asset($residence->detail)}}" target="_blank" download class="btn btn-primary mb-1 mt-1"><i data-feather="download"></i> Télécharger</a></h5>
                <h5 class="card-title">Gallery:</h5>
                @if ($residence->image && count($residence->image) > 0)

                    <div id="carouselExample" class="carousel slide m-3">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset($residence->image[0]->path) }}" class="d-block w-100"
                                    style="height: 500px; object-fit: contain;">
                            </div>
                            @foreach ($residence->image as $key => $image)
                                @if ($key > 0)
                                    <div class="carousel-item">
                                        <img src="{{ asset($image->path) }}" class="d-block w-100"
                                            style="height: 500px; object-fit: contain;">
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @else
                    <h6 class="card-title ml-5">Pas de photos</h6>
                @endif
                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineResEdit" id="resEd"
                    class="btn btn-primary mb-1 mt-1">Modifier</button>
                <h5 class="card-title">Étages:</h5>
                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineEtage" id="resEd"
                    class="btn btn-primary mb-1 mt-1">Ajouter</button>
                <div class="row">
                    @foreach ($residence->etage as $etage)
                        <div class="card m-3">
                            <div class="card-header">
                                <div class="d-flex justify-items-between">
                                    <h5 class="card-title">{{ $etage->name }}</h5>
                                    <a href="{{ route('etages.show', $etage->id) }}"
                                        class="btn btn-primary ml-auto">Details</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset($etage->plan) }}" height="300px" alt="">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-3">
                            <h5 class="card-title">Parkings</h5>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                class="btn btn-primary">Ajouter</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>

                                        <th scope="col">Place Parking</th>
                                        <th scope="col">Numéro</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residence->parking as $parking)
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
                                            <td>

                                                <div class="d-flex">
                                                    <button id="{{ $parking->id }}" class="btn btn-warning edit m-1"
                                                        data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                            data-feather="editCellier"></i>Modifier</button>
                                                    <form method="GET"
                                                        action="{{ route('parkings.destroy', $parking->id) }}">
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

                <div class="modal fade text-left " id="inlineEtage" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('etages.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="residence_id" value={{ $residence->id }}>
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

                <div class="modal fade text-left " id="cellier" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel33" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('celliers.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
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
                <div class="modal fade text-left " id="cellierEdit" tabindex="-1" role="dialog"
                    aria-labelledby="myModalLabel44" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                                </button>
                            </div>
                            <form id="formEdit" method="POST" enctype="multipart/form-data">

                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                                    <label>Numero: </label>
                                    <div class="form-group">
                                        <input type="text" name="name" placeholder="Numero" class="form-control">
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

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between m-3">
                            <h5 class="card-title">Celliers</h5>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#cellier"
                                class="btn btn-primary">Ajouter</button>
                        </div>
                        <div class="table-responsive">
                            <table class='table table-striped' id="table1">
                                <thead>
                                    <tr>

                                        <th scope="col">Numéro</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($residence->cellier as $cellier)
                                        <tr>

                                            <td>{{ $cellier->name }}</td>
                                            <td>
                                                @if ($cellier->client)
                                                    {{ $cellier->client->name }} {{ $cellier->client->lastName }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>

                                                <div class="d-flex">
                                                    <button id="{{ $cellier->id }}"
                                                        class="btn btn-warning editCellier m-1" data-bs-toggle="modal"
                                                        data-bs-target="#cellierEdit"><i
                                                            data-feather="edit"></i>Modifier</button>
                                                    <form method="GET"
                                                        action="{{ route('celliers.destroy', $cellier->id) }}">
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
            <!--End Row-->
            <div class="modal fade text-left " id="inlineForm" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('parkings.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                                <label>Place Parking: </label>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Numero" class="form-control">
                                </div>
                                <label>Numero: </label>
                                <div class="form-group">
                                    <input type="text" name="number" placeholder="Numero" class="form-control">
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
                            <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                            </button>
                        </div>
                        <form id="formEditParking" method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="modal-body">
                                <input type="hidden" value="{{ $residence->id }}" name="residence_id">
                                <label>Place Parking: </label>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Numero" class="form-control">
                                </div>
                                <label>Numero: </label>
                                <div class="form-group">
                                    <input type="text" name="number" placeholder="Numero" class="form-control">
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

            <div class="modal fade text-left " id="inlineResEdit" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel44" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="card-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                            </button>
                        </div>
                        <form id="resEdit" method="POST" action="{{ route('residences.update', $residence->id) }}"
                            enctype="multipart/form-data">

                            @csrf
                            <div class="modal-body">
                                <label>Nom de la résidence: </label>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Nom de la résidence"
                                        class="form-control">
                                </div>
                                <label>Addresse: </label>
                                <div class="form-group">
                                    <input type="text" name="address" placeholder="Addresse" class="form-control">
                                </div>

                                <label>N° du titre Foncier: </label>
                                <div class="form-group">
                                    <input type="text" name="nfoncier" placeholder="N° du titre Foncier"
                                        class="form-control">
                                </div>

                                <label>Emplacement: </label>
                                <div class="form-group">
                                    <input type="text" name="emplacemnt" placeholder="Emplacement"
                                        class="form-control">
                                </div>

                                <label>N° du permis de bâtir: </label>
                                <div class="form-group">
                                    <input type="text" name="npermis" placeholder="N° du permis de bâtir"
                                        class="form-control">
                                </div>

                                <label>Détail Municipalité: </label>
                                <div class="form-group">
                                    <input type="text" name="detailMunicipal" placeholder="Détail Municipalité"
                                        class="form-control">
                                </div>
                                <label>Detail Résidence </label>
                                <input type="file" name="details" class="image-preview-filepondEdit" />

                                <label>Gallery </label>
                                <input type="file" name="gallery[]" class="multiple-files-filepondEdit" multiple>
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
        const editButtons = document.getElementsByClassName('editCellier');
        editButtons.forEach = Array.prototype.forEach;
        editButtons.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEdit');

                let base = '{{ route('celliers.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const cleintInput = form.querySelector('select[name="client_id"]')

                url = "{{ route('celliers.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;

                    nameInput.value = appart.name;
                    cleintInput.value = appart.client_id;

                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>

    <script>
        const editButtonsParking = document.getElementsByClassName('edit');
        editButtonsParking.forEach = Array.prototype.forEach;
        editButtonsParking.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEditParking');

                let base = '{{ route('parkings.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const numberInput = form.querySelector('input[name="number"]')
                const cleintInput = form.querySelector('select[name="client_id"]')

                url = "{{ route('parkings.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;
                    nameInput.value = appart.name;
                    numberInput.value = appart.number;
                    cleintInput.value = appart.client_id;

                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
    <script>
        const forms = document.querySelectorAll('form');

        forms.forEach((form) => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                if (form.method != 'get') {
                    fetch(form.action, {
                            method: form.method,
                            body: formData,
                        })
                        .then((response) => {
                            window.location.reload();
                        })
                        .catch((error) => {
                            console.error('An error occurred:', error);
                        });
                } else {
                    axios.get(form.action).then((reponse) => {
                        window.location.reload();
                    }).catch((error) => {
                        console.log(error)
                    })
                }
            });
        });
    </script>
    <script>
        const editButtonsRes = document.getElementById('resEd');


        editButtonsRes.addEventListener('click', function() {
            const form = document.getElementById('resEdit');



            const nameInput = form.querySelector('input[name="name"]');
            const adressInput = form.querySelector('input[name="address"]');
            const nfoncierInput = form.querySelector('input[name="nfoncier"]');
            const emplacemntInput = form.querySelector('input[name="emplacemnt"]');
            const npermisInput = form.querySelector('input[name="npermis"]');
            const detailMunicipalInput = form.querySelector('input[name="detailMunicipal"]');
            url = "{{ route('residences.get', 5) }}";
            url = url.replace('5', '{{ $residence->id }}');
            axios.get(url).then((reponse) => {
                const residence = reponse.data;
                nameInput.value = residence.name;
                adressInput.value = residence.address;
                nfoncierInput.value = residence.nfoncier;
                emplacemntInput.value = residence.emplacemnt;
                npermisInput.value = residence.npermis;
                detailMunicipalInput.value = residence.detailMunicipal;
                const options2 = {
                        credits: null,
                        allowImagePreview: false,
                        allowMultiple: false,
                        allowFileEncode: false,
                        required: false,
                        storeAsFile: true,
                        labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
                        labelButtonDownloadItem: "Télécharger",
                        allowDrop: false,
                        allowBrowse: false,
                        allowPaste: false,
                    }
                    if (residence.detail) {
                        options2.files = [{
                            source: '{{ route('dashboard') }}/' + residence.detail
                        }]
                    }
                    FilePond.create(document.querySelector('.image-preview-filepondEdit'),
                        options2);


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
                    labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action">Browse</span></span>`,
                }
                if (residence.image) {
                    const files = []
                    residence.image.forEach((img) => {

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

        function createFileInput(className) {
            FilePond.create(document.querySelector(className), {
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
            });
        }
        createFileInput(".image-preview-filepondEtage");
    </script>
@endsection
