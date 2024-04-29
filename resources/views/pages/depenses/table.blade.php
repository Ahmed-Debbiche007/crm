@extends('welcome')
@section('title', 'Dépenses')
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
                                <h5 class="card-title">Dépenses</h5>
                                @if (Auth::user()->role == 1)
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#inlineForm"
                                        class="btn btn-primary">Ajouter</button>
                                @endif
                            </div>
                            <div class="d-flex justify-content-start flex-wrap flex-row m-3 col-sm-4 col-12">
                                <div class="d-flex flex-column align-items-start mx-2">
                                    <h5 class="card-title mb-2">Annee:</h5>
                                    <select name="annee" class="form-control" id="anneeSelect">
                                        <option value="0">Tout</option>
                                        @for ($i = 2021; $i <= 2100; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="d-flex flex-column align-items-end justify-content-end mx-2">
                                    <button class="btn btn-primary" id="chercher">Chercher</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Annee</th>
                                            <th scope="col">Mois</th>
                                            <th scope="col" style="width: 35%">Libelle</th>
                                            <th scope="col" style="width: 35%" id="summable">Montant</th>
                                            @if (Auth::user()->role == 1)
                                                <th scope="col" class="noExport">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($depenses as $depense)
                                            @php

                                                $date_without_dashes = str_replace('-', '', $depense->date);
                                            @endphp
                                            <tr id="{{ $date_without_dashes }}">
                                                @php
                                                    $date = DateTime::createFromFormat('Y-m', $depense->date);

                                                    setlocale(LC_TIME, 'fr_FR.utf8');
                                                    $year = $date->format('Y');
                                                    $monthInLetters = strftime('%B', $date->getTimestamp());
                                                @endphp
                                                <td id="{{ $depense->id }}">{{ $year }}</td>
                                                <td id="{{ $depense->id }}">{{ $monthInLetters }}</td>
                                                <td>{{ $depense->libelle }}</td>
                                                <td>{{ number_format($depense->amount, 3, '.', ' ') }}</td>
                                                @if (Auth::user()->role == 1)
                                                    <td>

                                                        <div class="d-flex">
                                                            <button id="{{ $depense->id }}"
                                                                class="btn btn-warning edit m-1" data-bs-toggle="modal"
                                                                data-bs-target="#inlineFormEdit"><i
                                                                    data-feather="edit"></i>Modifier</button>

                                                            <form method="GET"
                                                                action="{{ route('depenses.destroy', $depense->id) }}">
                                                                @csrf
                                                                <button type="button" class="btn btn-danger m-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#inlineChargeDelete{{ $depense->id }}"><i
                                                                        data-feather="trash"></i>Supprimer</button>
                                                                <div class="modal fade"
                                                                    id="inlineChargeDelete{{ $depense->id }}"
                                                                    tabindex="-1" role="dialog"
                                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">
                                                                                    Confirmation</h5>
                                                                                <button type="button" class="close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
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
                                    </tbody>
                                    <tfoot>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"><b>Total:</b></th>
                                        <th scope="col" style="color:#ff0000"></th>
                                        @if (Auth::user()->role == 1)
                                            <th scope="col" class="noExport"></th>
                                        @endif
                                    </tfoot>
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
                        <form method="POST" action="{{ route('depenses.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                {{-- <label>Residence: </label>
                            <div class="form-group">
                                <select name="residence_id" class="form-control" id="residencesAdd">
                                    @foreach ($residences as $residence)
                                        <option value="{{ $residence->id }}">{{ $residence->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="month" name="date" class="form-control">
                                </div>
                                <label>Libelle: </label>
                                <div class="form-group">
                                    <input type="text" name="libelle" placeholder="Libelle" class="form-control">
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input type="number" name="amount" placeholder="Montant" class="form-control"
                                        step="0.001">
                                </div>
                                <input type="hidden" value="2" name="residence_id">


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
                                <label>Date: </label>
                                <div class="form-group">
                                    <input type="month" name="date" class="form-control">
                                </div>
                                <label>Libelle: </label>
                                <div class="form-group">
                                    <input type="text" name="libelle" placeholder="Libelle" class="form-control">
                                </div>
                                <label>Montant: </label>
                                <div class="form-group">
                                    <input type="number" name="amount" placeholder="Montant" class="form-control"
                                        step="0.001">
                                </div>
                                <input type="hidden" value="2" name="residence_id">
                                {{-- <label>Residence: </label>
                            <div class="form-group">
                                <select name="residence_id" class="form-control" id="residencesEdit">
                                    @foreach ($residences as $residence)
                                        <option value="{{ $residence->id }}">
                                            {{ $residence->name }}</option>
                                    @endforeach
                                </select>
                            </div> 
                            
                            --}}

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



    <script src="{{ asset('dist/js/DataTables/datatables.js') }}"></script>
    <script src="{{ asset('dist/js/DataTables/dataTables.rowsGroup.js') }}"></script>
    <script>
        

        function tables() {

            $(".table").each(function() {
                var buttonCommon = {
                    exportOptions: {
                        format: {
                            body: function(data, row, column, node) {
                                console.log(column);
                                console.log(node);
                                console.log(data);

                                var containsHTML = /<\/?[a-z][\s\S]*>/i.test(data);
                                console.log($(node).hasClass("expot-data"));

                                return containsHTML ? "" : data;
                            },
                        },
                    },
                };
                const jquery_datatable = $(this);
                jquery_datatable.DataTable({
                    responsive: {
                        details: {
                            renderer: DataTable.Responsive.renderer.listHiddenNodes(),
                        },
                    },
                    dom: "lBfrtip", // 'l' for length menu, 'B' for buttons
                    lengthMenu: [
                        [10, 25, 50, 75, 100], // Available options
                        [10, 25, 50, 75, 100], // Labels
                    ],
                    columnDefs: [{
                            target: 0,
                            orderData: [0, 1],
                            visible: false,
                        },
                        {
                            target: 1,
                            orderData: [0,1],
                            visible: false
                        },
                        {
                            target: 2,
                            orderData: [0,1, 2]
                        },
                        {
                            target: 3,
                            orderData: [0,1, 3]
                        },
                        {
                            target: 4,
                            orderData: [0,1, 4]
                        }
                    ],
                    rowGroup: {
                        dataSrc: [0, 1]
                    },
                    buttons: [{
                        extend: "excel",
                        text: "Exporter Excel",
                        className: "btn btn-success",
                        exportOptions: {
                            columns: ':not(:last-child):not(:contains("Actions"))' // Exclude last column and columns containing "Actions"
                        }

                    }, ],
                    initComplete: function() {
                        let table = this.api();

                        table.columns().every(function() {
                            let column = this;
                            if (column.header().id === "summable") {
                                let sum = table
                                    .column(column.index(), {
                                        page: "current",
                                        search: "applied",
                                    })
                                    .data()
                                    .reduce(function(a, b) {
                                        // Remove spaces and then parse
                                        let num = parseFloat(b.replace(/\s/g, ""));
                                        return a + (isNaN(num) ? 0 :
                                            num
                                        ); // Check if num is NaN and handle accordingly
                                    }, 0);

                                $(column.footer()).html(
                                    sum
                                    .toLocaleString("en-US", {
                                        minimumFractionDigits: 3,
                                        maximumFractionDigits: 3,
                                    })
                                    .replace(/,/g, " ")
                                );
                                $(column.footer()).style =
                                    "color: red; background-color: white; font-weight: bold;";

                                table.on("draw", function() {
                                    let sum = table
                                        .column(column.index(), {
                                            page: "current",
                                            search: "applied",
                                        })
                                        .data()
                                        .reduce(function(a, b) {
                                            // Remove spaces and then parse
                                            let num = parseFloat(b.replace(/\s/g,
                                                ""));
                                            return a + (isNaN(num) ? 0 :
                                                num
                                            ); // Check if num is NaN and handle accordingly
                                        }, 0);

                                    $(column.footer()).html(
                                        sum
                                        .toLocaleString("en-US", {
                                            minimumFractionDigits: 3,
                                            maximumFractionDigits: 3,
                                        })
                                        .replace(/,/g, " ")
                                    );
                                });
                            }
                        });
                    },
                });

                const setTableColor = () => {
                    jquery_datatable
                        .find(".dataTables_paginate .pagination")
                        .addClass("pagination-primary");
                    document.querySelectorAll('.dtrg-level-1').forEach((element) => {
                        element.style.textTransform = 'capitalize';
                    });

                    document.querySelectorAll('.dtrg-level-0').forEach((element) => {
                        element.style.color = 'red';
                    });
                };

                setTableColor();
                jquery_datatable.on("draw.dt", setTableColor);
            });
        }

        tables();
    </script>



    <script>
        const editButtons = document.getElementsByClassName('edit');
        editButtons.forEach = Array.prototype.forEach;
        document.addEventListener('click', function(event) {
            const target = event.target;
            if (target.classList.contains('edit')) {
                const editButton = target;
                const form = document.getElementById('formEdit');

                let base = '{{ route('depenses.update', '5') }}';
                base = base.replace('5', editButton.id);
                form.action = base;
                const libelleInput = form.querySelector('input[name="libelle"]');
                const amountInput = form.querySelector('input[name="amount"]');
                const dateInput = form.querySelector('input[name="date"]');


                url = "{{ route('depenses.get', 5) }}";
                url = url.replace('5', editButton.id);
                axios.get(url).then((reponse) => {
                    const depense = reponse.data;
                    libelleInput.value = depense.libelle;
                    amountInput.value = depense.amount;
                    dateInput.value = depense.date;
                }).catch((error) => {
                    console.log(error)
                }).catch((error) => {
                    console.log(error)
                })
            };
        })

        const chercher = document.getElementById('chercher');
        chercher.addEventListener('click', (e) => {
            const annee = document.getElementById('anneeSelect').value;


            let url = window.location.href;

            url = url.split('?')[0];

            if (annee != 0) {
                url = url + '?annee=' + annee;
            }
            window.location.href = url;
        })
        // get current query string
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const anneeSearch = urlParams.get('annee');

        if (anneeSearch != null) {
            document.getElementById('anneeSelect').value = anneeSearch;
        }
    </script>
@endsection
