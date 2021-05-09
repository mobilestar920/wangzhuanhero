@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            销售状态: 
                            @if($type == 0) 
                            7日
                            @elseif($type == 1)
                            15日
                            @elseif($type == 2)
                            30日
                            @else
                            永久
                            @endif
                        </h2>
                    </div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>用户名</th>
                                    <th>激活数</th>
                                    <th>销售数量</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sellers as $i=>$data)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $data['username'] }}</td>
                                    <td>{{ $data['total'] }}</td> 
                                    <td>{{ $data['selled'] }}</td>                                  
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
</div>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ asset('js/manager/selling_seller.js') }}"></script>

@endsection