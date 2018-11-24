@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Forum Threads</div>

                    <div class="card-body">

                        @forelse($threads as $thread)

                            <article>
                                <div class="level" style="display: flex; align-items: center;">

                                    <h4 style="flex: 1"> <a href="{{ route('profile', $thread->owner->name) }}">{{ $thread->owner->name }}</a> posted:
                                        <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                    </h4>

                                    @can('update', $thread)
                                        <form action="{{ $thread->path() }}" method="post" style="float: right;">
                                            @csrf
                                            {{ method_field('DELETE') }}

                                            <button type="submit" class="btn btn-danger">Delete Thread</button>
                                        </form>
                                    @endcan

                                    <strong>{{ $thread->replies->count() }} {{ str_plural('reply', $thread->replies->count()) }}</strong>
                                </div>
                                <div class="body">{{ $thread->body }}</div>


                            </article>
                            <hr>

                        @empty
                            <p>There are no relevant results at this time.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
