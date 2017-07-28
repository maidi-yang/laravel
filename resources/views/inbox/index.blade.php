@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">私信列表</div>
                    <div class="panel-body">
                        @foreach($messages as  $messagesGruop)
                            <div class="media {{ $messagesGruop->first()->shouldAddUnreadClass() ?  'unread' : ''}}" >
                                <div class="media-left">
                                    <a href="#">
                                        @if(Auth::id() == $messagesGruop->last()->from_user_id)
                                            <img src="{{ $messagesGruop->last()->toUser->avatar }}" alt="" width="40">
                                        @else
                                            <img src="{{ $messagesGruop->last()->fromUser->avatar }}" alt="" width="40">
                                        @endif
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">
                                            @if(Auth::id() == $messagesGruop->last()->from_user_id)
                                                {{ $messagesGruop->last()->toUser->name }}
                                            @else
                                                {{ $messagesGruop->last()->fromUser->name }}
                                            @endif
                                        </a>
                                    </h4>
                                    <p><a href="inbox/{{ $messagesGruop->last()->dialog_id }}">
                                            {{ $messagesGruop->first()->body }}
                                        </a> </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
