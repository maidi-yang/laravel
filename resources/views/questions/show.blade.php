@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->title }}
                    @foreach($question->topics as $topic)
                        <a  class="topic pull-right" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                    @endforeach
                    </div>
                    <div class="panel-body content">
                        {!!  $question->body !!}  {{--使用{{！！！！}} 来解析标签--}}
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/questions/{{ $question->id }}/edit">编辑</a></span>
                            <form action="/questions/{{ $question->id }}" method="post" class="delete-form">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                        @endif
                            <comments type="question"
                                      model="{{$question->id}}"
                                      count="{{$question->comments()->count()}}"
                            ></comments>
                    </div>
                </div>
            </div>
            @if(Auth::check())
            <div class="col-md-3">
                <div class="panel penel-default">
                    <div class="panel-heading question-follow">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="panel-body">
                        <question-follow-button question="{{$question->id}}"></question-follow-button>
                        <a href="#editor" class="btn btn-primary pull-right">撰写答案</a>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $question->answers_count }}个答案
                    </div>
                    <div class="panel-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <user-vote-button answer="{{$answer->id}}" count="{{$answer->votes_count}}"></user-vote-button>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="/questions/{{ $answer->id }}">
                                            {{$answer->user->name }}
                                        </a>
                                    </h4>
                                    {!! $answer->body !!}
                                </div>
                                <comments type="answer"
                                          model="{{$answer->id}}"
                                          count="{{$answer->comments()->count()}}"
                                ></comments>
                            </div>
                        @endforeach
                        @if(Auth::check())
                        <form action="/questions/{{ $question->id }}/answer" method="post">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <script id="container" name="body" style="height:120px" type="text/plain" style="height:200px;">
                                    {!! old('body')  !!}
                                </script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <button class="btn btn-success pull-right" type="submit">提交答案</button>
                        </form>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-success btn-block">登陆提交答案</a>
                        @endif
                    </div>
                </div>
            </div>
                <div class="col-md-3">
                    <div class="panel penel-default">
                        <div class="panel-heading question-follow">
                            <h5>关于作者</h5>
                        </div>
                        <div class="panel-body">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img src="{{$question->user->avatar}}" alt="{{$question->user->name}}" width="36">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">
                                            {{$question->user->name}}
                                        </a>
                                    </h4>
                                </div>
                                <div class="user-statics">
                                    <div class="statics-item text-center">
                                        <div class="statics-text">问题</div>
                                        <div class="statics-count">{{ $question->user->questions_count }}</div>
                                    </div>
                                    <div class="statics-item text-center">
                                        <div class="statics-text">回答</div>
                                        <div class="statics-count">{{ $question->user->answers_count }}</div>
                                    </div>
                                    <div class="statics-item text-center">
                                        <div class="statics-text">关注者</div>
                                        <div class="statics-count">{{ $question->user->followers_count }}</div>
                                    </div>
                                </div>
                            </div>
                            @if(Auth::check())
                            <div class="panel-body">
                                <user-follow-button user="{{$question->user_id}}"></user-follow-button>
                                <send-message user="{{$question->user_id}}"></send-message>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
    @section('js')
        @include('vendor.ueditor.assets')
        <script type="text/javascript">
            var ue = UE.getEditor('container',{
                toolbars: [
                    ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
                ],
                elementPathEnabled: false,
                enableContextMenu: false,
                autoClearEmptyNode:true,
                wordCount:false,
                imagePopup:false,
                autotypeset:{ indent: true,imageBlockLine: 'center' }
            });
            ue.ready(function() {
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
            });
        </script>
    @endsection;
@endsection
