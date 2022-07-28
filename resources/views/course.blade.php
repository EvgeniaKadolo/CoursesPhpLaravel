@extends('layouts.layout')
@section('header')
    <header>
        <h4>{{$title}}</h4>
        <article>
            <div class="twelve columns">
                <h1>{{$course->name}}</h1>
                <p class="excerpt">
                    Начало курса: {{$course->date}}
                </p>
                <p class="excerpt">
                    Количество мест: {{$course->number}}
                </p>
            </div>
        </article>
    </header>
@endsection
@section('section')
    <section class="section_light">
        <div class="row">
            <p><img src="{{asset('images/'.$course->image)}}" alt="desc" width=400 align=left hspace=30>
                {{$course->description}}
            </p>
        </div>
    </section>
    @if (session('success'))
        <div style="margin-left: 200px">
            {{ session('success') }}
        </div>
    @endif
        <form action="{{route('record', $course)}}" method="post">
            @csrf
            <input type="submit" value="Записаться" style="margin-left:200px">
        </form>
        @canany('list_records')
            <form action="{{route('list_records', $course)}}" method="post">
                @csrf
                <input type="submit" value="Показать записи на курс" style="margin-left:200px">
            </form>
        @endcan
        @if (session('users') && !empty(session('users')))
            @foreach(session('users') as $user)
                <div style="margin-left: 200px">
                    <form action="{{route('delete_user', ['user' => $user, 'course' => $course])}}" method="post">
                        @method('DELETE')
                        @csrf
                        {{ $user->first_name}} {{$user->last_name }}
                        <input type="submit" value="Удалить">
                    </form>
                </div>
            @endforeach
        @elseif (session('info'))
            <div style="margin-left: 200px">{{session('info')}}</div>
        @endif
@endsection
