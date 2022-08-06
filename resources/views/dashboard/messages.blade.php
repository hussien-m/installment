@extends('layouts.dashboard')
@section('import_style')
@endsection
@section('style')
    <style>
        td{
            font-weight: bold;
            font-size: 14px;
        }
        .select2-selection,.select2-results{
            font-weight: bold !important;
        }
    </style>
@endsection
@section('content')


    <section id="horizontal-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <button id="btn_add" name="btn_add" class="btn btn-primary font-weight-bold text-uppercase"><i class="fa fa-plus"></i> Messages</button>
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

                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Product Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="products-list" name="products-list">
                                @foreach ($messages as $message)
                                    <tr>
                                        <td>{{$message->message}}</td>
                                        <td>{{$message->status}}</td>
                                        <td>{{$message->product_name}}</td>
                                        <td>{{$message->created_at}}</td>
                                        <td>
                                            <form action="{{route('replay',[$message->id])}}" method="post">
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <select class="form-control" name="status">
                                                        <option value="pending">pending</option>
                                                        <option value="cancel">cancel</option>
                                                        <option value="accept">accept</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input tyop="text" name="replay_message" class="form-control" placeholder="Type replay message" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">send</button>

                                            </form>
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
    </section><!---ROW-->



    
@endsection

@section('scripts')

@endsection