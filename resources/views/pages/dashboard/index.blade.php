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
                                                class="badge bg-success mx-2">Appartements</a>
                                            <h5 class="m-2">Nombre d'appartements: {{ $totalAppartCount }}</h5>
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
                                            <a href="{{ route('echances') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Échanciers</a>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('charges') }}?res={{ $residence->id }}"
                                                class="badge bg-success mx-2">Charges</a>
                                        </div>
                                        @if ($totalAppartCount > 0)
                                            <br>
                                            <div class="d-flex justify-content-center align-items-center col-12">
                                                <div class="pie mt-3" id="{{ $residence->id }}"></div>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center col-12">
                                                <div class="bar mt-3" id="{{ $residence->id }}"></div>
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
                    } else if (appart.bs == 1) {
                        reserve++;
                    } else if (appart.bs == 2) {
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
                labels: ['Libre', 'Réservé', 'Loué', 'Vendu'],
                colors: ["#005841", "#fe8900", "#fde25e", "#850000"],
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + " Appartement(s)"
                        }
                    }
                }
            };
            var bar = new ApexCharts(div, options);
            bar.render();
        })
        bars.forEach((bar) => {
            const div = document.createElement('div');
            bar.appendChild(div);
            const residence = residences.find((res) => res.id == bar.id);
            let charges = 0;
            let echeanciers = 0;
            let prix = 0;
            residence.etage.forEach((etage) => {
                etage.appart.forEach((appart) => {

                    appart.charge.forEach((charge) => {
                        charges += charge.sonede;
                        charges += charge.syndic;
                        charges += charge.avocat;
                        charges += charge.contrat;
                        charges += charge.foncier;
                    })

                    appart.echance.forEach((echeancier) => {
                        echeanciers += echeancier.amount_avance;
                        echeancier.echeance.forEach((echeance) => {
                            if (echeance.payed == 1) {
                                echeanciers += echeance.montant;
                            }
                        })
                    })
                    prix += appart.price;
                    prix = prix - echeanciers;

                })
            })
            var barOptions = {
                series: [{
                        name: "Charges",
                        data: [charges],
                    },
                    {
                        name: "Échanciers Payés",
                        data: [echeanciers],
                    },
                    {
                        name: "Échanciers Restants",
                        data: [prix],
                    },
                ],
                chart: {
                    type: "bar",
                    width: 300,
                },
                colors: ["#fe8900", "#005841", "#850000"],
                
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
                            return val + " Milles Dinars";
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
