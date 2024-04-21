@extends('welcome')
@section('title', 'Règlements')
@section('styles')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card m-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Abonnements</h5>

                            </div>

                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Année</th>
                                            <th scope="col">Bien Immobilier</th>
                                            <th scope="col">Client</th>
                                            <th scope="col">Restant</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($abonnements as $abonnement)
                                            <tr>
                                                @php
                                                    $date = new DateTime($abonnement->date);
                                                @endphp
                                                <td id="{{ $abonnement->id }}">{{ $date->format('Y') }}</td>
                                                <td>{{ $abonnement->appart->name }}</td>
                                                <td>{{ $abonnement->appart->client?->lastName }}
                                                    {{ $abonnement->appart->client?->name }}</td>
                                                <td>{{ $abonnement->amount - $abonnement->reglements->sum('amount') }}</td>


                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3 m-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Règlements</h5>
                                @if (Auth::user()->role == 1)
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                        class="btn btn-primary">Ajouter</button>
                                @endif
                            </div>

                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Montant</th>

                                            @if (Auth::user()->role == 1)
                                                <th scope="col" class="noExport">Actions</th>
                                            @endif

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($abonnements as $abonnement)
                                            @foreach ($abonnement->reglements as $reglement)
                                                <tr>

                                                    <td id="{{ $reglement->id }}">{{ $reglement->date }}</td>
                                                    <td>{{ $reglement->amount }}</td>

                                                    @if (Auth::user()->role == 1)
                                                        <td>

                                                            <div class="d-flex">
                                                                <button id="{{ $reglement->id }}"
                                                                    class="btn btn-warning edit m-1" data-bs-toggle="modal"
                                                                    data-bs-target="#inlineFormEdit"><i
                                                                        data-feather="edit"></i>Modifier</button>

                                                                <form method="GET"
                                                                    action="{{ route('reglements.destroy', $reglement->id) }}">
                                                                    @csrf
                                                                    <button type="button" class="btn btn-danger m-1"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#inlineChargeDelete{{ $reglement->id }}"><i
                                                                            data-feather="trash"></i>Supprimer</button>
                                                                    <div class="modal fade"
                                                                        id="inlineChargeDelete{{ $reglement->id }}"
                                                                        tabindex="-1" role="dialog"
                                                                        aria-labelledby="exampleModalLabel"
                                                                        aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        id="exampleModalLabel">
                                                                                        Confirmation</h5>
                                                                                    <button type="button" class="close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Êtes-vous sûr de vouloir supprimer ?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">Annuler</button>
                                                                                    <button id="deleteButton" type="submit"
                                                                                        class="btn btn-danger">Confirmer</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
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
                        <form method="POST" action="{{ route('abonnements.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">


                                <input name="appart_id" type="hidden" id="appartAdd" class="form-control"
                                    value="{{ $abonnements[0]->appart_id }}" />
                                <input name="abonnement_id" type="hidden" id="appartAdd" class="form-control"
                                    value="{{ $abonnements[0]->id }}" />

                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Numero" class="form-control" value="{{$abonnements[0]->date}}">
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input type="text" name="amount" placeholder="Montant" class="form-control">
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


                                <input name="appart_id" type="hidden" id="appartAdd" class="form-control"
                                    value="{{ $abonnements[0]->appart_id }}" />

                                <input name="abonnement_id" type="hidden" id="appartAdd" class="form-control"
                                    value="{{ $abonnements[0]->id }}" />
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="date" name="date" placeholder="Numero" class="form-control">
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input type="text" name="amount" placeholder="Montant" class="form-control">
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
        const data = @json($residences);
        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const editButton = target;
                const form = document.getElementById('formEdit');

                let base = '{{ route('reglements.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const dateInput = form.querySelector('input[name="date"]');
                const amountInput = form.querySelector('input[name="amount"]');

                url = "{{ route('reglements.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const appart = reponse.data;

                    dateInput.value = appart.date;
                    amountInput.value = appart.amount;
                }).catch((error) => {
                    console.log(error)
                })
            };
        })
    </script>
@endsection
