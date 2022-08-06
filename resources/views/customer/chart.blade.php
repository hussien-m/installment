@extends('layouts.customer')


@section('content')
<section id="horizontal-form-layouts">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="horz-layout-basic">Company Statistic</h4>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collpase show">
                    <div class="card-body">
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <!-- small box -->
                                
                                <div class="small-box">
                                    <canvas id="lineChart" style="width: auto; height: auto"></canvas>
                                </div>
                                
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!---ROW-->
@stop


@section('scripts')

    <script type="text/javascript" src="{{ asset('assets/admin/js/Chart.min.js') }}"></script>

    <script language="JavaScript">
      const labels = [
                'Total Amount',
                'Pay Amount',
                'Due/Paid',
            ];

            const data = {
                labels: labels,
                datasets: [{
                    label: 'My First dataset',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [
                            
                            @foreach($sell as $p)
                   
                            
                            
                            '{{ $p->total_amount}}',
                            @endforeach
                    ],
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {}
            };
            var ctx = document.getElementById("lineChart").getContext("2d");
            var options = {
                responsive: true
            };
            var lineChart = new Chart(ctx).Bar(data, options);
    </script>
@endsection