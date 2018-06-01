@extends('layouts.app')

@section('content')
    <h1>id = {{ $task->id }} のメッセージ詳細ページ</h1>

    <p>{{ $task->content }}</p>

    {!! link_to_route('tasks.edit', 'このメッセージを編集', ['id' => $task->id]) !!}

@endsection