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
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Adresse</th>
                                            <th scope="col">Étages</th>
                                            <th scope="col">Appartements</th>
                                            <th scope="col">Parkings</th>
                                            <th scope="col">Celliers</th>
                                            <th scope="col">Charges</th>
                                            <th scope="col">Échanciers</th>
                                            <th scope="col">Actions</th>
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
                                                        class="badge bg-success">Appartements</a> </td>
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
                                                        class="btn btn-primary edit" ><i
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
                                <i data-feather="x"></i>
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
                            <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
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
    <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/vendors.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
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

        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        editButtons.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEdit');

                let base = "{{ route('residences.update', '5') }}";
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]');
                const adressInput = form.querySelector('input[name="address"]');
                url = "{{ route('residences.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const residence = reponse.data;
                    nameInput.value = residence.name;
                    adressInput.value = residence.address;
                    console.log(residence.image)
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

                    FilePond.create(document.querySelector(".multiple-files-filepondEdit"),
                        options);


                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
@endsection
