@extends('welcome')
@section('title', 'Dashboard')
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
                                <h5 class="card-title">Dashboard</h5>

                            </div>

                            <div class="table-responsive">
                                <table class='table table-striped' id="table1">
                                    <thead>
                                        <tr>
                                            <th scope="col" id="yearOrder">Année</th>
                                            <th scope="col">Frais Syndic Total</th>
                                            <th scope="col">Frais Syndic Payé</th>
                                            <th scope="col">Frais Syndic Non Payé</th>
                                            <th scope="col">Dépenses</th>
                                            <th scope="col">Gains</th>
                                            <th scope="col">Reste</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($data as $year => $elements)
                                            <tr>
                                                <td>{{ $year }}</td>
                                                <td>{{ number_format($elements['total_abonnements'], 3, '.', ' ') }}</td>
                                                <td>{{ number_format($elements['total_paid'], 3, '.', ' ') }}</td>
                                                <td>{{ number_format($elements['total_unpaid'], 3, '.', ' ') }}</td>
                                                <td>{{ number_format($elements['total_depenses'], 3, '.', ' ') }}</td>
                                                <td>{{ number_format($elements['total_paid'] - $elements['total_depenses'], 3, '.', ' ') }}
                                                </td>
                                                <td><b>Reste {{ $year - 1 }}:</b>  {{ number_format($elements['reste'], 3, '.', ' ') }}</td>
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



            <div class="overlay toggle-menu"></div>
            <!--end overlay-->
        </div>
        <!-- End container-fluid-->
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('dist/libs/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dist/js/DataTables/datatables.js') }}"></script>
    <script src="{{ asset('dist/js/vendors.js') }}"></script>
    <script>
        $(document).ready(function() {
            const jquery_datatable = $('#table1');
            var columnIndex = jquery_datatable.find("#yearOrder").index();
            $('#table1').DataTable().order([columnIndex, "desc"]).draw();
        });
    </script>


@endsection
