@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-dark text-white ">
                    <div class="card-header">模块列表 <span class="text-right"><a
                                    class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#exampleModal">新增模块</a></span></div>
                    <div class="card-body">
                        @if(count($modules_list)>0)
                            @foreach($modules_list as $module)
                                <div class="card">
                                    <div class="row no-gutters">
                                        <div class="col-md-4 bg-secondary text-white text-center"
                                             style="margin: auto!important;">
                                            <h4 style="line-height: 1.5rem">{{$module->module_name}}</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body text-dark">
                                                <h5 class="card-title">{{$module->module_name}}</h5>
                                                <p class="card-text">This is a wider card with supporting text below as
                                                    a
                                                    natural lead-in to additional content. This content is a little bit
                                                    longer.</p>
                                                <p class="card-text">
                                                    <small class="text-muted">Last updated 3 mins ago</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-dark text-white">
                    <div class="card-header">注册用户列表</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新增模块</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary">保存</button>
                </div>
            </div>
        </div>
    </div>
@endsection
