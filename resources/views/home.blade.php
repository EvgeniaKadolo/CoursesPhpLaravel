@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Личный кабинет') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div>
                                            <a href="#" class="th"><img src="{{asset('images/'.Auth::user()->photo)}}"
                                                                        alt="desc" width="150px"
                                                                        style="float:left; margin-right:10px;"/></a>
                                            <div>Имя: {{Auth::user()->first_name}}</div>
                                            <div>Фамилия: {{Auth::user()->last_name}}</div>
                                            <div>Логин: {{Auth::user()->login}}</div>
                                            <div>Email: {{Auth::user()->email}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <section>
                            @if (session('success'))
                                <div style="margin-left: 200px">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (!empty($courses))
                                <div style="margin-left: 270px">
                                    Вы записаны на:
                                </div>
                                @foreach($courses as $course)
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="card">
                                                    {{$course->name}} - {{$course->date}}

                                                    <form action="{{route('unsubscribe', ['course' => $course])}}"
                                                          method="post">
                                                        @csrf
                                                        <input type="submit" value="Отписаться">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
