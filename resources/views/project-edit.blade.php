@extends('layouts.mbt')
@section('content')
    <form class="p-4 shadow bg-white rounded d-flex flex-column gap-2" method="POST" action="{{route('projects.update',$project->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input placeholder="Nazwa projektu" class="border border-gray-200 rounded p-2 block " name="name" value="{{$project->name}}"/>
        @error('name')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
        <input type="date" class="border border-gray-200 rounded p-2 " name="start_date" value="{{$project->start_date}}"/>
        @error('start_date')
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
        <input type="date" class="border border-gray-200 rounded p-2 " name="end_date" value="{{$project->end_date}}"/>
        @error('end_date')
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
        <textarea class="border border-gray-200 rounded p-2 " name="description" placeholder="Opis" value="{{$project->descripiton}}">

        </textarea>
        @error('description')
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
        <input type="file" name="file"/>
        @error('file')
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
        <button class="btn btn-primary">Edytuj projekt</button>
    </form>
@endsection
