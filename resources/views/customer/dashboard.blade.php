@extends('layouts.customer')


@section('content')
<section id="horizontal-form-layouts">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="horz-layout-basic">@lang('dashboard.Statistic')</h4>
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

                            <div class="col-xl-3 col-lg-6 col-12">
                                <div class="card bg-gradient-directional-success">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body white text-left">
                                                    <h3>{{Auth::user()->balance}}</h3>
                                                    <span class="font-weight-bold text-uppercase">@lang('dashboard.customer-balance')</span>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="ft ft-briefcase white font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6 col-12">
                                <div class="card bg-gradient-directional-blue">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body white text-left">
                                                    <h3>0</h3>
                                                    <span class="font-weight-bold text-uppercase">Products</span>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="ft ft-credit-card white font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6 col-12">
                                <div class="card bg-gradient-directional-primary">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body white text-left">
                                                    <h3>EX</h3>
                                                    <span class="font-weight-bold text-uppercase">Example</span>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="ft ft-credit-card white font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-6 col-12">
                                <div class="card bg-gradient-directional-warning">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="media d-flex">
                                                <div class="media-body white text-left">
                                                    <h3>Ex</h3>
                                                    <span class="font-weight-bold text-uppercase">Example</span>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="ft ft-credit-card white font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!---ROW-->


<section id="horizontal-form-layouts">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="horz-layout-basic">Latest</h4>
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

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover zero-configuration">
                                <thead>
                                <tr>
                                 

                                    <th>@lang('dashboard.Total Amount')</th>
                                    <th>@lang('dashboard.Pay Amount')</th>
                                    <th>@lang('dashboard.Due/Paid')</th>
                                    <th>@lang('dashboard.Action')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($sell as $p)
                                    <tr>
                                        
                                        <td>{{ $p->total_amount }} - {{ $basic->currency }}</td>
                                        <td>{{ $p->pay_amount }} - {{ $basic->currency }}</td>
                                        <td>
                                            @if($p->due_amount == 0)
                                                <div class="badge badge-primary font-weight-bold text-uppercase">Paid</div>
                                            @else
                                                {{ $p->due_amount }} - {{ $basic->currency }}
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a href="{{route('cus.inv',['invoice='.$p->custom,'search=Show'])}}" class="btn btn-primary btn-sm bold text-uppercase" title="View"><i class="fa fa-eye"></i> @lang('dashboard.view')</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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

@endsection