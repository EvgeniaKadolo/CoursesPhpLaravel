@extends('layouts.layout')
@section('header')
    <h1>{{$header}}</h1>
@endsection
@section('section')
    <section>
        <form method="post" action="{{route('filter')}}">
            @csrf
            <select id="filter" name="filter" style="margin-left: 200px; width: 100px;">
                <option value="1">активна</option>
                <option value="2">прошла</option>
                <option value="3">нет мест</option>
            </select>
            <input type="submit" value="Применить">
        </form>
        <div class="section_main">
            @if (session('success'))
                <div style="margin-left: 200px">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <section class="eight columns">
                    @foreach($courses as $course)
                        <article class="blog_post">
                            <div class="three columns">
                                <a href="#" class="th"><img src="{{asset('images/'.$course->image)}}" alt="desc"/></a>
                            </div>
                            <div class="nine columns">
                                <a href="/course/{{$course->id}}">
                                    <h4>{{$course->name}}</h4>
                                </a>
                                <p>{{$course->description}}</p>
                                @canany(['delete', 'edit'])
                                    <form action="{{route('delete', $course->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <input type="submit" value="Удалить">
                                    </form>
                                    <a href="/change/{{$course->id}}">
                                        <input type="submit" value="Редактировать">
                                    </a>
                                @endcan
                                <p>
                                    <form action="{{route('record', $course)}}" method="post">
                                        @csrf
                                        <input type="submit" value="Записаться">
                                    </form>
                                </p>
                            </div>
                        </article>
                    @endforeach
                </section>
                @can('store')
                    <section class="four columns">
                        <H3> &nbsp; </H3>
                        <div class="panel">
                            <h3>Админ-панель</h3>
                            <ul class="accordion">
                                <li class="active">
                                    <div class="title">
                                        <a href="/add">
                                            <h5>Добавить статью</h5>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </section>
                @endcan
            </div>
        </div>
        <section>

            <div class="section_dark">
                <div class="row">

                    <h2></h2>

                    <div class="two columns">
                        <img src="{{asset('images/thumb1.jpg')}}" alt="desc"/>
                    </div>

                    <div class="two columns">
                        <img src="{{asset('images/thumb2.jpg')}}" alt="desc"/>
                    </div>

                    <div class="two columns">
                        <img src="{{asset('images/thumb3.jpg')}}" alt="desc"/>
                    </div>

                    <div class="two columns">
                        <img src="{{asset('images/thumb4.jpg')}}" alt="desc"/>
                    </div>

                    <div class="two columns">
                        <img src="{{asset('images/thumb5.jpg')}}" alt="desc"/>
                    </div>

                    <div class="two columns">
                        <img src="{{asset('images/thumb6.jpg')}}" alt="desc"/>
                    </div>
                </div>
            </div>
        </section>
@endsection
