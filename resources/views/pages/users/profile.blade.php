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
                                <h5 class="card-title">Profile</h5>

                            </div>
                            
                                <form method="POST" action="{{route('users.update',$user->id)}}" id="formEdit" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Nom: </label>
                                                <div class="form-group">
                                                    <input type="text" name="name" value="{{ $user->name }}"
                                                        placeholder="Nom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label>Prénom: </label>
                                                <div class="form-group">
                                                    <input type="text" name="lastName" value="{{ $user->lastName }}"
                                                        placeholder="Prénom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label>Email: </label>
                                                <div class="form-group">
                                                    <input type="text" name="email" value="{{ $user->email }}"
                                                        placeholder="Nom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label>Role: </label>
                                                <div class="form-group">
                                                    <select name="role" id="" class="form-control">
                                                        <option value="1"
                                                            @if ($user->role == 1) selected @endif>Administrateur
                                                        </option>
                                                        <option value="0"
                                                            @if ($user->role == 0) selected @endif>Visiteur
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <label>Image: </label>
                                        <input type="file" name="image" class="multiple-files-filepond">
                                    </div>
                                    <div class="modal-footer">

                                        <button type="submit" class="btn btn-primary ml-1">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block text-white">Modifier</span>
                                        </button>
                                    </div>
                                </form>
                           
                        </div>
                    </div>

                    <div class="card m-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Mot de passe</h5>

                            </div>
                           
                                <form method="POST" action="{{route('users.updatePassword',$user->id)}}" id="formEdit" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Ancien Mot de passe: </label>
                                                <div class="form-group">
                                                    <input type="password" name="old"
                                                        placeholder="Nom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label>Nouveau Mot de passe: </label>
                                                <div class="form-group">
                                                    <input type="password" name="new"
                                                        placeholder="Prénom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <label>Répéter nouveau mot de passe: </label>
                                                <div class="form-group">
                                                    <input type="password" name="new_confirmation"
                                                        placeholder="Nom" class="form-control">
                                                </div>
                                            </div>
                                            
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
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
@endsection

@section('scripts')





    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="{{ asset('dist/js/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dist/js/vendors.js') }}"></script>



    <script>
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
        
        @if ($user->image)
        options.files = [{
            source: '{{ asset('storage/users/' . $user->image) }}'
        }]
        @endif
        FilePond.create(document.querySelector(".multiple-files-filepond"), options);
    </script>
@endsection
