@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Customers Management</h2>
                    </div>
                    <div class="card-body">
                        <table id="customer_table" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User Code</th>
                                    <th>Phone</th>
                                    <th>IMEI</th>
                                    <th>Token</th>
                                    <th>Start Date</th>
                                    <th>Expire Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $i=>$user)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $user['code'] }}</td>
                                    <td>{{ $user['phone'] }}</td>
                                    <td>{{ $user['device_uuid'] }}</td>
                                    <td>{{ $user['verification_code'] }}</td>
                                    <td>{{ $user['created_at'] }}</td>
                                    <td>{{ $user['expire_at'] }}</td>
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

<script type="text/javascript" src="{{ asset('js/manager/customers.js') }}"></script>

@endsection