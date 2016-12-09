@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">My tasks</div>

                <div class="list-group">
@foreach($tasks as $task)
                    <a class="list-group-item" href="{{ $task->url }}" target="_blank">
                        <h4 class="list-group-item-heading">{{ $task->title }}</h4>
                        <p class="list-group-item-text">
                            担当者:
@foreach($task->assignee as $assignee)
                            {{ $assignee->name }}@if(!$loop->last),@endif
@endforeach
                        </p>
                    </a>
@endforeach
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="list-group">
@foreach($users as $user)
                    <div class="list-group-item">
                        {{ $user->name }} &lt;{{ $user->email }}&gt;
                    </div>
@endforeach
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Apps</div>

                <div class="list-group">
@foreach($apps as $app)
                    <div class="list-group-item">
                        <table class="table" style="margin: 0;">
                            <thead>
                                <tr><td>Name</td><td>{{ $app->name }}</td></tr>
                            </thead>
                            <tbody>
                                <tr><td>Crawler</td><td>{{ $app->crawler }}</td></tr>
@foreach($app->config as $key => $value)
                                <tr><td>{{ $key }}</td><td>{{ $value }}</td></tr>
@endforeach
                            </tbody>
                        </table>
                    </div>
@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
