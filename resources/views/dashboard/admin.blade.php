@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="mt-2">
                @include('partials.message')
            </div>

            <div class="row">

                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card " id="mycard-dimiss">
                        <div class="card-header">
                            <h4>Informasi Halaman</h4>
                            <div class="card-header-action">
                                <a data-dismiss="#mycard-dimiss" class="btn btn-icon btn-danger" href="#"><i class="fas fa-times"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            Halaman ini adalah dashboard <b>UMKM</b> yang berisi Informasi mengenai grafik keuangan dan data keuangan
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik</h4>
                            <div class="card-header-action">
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="type" value="daily" class="selectgroup-input radioBtn" checked>
                                        <span class="selectgroup-button">Harian</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="type" value="weekly" class="selectgroup-input radioBtn" >
                                        <span class="selectgroup-button">Mingguan</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="type" value="monthly" class="selectgroup-input radioBtn" >
                                        <span class="selectgroup-button">Bulanan</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="type" value="yearly" class="selectgroup-input radioBtn" >
                                        <span class="selectgroup-button">Tahunan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="reportChart" height="182"></canvas>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->all->income, 0, ',', '.') }}</div>
                                    <div class="detail-name">Semua Pemasukan</div>
                                </div><div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->daily->income, 0, ',', '.') }}</div>
                                    <div class="detail-name">Pemasukan Harian</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->weekly->income, 0, ',', '.') }}</div>
                                    <div class="detail-name">Pemasukan Mingguan</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->monthly->income, 0, ',', '.') }}</div>
                                    <div class="detail-name">Pemasukan Bulanan</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->yearly->income, 0, ',', '.') }}</div>
                                    <div class="detail-name">Pemasukan Tahunan</div>
                                </div>
                            </div>
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->all->expanse, 0, ',', '.') }}</div>
                                    <div class="detail-name">Semua Pengeluaran</div>
                                </div><div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->daily->expanse, 0, ',', '.') }}</div>
                                    <div class="detail-name">Pengeluaran Harian</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->weekly->expanse, 0, ',', '.') }}</div>
                                    <div class="detail-name">Pengeluaran Mingguan</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->monthly->expanse, 0, ',', '.') }}</div>
                                    <div class="detail-name">Pengeluaran Bulanan</div>
                                </div>
                                <div class="statistic-details-item">
                                    <div class="detail-value">Rp{{ number_format($summary->yearly->expanse, 0, ',', '.') }}</div>
                                    <div class="detail-name">Pengeluaran Tahunan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            getDataReport('daily');
        });

        $(".radioBtn").change(function(){
            // bind a function to the change event
            if( $(this).is(":checked") ){ // check if the radio is checked
                let reportType = $(this).val(); // retrieve the value
                getDataReport(reportType);
            }
        });

        function getDataReport(reportType){
            let labelChart;
            let dataIncomeChart;
            let dataExpanseChart;
            let dataAmountChart;

            $.ajax({
                type: 'GET',
                url: "{{ url('report/chart') }}/"+reportType,
                dataType: 'json',
                success: function(response){
                    labelChart = response.labels;
                    dataIncomeChart = response.data.income;
                    dataExpanseChart = response.data.expanse;
                    dataAmountChart = response.data.amount;

                    showChart(labelChart, dataIncomeChart, dataExpanseChart, dataAmountChart)
                },
                error: function(response){
                    alert('Sistem Error');
                }
            });
        }

        function showChart(labelChart, dataIncomeChart, dataExpanseChart, dataAmountChart){
            const formatter = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            });

            let report_chart = document.getElementById("reportChart").getContext('2d');

            let reportChart = new Chart(report_chart, {
                type: 'line',
                data: {
                    labels: labelChart,
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: dataIncomeChart,
                            borderWidth: 5,
                            borderColor: '#63ed7a',
                            backgroundColor: 'transparent',
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#63ed7a',
                            pointRadius: 5
                        },
                        {
                            label: 'Pengeluaran',
                            data: dataExpanseChart,
                            borderWidth: 5,
                            borderColor: '#dc3545',
                            backgroundColor: 'transparent',
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#dc3545',
                            pointRadius: 5
                        },
                        {
                            label: 'Balance',
                            data: dataAmountChart,
                            borderWidth: 5,
                            borderColor: '#92a8d1',
                            backgroundColor: 'transparent',
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#dc3545',
                            pointRadius: 5
                        }
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                stepSize: 100000,
                                callback: (label, index, labels) => {
                                    return formatter.format(label);
                                }
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: '#fbfbfb',
                                lineWidth: 2
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return formatter.format(tooltipItem.value);
                            }
                        }
                    }
                }
            });
        }

    </script>
@endpush
