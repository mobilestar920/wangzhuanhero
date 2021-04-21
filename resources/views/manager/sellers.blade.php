@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Seller Management</h2>
                    </div>
                    <div class="card-body">
                        <table id="user_table" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Date Registered</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $i=>$user)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $user['username'] }}</td>
                                    <td>{{ $user['email'] }}</td>
                                    <td>{{ $user['created_at'] }}</td>
                                    <td>
                                        <div class="peers mR-15">
                                            <div class="peer">
                                                <label class="c-switch c-switch-label c-switch-warning">
                                                    @if( $user['is_blocked'] == 0 )
                                                    <input id="block_status" class="c-switch-input" type="checkbox" checked data-userId="{{ strval($user['id']) }}">
                                                    <span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                                    @else
                                                    <input id="block_status" class="c-switch-input" type="checkbox" data-userId="{{ strval($user['id']) }}">
                                                    <span class="c-switch-slider" data-checked="On" data-unchecked="Off"></span>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    </td>
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

<script type="text/javascript" src="{{ asset('js/manager/sellers.js') }}"></script>

@endsection