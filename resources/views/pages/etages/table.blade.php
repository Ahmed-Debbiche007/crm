@extends('welcome')
@section('title', 'Etages')
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
                                <h5 class="card-title">Etages</h5>
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
                                            <th scope="col">Numero</th>
                                            <th scope="col" class="noExport">Biens Immobiliers</th>
                                            <th scope="col" class="noExport">Charges</th>
                                            <th scope="col" class="noExport">Échanciers</th>
                                            <th scope="col" class="noExport">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($etages as $etage)
                                            <tr>
                                                <td id="{{ $etage->building->id }}">{{ $etage->building->name }}</td>
                                                <td>{{ $etage->name }}</td>
                                                <td> <a href="{{ route('apparts') }}?etage={{ $etage->id }}"
                                                        class="badge bg-success">Biens Immobiliers</a> </td>
                                                <td> <a href="{{ route('charges') }}?etage={{ $etage->id }}"
                                                        class="badge bg-success">Charges</a> </td>
                                                <td> <a href="{{ route('echances') }}?etage={{ $etage->id }}"
                                                        class="badge bg-success">Échanciers</a> </td>
                                                <td>
                                                    <a href="{{ route('etages.show', $etage->id) }}"
                                                        class="btn btn-primary"><i
                                                            data-feather="plus-circle"></i>Details</a>
                                                    @if (Auth::user()->role == 1)
                                                        <button id="{{ $etage->id }}" class="btn btn-warning edit"
                                                            data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                                data-feather="edit"></i>Modifier</button>

                                                        <form method="GET"
                                                            action="{{ route('etages.destroy', $etage->id) }}">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger m-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#inlineChargeDelete{{ $etage->id }}"><i
                                                                    data-feather="trash"></i>Supprimer</button>
                                                            <div class="modal fade"
                                                                id="inlineChargeDelete{{ $etage->id }}" tabindex="-1"
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
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form id="delete" action="#">
                                    @csrf

                                </form>
                                <div class="modal fade text-left " id="inlineForm" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
                                            <form method="POST" action="{{ route('etages.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Residence: </label>
                                                    <div class="form-group">
                                                        <select name="residence_id" id="selectResidences"
                                                            class="form-control">
                                                            @foreach ($residences as $residence)
                                                                <option value="{{ $residence->id }}">
                                                                    {{ $residence->name }}
                                                                </option>
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
                                                    <input type="file" name="plan"
                                                        class="image-preview-filepond" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        
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
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                        role="document">
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
                                            <form id="formEdit" method="POST" enctype="multipart/form-data">

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
                                                    <input type="file" name="plan"
                                                        class="image-preview-filepondEdit" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        
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
        function deleteClient(id) {
            var form = document.getElementById('delete');
            let base = "{{ route('etages.destroy', '5') }}";
            base = base.replace('5', id);
            form.action = base;
            form.method = 'DELETE';
            form.submit();
        }

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
        createFileInput(".image-preview-filepond");

        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const form = document.getElementById('formEdit');
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
                    FilePond.create(document.querySelector('.image-preview-filepondEdit'), options);
                }).catch((error) => {
                    console.log(error)
                })
            };
        })

        const resSelect = document.getElementById('resSelect');
        const selectResidences = document.getElementById('selectResidences');
        const resId = window.location.search.split('=')[1];
        if (resId) {
            resSelect.value = resId;
            selectResidences.value = resId;



        } else {
            resSelect.value = 0;
            selectResidences.value = 1;


        }
        resSelect.addEventListener('change', function() {
            if (this.value == 0)
                window.location.href = "{{ route('etages') }}";
            else
                window.location.href = "{{ route('etages') }}" + "?res=" + this.value;
        })
    </script>
@endsection
