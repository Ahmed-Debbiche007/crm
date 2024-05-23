@extends('welcome')
@section('title', 'Utilisateurs')
@section('styles')
    <link href="{{ asset('dist/css/hotspot/hotspot.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/hotspot/style.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card m-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Utilisateurs</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' >
                                    <thead>
                                        <tr>
                                            <th scope="col">Utilisateur</th>
                                            <th scope="col">Email</th>
                                            <th id="actions" scope="col">Profil</th>
                                            <th id="actions" scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="col-12 d-flex flex-row p-2 justify-content-start">
                                                        <div class="avatar avatar-sm">
                                                            @if ($user->image)
                                                                <img src=" {{ asset('/storage/users/' . $user->image) }}"
                                                                    alt="">
                                                            @else
                                                                <img src="{{ asset('static/1.jpg') }} " alt="">
                                                            @endif
                                                        </div>
                                                        <div class="mx-3 d-flex justify-content-center align-items-center">
                                                            {{ $user->name }} {{ $user->lastName }}</div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if ($user->role == 1)
                                                        Administrateur
                                                    @else
                                                        Visiteur
                                                    @endif
                                                </td>

                                                <td>
                                                    <button id="{{ $user->id }}" class="btn btn-warning edit"
                                                        data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                            data-feather="edit"></i>Modifier</button>
                                                    <button onclick="deleteClient({{ $user->id }})"
                                                        class="btn btn-danger"><i
                                                            data-feather="trash"></i>Supprimer</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <form id="delete" method="POST">
                                    @method('DELETE')
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
                                            <form method="POST" action="{{ route('users.store') }}"
                                                enctype="multipart/form-data" id="formmm">
                                                @csrf
                                                <div class="modal-body">
                                                    <label>Nom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="Nom"
                                                            class="form-control">
                                                    </div>
                                                    <label>Prénom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="lastName" placeholder="Nom"
                                                            class="form-control">
                                                    </div>
                                                    <label>Email: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="email" placeholder="Nom"
                                                            class="form-control">
                                                    </div>

                                                    <label>Role: </label>
                                                    <div class="form-group">
                                                        <select name="role" id="" class="form-control">
                                                            <option value="1">Administrateur</option>
                                                            <option value="0">Visiteur</option>
                                                        </select>
                                                    </div>
                                                    <label>Image: </label>
                                                    <input type="file" name="image" class="multiple-files-filepond">
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
                                                    <label>Nom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="Nom"
                                                            class="form-control">
                                                    </div>
                                                    <label>Prénom: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="lastName" placeholder="Nom"
                                                            class="form-control">
                                                    </div>
                                                    <label>Email: </label>
                                                    <div class="form-group">
                                                        <input type="text" name="email" placeholder="Nom"
                                                            class="form-control">
                                                    </div>

                                                    <label>Role: </label>
                                                    <div class="form-group">
                                                        <select name="role" id="" class="form-control">
                                                            <option value="1">Administrateur</option>
                                                            <option value="0">Visiteur</option>
                                                        </select>
                                                    </div>
                                                    <label>Image: </label>
                                                    <input type="file" name="image" class="multiple-files-filepond">
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





    <script src="{{ asset('dist/js/DataTables/datatables.js') }}"></script>
    <script src="{{ asset('dist/js/vendors.js') }}"></script>



    <script>
        FilePond.create(document.querySelector(".multiple-files-filepond"), {
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowMultiple: false,
            required: false,
            storeAsFile: true,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
        });



        function deleteClient(id) {
            var form = document.getElementById('delete');
            let base = "{{ route('users.destroy', '5') }}";
            base = base.replace('5', id);
            form.action = base;
            form.submit();
        }

        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const form = document.getElementById('formEdit');
                const editButton = target;
                const id = editButton.id;
                let base = "{{ route('users.update', '5') }}".replace('5', id);
                const nameInput = form.querySelector('input[name="name"]');
                const lastNameInput = form.querySelector('input[name="lastName"]');
                const emailInput = form.querySelector('input[name="email"]');
                const roleInput = form.querySelector('select[name="role"]');
                const imageInput = form.querySelector('input[name="image"]');
                const options = {
                    credits: null,
                    allowImagePreview: true,
                    allowImageFilter: false,
                    allowImageExifOrientation: false,
                    allowMultiple: false,
                    required: false,
                    storeAsFile: true,
                    acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
                    labelIdle: `<span class="text-primary">Choisir une image ou <span class="filepond--label-action text-primary" >Browse</span></span>`,
                }
                axios.get(base).then((response) => {
                    const user = response.data;
                    nameInput.value = user.name;
                    lastNameInput.value = user.lastName;
                    emailInput.value = user.email;
                    roleInput.value = user.role;
                    if (user.image) {
                        options.files = [{
                            source: "{{ route('dashboard') }}/storage/users/" + user.image,
                        }];
                    }
                    FilePond.create(imageInput, options);
                    form.action = "{{ route('users.update', '5') }}".replace('5', id);
                });
            }
        });
    </script>
@endsection
