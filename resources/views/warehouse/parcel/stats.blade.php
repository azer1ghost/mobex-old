@extends(config('saysay.crud.layout'))

@section('content')
    <style>
        .chart {
            height: 500px;
            width: 100%;
        }

        #chart_worker {
            height: 375px;
        }
    </style>
    <div class="row">
        <div class="col-lg-5">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-body">
                        <div class="card-header header-elements-inline">
                            <h4 class="card-title">Total</h4>
                        </div>
                        <div class="row text-center">
                            <div class="col-lg-4">
                                <p><i class="icon-stack3 icon-2x d-inline-block text-info"></i></p>
                                <h5 class="font-weight-semibold mb-0">{{ $total->total }}</h5>
                                <h5 class="font-weight-semibold mb-0">{{ $total->total_weight }} kg</h5>
                                <span class="text-muted font-size-sm">Packages</span>
                            </div>

                            <div class="col-lg-4">
                                <p><i class="icon-point-up icon-2x d-inline-block text-warning"></i></p>
                                <h5 class="font-weight-semibold mb-0">{{ $declared->total }}</h5>
                                <h5 class="font-weight-semibold mb-0">{{ $declared->total_weight }} kg</h5>
                                <span class="text-muted font-size-sm">Declared</span>
                            </div>

                            <div class="col-lg-4">
                                <p><i class="icon-percent icon-2x d-inline-block text-success"></i></p>
                                <h5 class="font-weight-semibold mb-0">{{ ($total->total ? round(100 * $declared->total / $total->total, 2) : 0) . "%" }}</h5>
                                <h5 class="font-weight-semibold mb-0">{{ ($total->total_weight ? round(100 * $declared->total_weight / $total->total_weight, 2) : 0) . "%" }}</h5>
                                <span class="text-muted font-size-sm">Percent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card card-body">
                        <div class="card-header header-elements-inline">
                            <h4 class="card-title">Today</h4>
                        </div>
                        <div class="row text-center">
                            <div class="col-lg-4">
                                <p><i class="icon-stack3 icon-2x d-inline-block text-info"></i></p>
                                <h5 class="font-weight-semibold mb-0">{{ $totalToday->total }}</h5>
                                <h5 class="font-weight-semibold mb-0">{{ $totalToday->total_weight }} kg</h5>
                                <span class="text-muted font-size-sm">Packages</span>
                            </div>

                            <div class="col-lg-4">
                                <p><i class="icon-point-up icon-2x d-inline-block text-warning"></i></p>
                                <h5 class="font-weight-semibold mb-0">{{ $totalTodayDeclared->total }}</h5>
                                <h5 class="font-weight-semibold mb-0">{{ $totalTodayDeclared->total_weight }} kg</h5>
                                <span class="text-muted font-size-sm">Declared</span>
                            </div>

                            <div class="col-lg-4">
                                <p><i class="icon-percent icon-2x d-inline-block text-success"></i></p>
                                <h5 class="font-weight-semibold mb-0">{{ (  $totalToday->total ? round(100 * $totalTodayDeclared->total / $totalToday->total, 2) : 0) . "%" }}</h5>
                                <h5 class="font-weight-semibold mb-0">{{ ($totalToday->total_weight ? round(100 * $totalTodayDeclared->total_weight / $totalToday->total_weight, 2) : 0) . "%" }}</h5>
                                <span class="text-muted font-size-sm">Percent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <!-- Basic bar chart -->
            <div class="card">
                <div class="card-body">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Workers (Today)</h5>
                    </div>

                    <div class="chart-container">
                        <div class="chart" id="chart_worker"></div>
                    </div>
                </div>
            </div>
            <!-- /basic bar chart -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <!-- Basic bar chart -->
            <div class="card">
                <div class="card-body">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Package activity</h5>
                    </div>

                    <div class="chart-container">
                        <div class="chart" id="chartdiv"></div>
                    </div>
                </div>
            </div>
            <!-- /basic bar chart -->
        </div>
    </div>

    <!-- Resources -->
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>


    <!-- Chart code -->
    <script>
        am4core.ready(function () {

            am4core.useTheme(am4themes_animated);


            var chart = am4core.create("chartdiv", am4charts.XYChart);
            chart.scrollbarX = new am4core.Scrollbar();

            chart.data = [
                    @foreach($packagesByDay as $pp)
                {
                    "country": "<?= $pp->month?>",
                    "visits": <?= round($pp->total, 0) ?>,
                },
                @endforeach
            ];

// Create axes
            var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "country";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.minGridDistance = 30;
            categoryAxis.renderer.labels.template.horizontalCenter = "right";
            categoryAxis.renderer.labels.template.verticalCenter = "middle";
            categoryAxis.renderer.labels.template.rotation = 270;
            categoryAxis.tooltip.disabled = true;
            categoryAxis.renderer.minHeight = 110;

            var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
            valueAxis.renderer.minWidth = 50;

// Create series
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.sequencedInterpolation = true;
            series.dataFields.valueY = "visits";
            series.dataFields.categoryX = "country";
            series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
            series.columns.template.strokeWidth = 0;

            series.tooltip.pointerOrientation = "vertical";

            series.columns.template.column.cornerRadiusTopLeft = 10;
            series.columns.template.column.cornerRadiusTopRight = 10;
            series.columns.template.column.fillOpacity = 0.8;

// on hover, make corner radiuses bigger
            var hoverState = series.columns.template.column.states.create("hover");
            hoverState.properties.cornerRadiusTopLeft = 0;
            hoverState.properties.cornerRadiusTopRight = 0;
            hoverState.properties.fillOpacity = 1;

            series.columns.template.adapter.add("fill", function(fill, target) {
                return chart.colors.getIndex(target.dataItem.index);
            });

// Cursor
            chart.cursor = new am4charts.XYCursor();

            var chartLinks = am4core.create("chart_worker", am4charts.PieChart);

            chartLinks.data = [
                    @foreach($workers as $worker)
                {
                    "country": "<?= $worker['name'] ?>",
                    "litres": <?= $worker['count'] ?>,
                },
                @endforeach
            ];

            var pieSeries = chartLinks.series.push(new am4charts.PieSeries());
            pieSeries.dataFields.value = "litres";
            pieSeries.dataFields.category = "country";
            pieSeries.innerRadius = am4core.percent(50);
            pieSeries.ticks.template.disabled = true;
            pieSeries.labels.template.disabled = true;

            var rgm = new am4core.RadialGradientModifier();
            rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, -0.5);
            pieSeries.slices.template.fillModifier = rgm;
            pieSeries.slices.template.strokeModifier = rgm;
            pieSeries.slices.template.strokeOpacity = 0.4;
            pieSeries.slices.template.strokeWidth = 0;

            chartLinks.legend = new am4charts.Legend();
            chartLinks.legend.position = "right";

        }); // end am4core.ready()
    </script>
@endsection