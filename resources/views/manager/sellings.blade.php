@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ Lang::get('localizedStr.title_selling_status') }}</h2>
                    </div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>{{ Lang::get('localizedStr.code_type') }}</th>
                                    <th>{{ Lang::get('localizedStr.total_amount') }}</th>
                                    <th>{{ Lang::get('localizedStr.selled_amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($codes as $type=>$code)
                                <tr>
                                    @if ($type == 0) 
                                    <td>{{ Lang::get('localizedStr.seven_days') }}</td>
                                    @elseif ($type == 1)
                                    <td>{{ Lang::get('localizedStr.half_month') }}</td>
                                    @else
                                    <td>{{ Lang::get('localizedStr.one_month') }}</td>
                                    @endif

                                    <td>{{ $code['total'] }}</td>
                                    <td>{{ $code['selled'] }}</td>
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

<script type="text/javascript" src="{{ asset('js/manager/sellings.js') }}"></script>

@endsection