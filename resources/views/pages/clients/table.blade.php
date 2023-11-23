@extends('welcome')
@section('title', 'Clients')
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
                                <h5 class="card-title">Clients</h5>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                    class="btn btn-primary">Ajouter</button>
                            </div>
                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Prénom</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Numéro de téléphone</th>
                                            <th scope="col">CIN</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Date Réservation</th>
                                            <th scope="col">Commentaires</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td>{{ $client->name }}</td>
                                                <td>{{ $client->lastName }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->phone }}</td>
                                                <td>{{ $client->cin }}</td>
                                                <td>
                                                    @if ($client->type == 0)
                                                        Client
                                                    @else
                                                        Prospect
                                                    @endif
                                                </td>
                                                <td>{{ $client->date_res }}</td>
                                                <td>{{ $client->comments }}</td>
                                                <td>
                                                    <button id="{{ $client->id }}" class="btn btn-warning edit"
                                                        data-bs-toggle="modal" data-bs-target="#inlineFormEdit"><i
                                                            data-feather="edit"></i>Modifier</button>
                                                    <button onclick="deleteClient({{ $client->id }})"
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
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('clients.store') }}">
                            @csrf
                            <div class="modal-body">
                                <label>Nom: </label>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Nom" class="form-control">
                                </div>
                                <label>Prenom: </label>
                                <div class="form-group">
                                    <input type="text" name="lastName" placeholder="Prénom" class="form-control">
                                </div>
                                <label>Numéro de téléphone: </label>
                                <div class="form-group">
                                    <input type="text" name="phone" placeholder="Numéro de téléphone"
                                        class="form-control">
                                </div>
                                <label>Numéro CIN: </label>
                                <div class="form-group">
                                    <input type="text" name="cin" placeholder="Numéro CIN" class="form-control">
                                </div>
                                <label>Email: </label>
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Email" class="form-control">
                                </div>
                                <label>Type: </label>
                                <div class="form-group">
                                    <select name="type" id="" class="form-control">
                                        <option value="0">Client</option>
                                        <option value="1">Prospect</option>
                                    </select>
                                </div>
                                <label>Date Réservation: </label>
                                <div class="form-group">
                                    <input type="date" name="date_res" placeholder="Numéro CIN" class="form-control">
                                </div>
                                <label>Commentaires: </label>
                                <div class="form-group">
                                    <textarea name="comments" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
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
                aria-labelledby="myModalLabel44" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Modifier </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
</svg>
                            </button>
                        </div>
                        <form id="editForm" method="POST" action="{{ route('clients.store') }}">
                            @csrf
                            <div class="modal-body">
                                <label>Nom: </label>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Nom" class="form-control">
                                </div>
                                <label>Prenom: </label>
                                <div class="form-group">
                                    <input type="text" name="lastName" placeholder="Prénom" class="form-control">
                                </div>
                                <label>Numéro de téléphone: </label>
                                <div class="form-group">
                                    <input type="text" name="phone" placeholder="Numéro de téléphone"
                                        class="form-control">
                                </div>
                                <label>Numéro CIN: </label>
                                <div class="form-group">
                                    <input type="text" name="cin" placeholder="Numéro CIN" class="form-control">
                                </div>
                                <label>Email: </label>
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Email" class="form-control">
                                </div>
                                <label>Type: </label>
                                <div class="form-group">
                                    <select name="type" id="" class="form-control">
                                        <option value="0">Client</option>
                                        <option value="1">Prospect</option>
                                    </select>
                                </div>
                                <label>Date Réservation: </label>
                                <div class="form-group">
                                    <input type="date" name="date_res" placeholder="Numéro CIN" class="form-control">
                                </div>
                                <label>Commentaires: </label>
                                <div class="form-group">
                                    <textarea name="comments" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="edit" class="btn btn-light-secondary"
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
            let base = '{{ route('clients.destroy', '5') }}';
            base = base.replace('5', id);
            form.action = base;
            form.method = 'DELETE';
            form.submit();
        }

        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        editButtons.forEach((editButton) => {
            editButton.addEventListener('click', function() {
                const form = document.getElementById('editForm');
                
                let base = '{{ route('clients.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const nameInput = form.querySelector('input[name="name"]');
                const lastNameInput = form.querySelector('input[name="lastName"]');
                const phoneInput = form.querySelector('input[name="phone"]');
                const cinInput = form.querySelector('input[name="cin"]');
                const emailInput = form.querySelector('input[name="email"]');
                const resInput = form.querySelector('input[name="date_res"]');
                const typeInput = form.querySelector('select[name="type"]');
                const commentsArea = form.querySelector('textarea[name="comments"]');
                url = "{{ route('clients.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const client = reponse.data;
                    nameInput.value = client.name;
                    lastNameInput.value = client.lastName;
                    phoneInput.value = client.phone;
                    cinInput.value = client.cin;
                    emailInput.value = client.email;
                    resInput.value = client.date_res;
                    typeInput.value = client.type;
                    commentsArea.innerHTML = client.comments
                }).catch((error) => {
                    console.log(error)
                })
            });
        })
    </script>
@endsection
