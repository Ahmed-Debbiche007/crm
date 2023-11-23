@extends('welcome')
@section('title', 'Celliers')
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
                                <h5 class="card-title">Celliers</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Residence</th>
                                            <th scope="col">Numéro</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($celliers as $cellier)
                                            <tr>
                                                <td>{{ $cellier->residence->name }}</td>
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
                                                        <button id="{{ $cellier->id }}" class="btn btn-warning edit m-1"
                                                            data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
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

            </div>
            <!--End Row-->

            <div class="modal fade text-left " id="inlineForm" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Ajouter </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('celliers.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <label>Residence: </label>
                                <div class="form-group">
                                    <select name="residence_id" class="form-control">
                                        @foreach ($residences as $residence)
                                            <option value="{{ $residence->id }}">{{ $residence->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
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
            <div class="modal fade text-left " id="inlineFormEdit" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel44" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Modifier </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                    <span class="d-none d-sm-block text-white">Modifier</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        editButtons.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('formEdit');

                let base = '{{ route('celliers.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]')
                const residence_idInput = form.querySelector('select[name="residence_id"]')
                const cleintInput = form.querySelector('select[name="client_id"]')
               
                url = "{{ route('celliers.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;
                    const data = @json($residences);
                    nameInput.value =  appart.name;
                    residence_idInput.value = appart.residence_id;
                    cleintInput.value = appart.client_id; 
                    
                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
@endsection
