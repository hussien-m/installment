@extends('layouts.customer')


@section('content')
<section id="horizontal-form-layouts">
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-content collpase show">
                    <div class="card-body">
            
                        <form action="{{route('send.message')}}" method="post">
                            {{ csrf_field() }}
                            @foreach($sellItem as $key => $sl)
                            <input type="hidden" name="product_name" value="{{$sl->product->name}}" />
                            @endforeach
                            <input type="hidden" name="total_amount" value="{{$sell->total_amount}}" />
                            <input type="hidden" name="pay_amount" value="{{$sell->pay_amount}}" />
                            <input type="hidden" name="due_amount" value="{{$sell->due_amount}}" />

                            <div class="form-groub">
                                <label for="message">Send Message</label>
                                <textarea name="message" class="form-control" cols='4' rows='4' style="resize: none" placeholder="Type a message" required></textarea>    
                            </div>

                            <div class="form-groub mt-2">
                                <button type="submit" class="btn btn-primary"> Send Message </button>
                            </div>
        
                        </form>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-content collpase show">
                    <div class="card-body">
                        <h3>Messages & replies </h3>

                        <table class="table">
                            <thead>
                                <th>Message</th>
                                <th>Status</th>
                                <th>to reply</th>
                            </thead>

                            <tbody>
                                   @foreach($messages as $message)
                                    <tr>
                                        <td>{{$message->message}}</td>
                                        <td>{{$message->status}}</td>
                                        <td>
                                            {{ @$message->replay->replay_message}}
                                        </td>
                                    </tr>
                                   @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" id="horz-layout-basic">My Invoice</h4>
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
                
                     
                                    <!-- small box -->
                                    <h3 class="mt-3">Chart Product</h3>
                                    <div class="small-box">
                                        <canvas id="lineChart" style="width: auto; height: auto"></canvas>
                                    </div>
                                    
                       

                    </div>
                </div>
            </div>
        </div>




    </div>
