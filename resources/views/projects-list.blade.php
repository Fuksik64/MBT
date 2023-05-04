@extends('layouts.mbt')
@section('content')
    <form action="{{route('projects.list')}}" class="flex gap-2 items-center mb-4">
        <input type="text" placeholder="Nazwa " class="border border-gray-200 p-2  w-full" name="name"
               value="{{request()->name}}">
        <input type="date" class="border border-gray-200 p-2  w-full" name="start_date"
               value="{{request()->start_date}}">
        <input type="date" class="border border-gray-200 p-2  w-full" name="end_date" value="{{request()->end_date}}">

        <button class="btn btn-primary">Szukaj</button>
    </form>
    <form action="{{route('projects.export')}}" class="flex gap-2 items-center mb-4">
        <input type="hidden" placeholder="Nazwa " class="border border-gray-200 p-2  w-full" name="name"
               value="{{request()->name}}">
        <input type="hidden" class="border border-gray-200 p-2  w-full" name="start_date"
               value="{{request()->start_date}}">
        <input type="hidden" class="border border-gray-200 p-2  w-full" name="end_date" value="{{request()->end_date}}">
        <input type="hidden" class="border border-gray-200 p-2  w-full" name="type" value="pdf">
        <button class="btn btn-primary">EXPORT PDF</button>
    </form>
    <form action="{{route('projects.export')}}" class="flex gap-2 items-center mb-4">
        <input type="hidden" placeholder="Nazwa " class="border border-gray-200 p-2  w-full" name="name"
               value="{{request()->name}}">
        <input type="hidden" class="border border-gray-200 p-2  w-full" name="start_date"
               value="{{request()->start_date}}">
        <input type="hidden" class="border border-gray-200 p-2  w-full" name="end_date" value="{{request()->end_date}}">
        <input type="hidden" class="border border-gray-200 p-2  w-full" name="type" value="xlsx">
        <button class="btn btn-primary">EXPORT XLSX</button>
    </form>
    <div x-data="{show:false,projectId:null}">
        <div x-show="show" class="fixed inset-0 flex justify-center items-center bg-black/80 z-50">
            <form class="bg-white shadow rounded p-16 block relative" x-bind:action="`/projects/send/`+projectId">
                <i class="fa fa-times absolute top-2 right-2 text-2xl text-gray-700 cursor-pointer"
                   x-on:click="show=false"></i>
                <input type="text" placeholder="Email" class="border border-gray-200 p-2 mb-4 w-full" name="email">
                <button class="btn btn-primary">Wyślij</button>
            </form>
        </div>
        <table class="table bg-white border border-gray-200">
            <thead>
            <tr>
                <th> Nazwa projektu</th>
                <th> Data rozpoczęcia</th>
                <th> Data zakończenia</th>
                <th>Grafika</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>
                        {{$project->name}}
                    </td>
                    <td>
                        {{$project->start_date}}
                    </td>
                    <td>
                        {{$project->end_date}}
                    </td>
                    <td>
                        @if($project->file_path)
                            <img src="/storage/{{$project->file_path}}" width="100px" height="100px"/>
                        @endif
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <form method="POST" action="{{route('projects.destroy', $project->id)}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Usuń</button>
                            </form>
                            <a href="{{route('projects.edit.index',$project->id)}}" class="btn btn-warning">Edycja</a>
                            <button class="btn btn-primary" x-on:click="show=true,projectId={{$project->id}}">Wyślij
                            </button>

                        </div>
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

        {{$projects->links()}}
    </div>

@endsection
