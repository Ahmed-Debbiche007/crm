@extends('welcome')
@section('title', 'Résidences')
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
                                <h5 class="card-title">Residences</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive" >
                                <table class='table table-striped' id="table1" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Adresse</th>

                                            <th scope="col" class="noExport">Étages</th>
                                            <th scope="col" class="noExport">Biens Immobiliers</th>
                                            <th scope="col" class="noExport">Parkings</th>
                                            <th scope="col" class="noExport">Celliers</th>
                                            <th scope="col" class="noExport">Charges</th>
                                            <th scope="col" class="noExport">Échanciers</th>

                                            <th scope="col" class="noExport">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($residences as $residence)
                                            <tr>
                                                <td>{{ $residence->name }}</td>
                                                <td>{{ $residence->address }}</td>


                                                <td> <a href="{{ route('etages') }}?res={{ $residence->id }}"
                                                        class="badge bg-success">Étages</a> </td>
                                                <td> <a href="{{ route('apparts') }}?res={{ $residence->id }}"
                                                        class="badge bg-success">Biens Immobiliers</a> </td>
                                                <td> <a href="{{ route('parkings') }}?res={{ $residence->id }}"
                                                        class="badge bg-success">Parkings</a> </td>
                                                <td> <a href="{{ route('celliers') }}?res={{ $residence->id }}"
                                                        class="badge bg-success">Celliers</a> </td>
                                                <td> <a href="{{ route('charges') }}?res={{ $residence->id }}"
                                                        class="badge bg-success">Charges</a> </td>
                                                <td> <a href="{{ route('echances') }}?res={{ $residence->id }}"
                                                        class="badge bg-success">Échanciers</a> </td>

                                                <td>
                                                    <a href="{{ route('residences.show', $residence->id) }}"
                                                        class="btn btn-primary edit"><i
                                                            data-feather="plus-circle"></i>Details</a>
                                                    <button id="{{ $residence->id }}" class="btn btn-warning edit"
                                                        data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                            data-feather="edit"></i>Modifier</button>
                                                    <button onclick="deleteClient({{ $residence->id }})"
                                                        class="btn btn-danger"><i
                                                            data-feather="trash"></i>Supprimer</button>
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
                        <form method="POST" action="{{ route('residences.store') }}" enctype="multipart/form-data">
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
                                    <input type="text" name="emplacemnt" placeholder="Emplacement" class="form-control">
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
                                <input type="file" name="details[]" class="image-preview-filepond" multiple />


                                <label>Gallery </label>
                                <input type="file" name="gallery[]" class="multiple-files-filepond" multiple>
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
                        <form id="formEdit" method="POST" action="{{ route('residences.store') }}"
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
                                <input type="file" name="details[]" class="image-preview-filepondEdit" multiple />
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
                                    <span class="d-none d-sm-block text-white">Modifier</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <form id="delete" action="#">
                @csrf

            </form>

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
        function deleteClient(id) {
            var form = document.getElementById('delete');
            let base = "{{ route('residences.destroy', '5') }}";
            base = base.replace('5', id);
            form.action = base;
            form.method = 'DELETE';
            form.submit();
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

        function createFileInput(className) {

            FilePond.create(document.querySelector(className), {
                credits: null,
                allowImagePreview: false ,
                allowImageFilter: false,
                allowImageExifOrientation: false,
                allowMultiple: true,
                required: false,
                storeAsFile: true,
                fileValidateTypeDetectType: (source, type) =>
                    new Promise((resolve, reject) => {
                        resolve(type);
                    }),
                labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`
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
                let base = "{{ route('residences.update', '5') }}";
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]');
                const adressInput = form.querySelector('input[name="address"]');
                const nfoncierInput = form.querySelector('input[name="nfoncier"]');
                const emplacemntInput = form.querySelector('input[name="emplacemnt"]');
                const npermisInput = form.querySelector('input[name="npermis"]');
                const detailMunicipalInput = form.querySelector('input[name="detailMunicipal"]');
                url = "{{ route('residences.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const residence = reponse.data;
                    nameInput.value = residence.name;
                    adressInput.value = residence.address;
                    nfoncierInput.value = residence.nfoncier;
                    emplacemntInput.value = residence.emplacemnt;
                    npermisInput.value = residence.npermis;
                    detailMunicipalInput.value = residence.detailMunicipal;
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
                    if (residence.image) {
                        const files = []
                        residence.image.forEach((img) => {

                            files.push({
                                source: '{{ route('dashboard') }}/' + img.path,
                            })
                        })
                        options.files = files
                    }

                    const options2 = {
                        credits: null,
                        allowImagePreview: false,
                        allowImageFilter: false,
                        allowImageExifOrientation: false,
                        allowMultiple: true,
                        required: false,
                        storeAsFile: true,
                        fileValidateTypeDetectType: (source, type) =>
                            new Promise((resolve, reject) => {
                                resolve(type);
                            }),
                        labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
                    }
                    if (residence.file) {
                        const files = []
                        residence.file.forEach((img) => {

                            files.push({
                                source: '{{ route('dashboard') }}/' + img.path,
                            })
                        })
                        options2.files = files
                    }
                    FilePond.create(document.querySelector('.image-preview-filepondEdit'),
                        options2);

                    FilePond.create(document.querySelector(".multiple-files-filepondEdit"),
                        options);


                }).catch((error) => {
                    console.log(error)
                })
            };
        })
    </script>
@endsection
