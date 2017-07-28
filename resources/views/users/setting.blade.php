@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">设置个人信息</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="/setting">
                            {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">现居城市</label>

                                <div class="col-md-6">
                                    <input id="old_password" type="text" class="form-control" name="city" value="{{ isset(user()->settings['city'])?user()->settings['city']:'' }}" required>

                                    @if ($errors->has('city'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">个人简介</label>

                                <div class="col-md-6">
                                    <textarea id="bio" class="form-control" name="bio">{{ isset(user()->settings['bio'])?user()->settings['bio']:'' }}</textarea>
                                    @if ($errors->has('bio'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        更新资料
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
