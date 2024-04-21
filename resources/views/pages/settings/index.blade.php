@extends('welcome')
@section('title', 'Paramètres')
@section('styles')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card m-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between m-3">
                                <h5 class="card-title">Paramètres</h5>

                            </div>

                            <form id="form" method="POST" action="{{ route('settings.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-1">
                                        <label>Montant:</label>

                                    </div>
                                    <div class="col-12 col-sm-3">

                                        <input type="number" value="{{ $settings->amount }}" name="amount" step="0.001"
                                            class="form-control" disabled>
                                    </div>
                                </div>
                                @if (Auth::user()->role == 1)
                                    <div id="updateDiv" class="mt-2">
                                        <button type="button" id="update" class="btn btn-primary">Modifier</button>
                                    </div>
                                @endif
                            </form>


                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- End container-fluid-->
    </div>
@endsection

@section('scripts')


    <script>
        const update = document.getElementById('update');
        const amount = document.querySelector('input[name="amount"]');
        let active = false;
        update.addEventListener('click', () => {
            if (active) {
                const form = document.getElementById('form');
                form.submit();

            } else {
                amount.removeAttribute('disabled');
                update.innerText = 'Enregistrer';
                amount.focus();
                
                //append a button to updateDiv before update button that dismisses the form
                const cancel = document.createElement('button');
                cancel.innerText = 'Annuler';
                cancel.classList.add('btn', 'btn-danger');
                cancel.setAttribute('type', 'button');
                cancel.addEventListener('click', () => {
                    amount.setAttribute('disabled', true);
                    update.innerText = 'Modifier';
                    updateDiv.removeChild(cancel);
                    active = false;
                });
                updateDiv.appendChild(cancel);
                active = true;
            }
        });
    </script>





@endsection
