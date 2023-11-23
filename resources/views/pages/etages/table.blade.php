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
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Residence</th>
                                            <th scope="col">Numero</th>
                                            <th scope="col">Appartements</th>
                                            <th scope="col">Charges</th>
                                            <th scope="col">Échanciers</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($etages as $etage)
                                            <tr>
                                                <td>{{ $etage->building->name }}</td>
                                                <td>{{ $etage->name }}</td>
                                                <td> <a href="{{ route('apparts') }}?etage={{ $etage->id }}"
                                                        class="badge bg-success">Appartements</a> </td>
                                                <td> <a href="{{ route('charges') }}?etage={{ $etage->id }}"
                                                        class="badge bg-success">Charges</a> </td>
                                                <td> <a href="{{ route('echances') }}?etage={{ $etage->id }}"
                                                        class="badge bg-success">Échanciers</a> </td>
                                                <td>
                                                    <a href="{{ route('etages.show', $etage->id) }}"
                                                        class="btn btn-primary"><i
                                                            data-feather="plus-circle"></i>Details</a>
                                                    <button id="{{ $etage->id }}" class="btn btn-warning edit"
                                                        data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                            data-feather="edit"></i>Modifier</button>
                                                    <button onclick="deleteClient({{ $etage->id }})"
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
                                <div class="modal fade text-left " id="inlineForm" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel33" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                                                </button>
                                            </div>
                                            <form method="POST" action="{{ route('etages.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Residence: </label>
                                                    <div class="form-group">
                                                        <select name="residence_id" class="form-control">
                                                            @foreach ($residences as $residence)
                                                                <option value="{{ $residence->id }}">
                                                                    {{ $residence->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <label>Numero: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="Numero"
                                                            class="form-control">
                                                    </div>
                                                    <label>Plan: </label>
                                                    <input type="file" name="plan" class="image-preview-filepond" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
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
                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
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
                                                        <input type="text" name="name" placeholder="Numero"
                                                            class="form-control">
                                                    </div>
                                                    <label>Plan: </label>
                                                    <input type="file" name="plan"
                                                        class="image-preview-filepondEdit" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
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
        editButtons.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEdit');

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
                    FilePond.create(document.querySelector('.image-preview-filepondEdit'), options);
                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
@endsection
