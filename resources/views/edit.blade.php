@extends('layouts.layout')
@section('header')
    <h1>Редактирование статьи</h1>
@endsection
@section('section')
    <form method="post" action="{{route('edit', $course->id)}}">
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
            <input type="text" id="name" name="name" required style="width: 350px;" value="{{$course->name}}">
        </p>
        <p style="margin-left:200px">
            <label>Описание: </label>
            <input type="text" id="description" name="description" required style="width: 350px;" value="{{$course->description}}">
        </p>
        <p style="margin-left:200px">
            <label>Дата: </label>
            <input type="date" id="date" name="date" required style="width: 350px;" value="{{$course->date}}">
        </p>
        <p style="margin-left:200px">
            <label>Количество мест: </label>
            <input type="text" id="number" name="number" required style="width: 350px;" value="{{$course->number}}">
        </p>
        <p style="margin-left:200px">
            <label>Фото: </label>
            <input id="image" type="file" accept="image/jpg" name="image" style="width: 350px;">
        </p>
        <p style="margin-left:200px">
            <label>Язык: </label>
            <select id="language_id" name="language_id" required style="width: 350px;">
                @foreach($language as $l)
                    <option value="{{$l->id}}" @if($course->language_id == $l->id) selected @endif>{{$l->name}}</option>
                @endforeach
            </select>
        </p>
        <p style="margin-left:200px"><input type="submit" value="Изменить" name="submit"></p>
    </form>
@endsection
