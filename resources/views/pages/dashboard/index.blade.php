@extends('welcome')
@section('title', 'Dashboards')
@section('styles')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-lg-12 d-flex flex-wrap">
                    @foreach ($residences as $residence)
                        <div class="col-12 col-md-5 m-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Résidence: {{ $residence->name }}</h5>
                                    @if ($residence->image && count($residence->image) > 0)
                                        <div id="carouselExample" class="carousel slide m-3">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="{{ asset($residence->image[0]->path) }}" class="d-block w-100"
                                                        style="height: 500px; object-fit: contain;">
                                                </div>
                                                @foreach ($residence->image as $key => $image)
                                                    @if ($key > 0)
                                                        <div class="carousel-item">
                                                            <img src="{{ asset($image->path) }}" class="d-block w-100"
                                                                style="height: 500px; object-fit: contain;">
                                                        </div>
                                                    @endif
                                                @endforeach

                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselExample" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselExample" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    @else
                                        <h6 class="card-title ml-5">Pas de photos</h6>
                                    @endif
                                    <div class="d-flex flex-wrap ">
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('etages') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Étages</a>
                                            <h5 class="m-2">Nombre d'étages: {{ $residence->etage->count() }}</h5>
                                        </div>
                                        @php
                                            $totalAppartCount = 0;
                                            foreach ($residence->etage as $etage) {
                                                $totalAppartCount += $etage->appart->count();
                                            }
                                        @endphp
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('apparts') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Bien Immobilier</a>
                                            <h5 class="m-2">Nombre de biens immobiliers: {{ $totalAppartCount }}</h5>
                                        </div>

                                        <div class="d-flex flex-column">
                                            <a href="{{ route('parkings') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Parkings</a>
                                            <h5 class="m-2">Nombre de parkings: {{ $residence->parking->count() }}</h5>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('celliers') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Celliers</a>
                                            <h5 class="m-2">Nombre de celliers: {{ $residence->cellier->count() }}</h5>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('garages') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Garages</a>
                                            <h5 class="m-2">Nombre de garages: {{ $residence->garage->count() }}</h5>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('echances') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Échanciers</a>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('charges') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Charges</a>
                                        </div>
                                        @if ($totalAppartCount > 0)
                                            <div class="d-flex flex-column w-100 mt-2">
                                                <h5>Bien Immobiliers:</h5>
                                                <div class="d-flex justify-content-center align-items-center col-12">
                                                    <div class="pie mt-3" id="{{ $residence->id }}"></div>
                                                </div>
                                                @if ($residence->parking->count() > 0)
                                                    <h5>Parkings:</h5>
                                                    <div class="d-flex justify-content-center align-items-center col-12">
                                                        <div class="parking mt-3" id="{{ $residence->id }}"></div>
                                                    </div>
                                              
                                                @endif
                                                @if ($residence->cellier->count() > 0)
                                                    <h5>Celliers:</h5>
                                                    <div class="d-flex justify-content-center align-items-center col-12">
                                                        <div class="cellier mt-3" id="{{ $residence->id }}"></div>
                                                    </div>
                                              
                                                @endif
                                                @if ($residence->garage->count() > 0)
                                                    <h5>Garages:</h5>
                                                    <div class="d-flex justify-content-center align-items-center col-12">
                                                        <div class="garage mt-3" id="{{ $residence->id }}"></div>
                                                    </div>
                                                
                                                @endif
                                                <div class="d-flex justify-content-center align-items-center col-12">
                                                    <div class="bar mt-3" id="{{ $residence->id }}"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    <script src="{{ asset('dist/libs/dayjs/dayjs.min.js') }}"></script>
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dist/js/vendors.js') }}"></script>
    <script>
        const pies = document.querySelectorAll('.pie');
        const bars = document.querySelectorAll('.bar');
        const parking = document.querySelectorAll('.parking');
        const cellier = document.querySelectorAll('.cellier');
        const garage = document.querySelectorAll('.garage');
        const residences = @json($residences);
        pies.forEach((pie) => {
            const div = document.createElement('div');
            pie.appendChild(div);
            const residence = residences.find((res) => res.id == pie.id);
            let libre = 0;
            let reserve = 0;
            let loue = 0;
            let vendu = 0;
            const data = [];
            residence.etage.forEach((etage) => {
                etage.appart.forEach((appart) => {
                    if (appart.bs == 0) {
                        libre++;
                    } else if (appart.bs == 2) {
                        reserve++;
                    } else if (appart.bs == 1) {
                        loue++;
                    } else if (appart.bs == 3) {
                        vendu++;
                    }
                })
            })
            data.push(libre);
            data.push(reserve);
            data.push(loue);
            data.push(vendu);

            var options = {
                chart: {
                    type: 'pie',
                },
                series: data,
                labels: ['A vendre', 'Réservé', 'Loué', 'Vendu'],
                colors: ["#fe6d73", "#17c3b2", "#fde25e", "#227c9d"],
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " Bien(s) Immobilier(s)"
                        }
                    }
                },
                dataLabels: {
                    enabled: true,

                    background: {
                        enabled: true,
                        foreColor: 'white',
                        borderWidth: 0
                    }
                },
            };

            var bar = new ApexCharts(div, options);
            bar.render();
        })

        parking.forEach((p) => {
            const div = document.createElement('div');
            p.appendChild(div);
            const residence = residences.find((res) => res.id == p.id);

            let parkingVide = 0;
            let parkingReserve = 0;

            const parkings = [];

            residence.parking.forEach((parking) => {
                if (parking.client_id == null || parking.client_id == 0 || parking.client_id == "" ||
                    parking.client_id == undefined) {
                    parkingVide++;
                } else {
                    parkingReserve++;
                }
            })


            parkings.push(parkingVide);
            parkings.push(parkingReserve);

            console.log(parkings, p.id)
            var parkingOptions = {
                chart: {
                    type: 'pie',
                },
                series: parkings,
                labels: ['Libre', 'Réservé'],
                colors: ["#17c3b2", "#227c9d"],
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " Parking(s)"
                        }
                    }
                },
                dataLabels: {
                    enabled: true,

                    background: {
                        enabled: true,
                        foreColor: 'white',
                        borderWidth: 0
                    }
                },
            };


            var parkingChart = new ApexCharts(div, parkingOptions);
            parkingChart.render();
        })

        cellier.forEach((c) => {
            const div = document.createElement('div');
            c.appendChild(div);
            const residence = residences.find((res) => res.id == c.id);
            let cellierVide = 0;
            let cellierReserve = 0;

            const celliers = [];

            residence.cellier.forEach((cellier) => {
                if (cellier.client_id == null || cellier.client_id == 0 || cellier.client_id == "" ||
                    cellier.client_id == undefined) {
                    cellierVide++;
                } else {
                    cellierReserve++;
                }
            })

            celliers.push(cellierVide);
            celliers.push(cellierReserve);
            console.log(c.id, celliers)
            var cellierOptions = {
                chart: {
                    type: 'pie',
                },
                series: celliers,
                labels: ['Libre', 'Réservé'],
                colors: ["#17c3b2", "#227c9d"],
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " Cellier(s)"
                        }
                    }
                },
                dataLabels: {
                    enabled: true,

                    background: {
                        enabled: true,
                        foreColor: 'white',
                        borderWidth: 0
                    }
                },
            };

            var cellierChart = new ApexCharts(div, cellierOptions);
            cellierChart.render();
        })

        garage.forEach((c) => {
            const div = document.createElement('div');
            c.appendChild(div);
            const residence = residences.find((res) => res.id == c.id);
            let garageVide = 0;
            let garageReserve = 0;

            const garages = [];

            residence.garage.forEach((garage) => {
                if (garage.client_id == null || garage.client_id == 0 || garage.client_id == "" ||
                    garage.client_id == undefined) {
                    garageVide++;
                } else {
                    garageReserve++;
                }
            })

            garages.push(garageVide);
            garages.push(garageReserve);
            console.log(c.id, garages)
            var garageOptions = {
                chart: {
                    type: 'pie',
                },
                series: garages,
                labels: ['Libre', 'Réservé'],
                colors: ["#17c3b2", "#227c9d"],
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " Cellier(s)"
                        }
                    }
                },
                dataLabels: {
                    enabled: true,

                    background: {
                        enabled: true,
                        foreColor: 'white',
                        borderWidth: 0
                    }
                },
            };

            var garageChart = new ApexCharts(div, garageOptions);
            garageChart.render();
        })

        bars.forEach((bar) => {
            const div = document.createElement('div');
            bar.appendChild(div);
            const residence = residences.find((res) => res.id == bar.id);

            let echeancers = 0;
            let prix = 0;
            residence.etage.forEach((etage) => {
                etage.appart.forEach((appart) => {



                    appart.echance.forEach((echeancier) => {
                        prix += echeancier.appart.price;
                        echeancers += echeancier.amount_avance;
                        echeancier.echeance.forEach((echeance) => {
                            if (echeance.payed == 1) {
                                echeancers += echeance.montant;
                            }
                        })
                    })



                })
            })
            var barOptions = {
                series: [{
                        name: "Échanciers Payés",
                        data: [echeancers],
                    },
                    {
                        name: "Échanciers Restants",
                        data: [prix - echeancers],
                    },
                ],
                chart: {
                    type: "bar",
                    width: 300,
                },
                colors: ["#17c3b2", "#fe6d73"],

                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ["transparent"],
                },
                xaxis: {
                    categories: ["Finances"],
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            // Format the value to include thousand separator and ' K' for 'Mille Dinars'
                            return (value).toLocaleString(undefined, {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 1
                            }).replace(/,/g, " ");
                        }
                    },
                    title: {
                        text: "Mille Dinars",
                    },
                },
                fill: {
                    opacity: 1,
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            let formattedValue = val.toLocaleString('en-US', {
                                minimumFractionDigits: 3,
                                maximumFractionDigits: 3,
                                useGrouping: true,
                            });
                            return formattedValue.replace(/,/g, " ") + " Milles Dinars";
                        },
                    },
                },
                toolbar: {
                    show: false,
                }
            };
            var bar = new ApexCharts(div, barOptions);
            bar.render();
        })
    </script>

@endsection
