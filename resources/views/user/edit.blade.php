@extends('layouts.app')

@section('template_title')
    Update User
@endsection

@section('content')
 
    <section class="content container-fluid">
    @if (session('info'))
        <div class="alert alert-success">
            <strong>
                {{session('info')}}
            </strong>
        </div>
    @endif
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Update User</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf
                            <div class="form-group">
        @foreach ($roles as $rol)

                                    <label for="">
                                        {!! Form::checkbox('roles[]',$rol->id,null,['class'=>'mr-1']) !!} 
                                        {{$rol->name}}
                                    </label>
        @endforeach

                                </div>
                            @include('user.form')
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
