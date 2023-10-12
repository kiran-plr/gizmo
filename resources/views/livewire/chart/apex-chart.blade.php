<div>
    <div class="card">
        <div class="card-body">
            <div class="d-sm-flex flex-wrap">
                <h4 class="card-title mb-4">{!! $title !!}</h4>
                <div class="ms-auto">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Week</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Month</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Year</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="{!! $chartId !!}" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
</div>
@push('scripts')
    <!-- apexcharts -->
    <script src="{{ asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        (function() {
            const apexChartRend = {
                chart: {
                    id: `{!! $chartId !!}`,
                    height: 360,
                    type: "bar",
                    stacked: !0,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !0
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "15%",
                        endingShape: "rounded"
                    },
                },
                dataLabels: {
                    enabled: !1
                },
                xaxis: {
                    type: 'category',
                    categories: {!! $categories !!}
                },
                series: [{
                    name: 'Pending',
                    data: {!! $seriesDataPending !!}
                }, {
                    name: 'Completed',
                    data: {!! $seriesDataCompleted !!}
                }],
                colors: ["#f1b44c", "#34c38f", "#34c38f"],
                legend: {
                    position: "bottom"
                },
                fill: {
                    opacity: 1
                },
            }
            const chartRendor = new ApexCharts(document.getElementById(`{!! $chartId !!}`), apexChartRend);
            chartRendor.render();
            document.addEventListener('livewire:load', () => {
                @this.on(`refreshChartData-{!! $chartId !!}`, (chartData) => {
                    chartRendor.updateOptions({
                        xaxis: {
                            categories: chartData.categories
                        }
                    });
                    chartRendor.updateSeries([{
                        data: chartData.seriesData,
                        name: chartData.seriesName,
                    }]);
                });
            });
        }());
    </script>
@endpush
