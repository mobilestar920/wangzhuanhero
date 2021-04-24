@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2>消息管理</h2>
                    </div>
                    <div class="card-body">
                        <form style="display: flex">
                            <h4 class="c-grey-900 mB-20" style="flex: 1 1 auto;"></h4>
                            <button id="btn_add_news" class="btn btn-danger" type="button" style="margin-bottom: 20px !important;">Add News</button>
                        </form>
                        <table id="dataTable" class="table table-responsive-sm table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newsList as $i=>$news)
                                <tr>
                                    <td>{{ $news->title }}</td>
                                    <td> {{ $news->body }} </td>
                                    <td>{{ $news->created_at }}</td>
                                    <td>
                                        <div class="peers mR-15">
                                            <div class="peer">
                                                <span id="delete_news" class="td-n c-pink-500 cH-blue-500 fsz-md p-5" news_id="{{ strval($news->id) }}">
                                                    <i class="ti-edit"></i>
                                                </span>
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

    <div class="modal" id="news_add_dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="bd p-15"  style="margin: 20px;">
                    <h5 class="m-0">Add News</h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('addNews') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-md-12">
                                <label class="fw-500">Title</label>
                                <input type="text" class="form-control" id="news_title" name="news_title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="fw-500">Body</label>
                            <textarea class="form-control bdc-grey-200" rows='5' id="news_body" name="news_body"></textarea>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary cur-p" id="btn_update" type="submit">Done</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')

<script type="text/javascript" src="{{ asset('js/manager/news.js') }}"></script>

@endsection