</section>                        
@php 
 if(isset($_GET['search'])) {
@endphp

                        <div class="card-content collpase show">
                        <div class="card-body">

                            <section class="card" id="printAble">
                                <div id="invoice-template" class="card-body">
                                    <!-- Invoice Company Details -->

                                    <!--/ Invoice Company Details -->
                                    <!-- Invoice Customer Details -->
                                    <div id="invoice-customer-details" class="row pt-2">
                                        <div class="col-sm-12 text-center text-md-left">
                                            <p class="font-weight-bold">Bill To</p>
                                        </div>
                                        <div class="col-md-6 col-sm-12 text-center text-md-left">
                                            <ul class="px-0 list-unstyled">
                                                <li class="text-bold-800">{{ $sell->customer->name }}</li>
                                                <li>{{ $sell->customer->phone }}, {{ $sell->customer->phone2 }}</li>
                                                <li>{{ $sell->customer->address }}.</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 col-sm-12 text-center text-md-right">
                                            <p>
                                                <span class="text-muted"></span> {{ \Carbon\Carbon::parse($sell->created_at)->format('dS M\'y - h:i A') }}</p>
                                            <p><span class="text-muted">Terms :</span>
                                                @if($sell->payment_type == 0)
                                                    On Paid
                                                @elseif($sell->payment_type == 1)
                                                    Due Payment <br> {{ \Carbon\Carbon::parse($sell->due_payment_date)->format('dS F, Y') }}
                                                @else
                                                    Instalment
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <!--/ Invoice Customer Details -->
                                    <!-- Invoice Items Details -->
                                    <div id="invoice-items-details" class="pt-2">
                                        <div class="row">
                                            <div class="table-responsive col-sm-12">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>#SL</th>
                                                        <th>Item Category</th>
                                                        <th>Item & Description</th>
                                                        <th class="text-right">Warranty</th>
                                                        <th class="text-right">Amount</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($sellItem as $key => $sl)
                                                    <tr>
                                                        <td scope="row">{{ ++$key }}</td>
                                                        <td>{{ $sl->product->category->name }}</td>
                                                        <td>
                                                            <p>{{ $sl->product->name }} - ({{$sl->code}})</p>
                                                        </td>
                                                        <td class="text-right">{{ $sl->store->warranty }} - Days</td>
                                                        <td class="text-right">{{ $sl->store->sell_price }} - {{ $basic->currency }}</td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">

                                            @if($sell->payment_type == 2)
                                                @php $sellInstalment2 = \App\OrderInstalment::whereOrder_id($sell->id)->first() @endphp
                                                <div class="col-md-7">
                                                    <div class="table-responsive table-bordered table-striped">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Customer NID Number</th>
                                                                <th>Customer Father Name</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>{{ $sellInstalment2->customer_nid }}</td>
                                                                <td>{{ $sellInstalment2->customer_father }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <hr style="margin-top: 0;">
                                                    <div class="table-responsive table-bordered table-striped">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>Grander One Details</th>
                                                                <th>Grander Two Details</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $sellInstalment2->grander_one_name }}</td>
                                                                    <td>{{ $sellInstalment2->grander_two_name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ $sellInstalment2->grander_one_father }}</td>
                                                                    <td>{{ $sellInstalment2->grander_two_father }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ $sellInstalment2->grander_one_phone }}</td>
                                                                    <td>{{ $sellInstalment2->grander_two_phone }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ $sellInstalment2->grander_one_address }}</td>
                                                                    <td>{{ $sellInstalment2->grander_two_address }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <hr>
                                                    <h5 class="text-center">Instalment Date List</h5>
                                                    <div class="table-responsive table-bordered table-striped">
                                                        <table class="table">
                                                            <thead>
                                                            <tr>
                                                                <th>#SL</th>
                                                                <th>Date</th>
                                                                <th>Amount</th>
                                                                <th>Status</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($instalmentList as $key => $ins)
                                                                    <tr>
                                                                        <td>{{ ++$key }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($ins->pay_date)->format('dS M,Y') }}</td>
                                                                        <td>{{ $ins->amount }} {{ $basic->currency }}</td>
                                                                        <td>
                                                                            @if($ins->status == 1)
                                                                                <div class="badge badge-success">Paid</div>
                                                                            @else
                                                                                <div class="badge badge-warning">Pending</div>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td>Item Subtotal</td>
                                                                <td class="text-right">{{ $sell->product_price }} - {{ $basic->currency }}</td>
                                                            </tr>
                                                            <tr>
                                                                @if($sell->discount_type == 0)
                                                                    <td>Discount</td>
                                                                    <td class="pink text-right">(-) 0 - {{ $basic->currency }}</td>
                                                                @elseif($sell->discount_type == 1)
                                                                    <td>Discount ({{$sell->discount}}%)</td>
                                                                    <td class="pink text-right">(-) {{ round(($sell->product_price * $sell->discount)/100,2)}} - {{ $basic->currency }}</td>
                                                                @else
                                                                    <td>Discount ({{$sell->discount}}{{ $basic->symbol }})</td>
                                                                    <td class="pink text-right">(-) {{ ($sell->discount)}} - {{ $basic->currency }}</td>
                                                                @endif

                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold-800">Item Total</td>
                                                                <td class="text-bold-800 text-right"> {{ $sell->product_total }} - {{ $basic->currency }}</td>
                                                            </tr>
                                                            @if($sell->payment_type == 0)
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Total Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->total_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                            @elseif($sell->payment_type == 1)
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Total Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->total_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Pay Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->pay_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="red text-bold-800">Due Amount</td>
                                                                    <td class="red text-bold-800 text-right">{{ $sell->due_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                            @else
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Instalment Type</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->instalment->name }} - {{ $sell->instalment->charge }}% - {{ $sell->instalment->time }} times</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Total Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->total_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Pay Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->pay_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="red text-bold-800">Due Amount</td>
                                                                    <td class="red text-bold-800 text-right">{{ $sell->due_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="2" class="text-capitalize"><b>In word :</b> {{ \App\TraitsFolder\CommonTrait::wordAmount($sell->total_amount) }} {{ $basic->currency }} Only.</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-5 offset-md-7">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                            <tr>
                                                                <td>Item Subtotal</td>
                                                                <td class="text-right">{{ $sell->product_price }} - {{ $basic->currency }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Discount ({{$sell->discount}}%)</td>
                                                                <td class="pink text-right">(-) {{ round(($sell->product_price * $sell->discount)/100,2)}} - {{ $basic->currency }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-bold-800">Item Total</td>
                                                                <td class="text-bold-800 text-right"> {{ $sell->product_total }} - {{ $basic->currency }}</td>
                                                            </tr>
                                                            @if($sell->payment_type == 0)
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Total Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->total_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                            @elseif($sell->payment_type == 1)
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Total Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->total_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Pay Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->pay_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="red text-bold-800">Due Amount</td>
                                                                    <td class="red text-bold-800 text-right">{{ $sell->due_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                            @else
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Instalment Type</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->instalment->name }} - {{ $sell->instalment->charge }}% - {{ $sell->instalment->time }} times</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Total Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->total_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="text-bold-800">Pay Amount</td>
                                                                    <td class="text-bold-800 text-right">{{ $sell->pay_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                                <tr class="bg-grey bg-lighten-4">
                                                                    <td class="red text-bold-800">Due Amount</td>
                                                                    <td class="red text-bold-800 text-right">{{ $sell->due_amount }} - {{ $basic->currency }}</td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="2" class="text-capitalize"><b>In word :</b> {{ \App\TraitsFolder\CommonTrait::wordAmount($sell->total_amount) }} {{ $basic->currency }} Only.</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif


                                        </div>
                                    </div>
         
                                </div>
                            </section>

                        </div>
                    </div>
                            

                         
                        @php } 
                        @endphp<!---ROW-->
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
                        {{ $sell->total_amount }}  ,{{ $sell->pay_amount }} ,{{ $sell->due_amount }}
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