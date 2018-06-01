@extends('layouts.app')

@section('content')

    <h1>id = {{ $task->id }} のタスクの詳細ページ</h1>

    <p>{{ $task->content }}</p>

@endsection