@extends('layouts.layout')
@section('header')
    <h1>Добавление статьи</h1>
@endsection
@section('section')
    <form method="post" action="{{route('store')}}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p style="margin-left:200px">{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <p style="margin-left:200px">
            <label>Название: </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 350px;">
        </p>
        <p style="margin-left:200px">
            <label>Описание: </label>
            <input type="text" id="description" name="description" value="{{ old('description') }}" required style="width: 350px;">
        </p>
        <p style="margin-left:200px">
            <label>Дата: </label>
            <input type="date" id="date" name="date" value="{{ old('date') }}" required style="width: 350px;">
        </p>
        <p style="margin-left:200px">
            <label>Количество мест: </label>
            <input type="text" id="number" name="number" value="{{ old('number') }}" required style="width: 350px;">
        </p>
        <p style="margin-left:200px">
            <label>Фото: </label>
            <input id="image" type="file" accept="image/jpg" name="image" required style="width: 350px;">
        </p>
        <p style="margin-left:200px">
            <label>Язык: </label>
            <select id="language_id" name="language_id" required style="width: 350px;">
                @foreach($language as $l)
                    <option value="{{$l->id}}">{{$l->name}}</option>
                @endforeach
            </select>
        </p>
        <p style="margin-left:200px"><input type="submit" value="Добавить" name="submit"></p>
    </form>
@endsection
