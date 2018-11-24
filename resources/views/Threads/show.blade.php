@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h3 style="float: left"><a
                                    href="{{ $thread->path() }}">{{ $thread->title }}</a></h3>

                        @can('update', $thread)
                            <form action="{{ $thread->path() }}" method="post" style="float: right;">
                                @csrf
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-danger">Delete Thread</button>
                            </form>
                        @endcan
                    </div>

                    <div class="card-body">

                        {{ $thread->body }}

                    </div>
                </div>
                <br>

                @foreach($replies as $reply)

                    <reply inline-template :attributes="{{$reply}}">

                        <div class="card" id="reply-{{$reply->id}}">
                            <div class="card-header">
                                <h5 style="display: flex; flex: 1; float: left">
                                    <a href="{{ route('profile', $reply->owner->name) }}">
                                        {{ $reply->owner->name }}
                                    </a> said {{ $reply->created_at->diffForHumans() }}
                                </h5>

                                <favorite :reply="{{ $reply }}"></favorite>

                            </div>


                            <div class="card-body">
                                <div v-if="editing">
                                    <div class="form-group">
                                        <textarea class="form-control" v-model="body">{{$reply->body}}</textarea>
                                    </div>

                                    <button class="btn btn-primary" @click="update">Update</button>
                                    <button class="btn btn-warning" @click="editing=false">Cancel</button>

                                </div>
                                <div v-else v-text="body"></div>


                            </div>

                            @can('update', $reply)
                                <div class="card-footer">
                                    <button class="btn btn-primary" style="float: right" @click="editing = true">Edit
                                    </button>
                                    <button type="submit" class="btn btn-danger" @click="destroy">Delete</button>
                                </div>
                            @endcan

                        </div>
                    </reply>

                @endforeach
                <br>
                {{ $replies->links() }}

                @if(auth()->check())
                    <form action="{{ $thread->path() }}/addReply" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="body">Body: </label>
                            <textarea name="body" id="body" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>

                    </form>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by <a
                                    href="#"> {{ $thread->owner->name }}</a>, and currently
                            has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies->count()) }}.
                        </p>

                        @if(!$thread->isSubscribed)
                            <p>
                            <form action="{{ $thread->path() }}/subscription" method="POST">
                                @csrf
                                <button class="btn btn-primary" name="submit">Subscribe</button>
                            </form>

                        @else
                            <form action="{{ $thread->path() }}/subscription" method="POST">
                                @csrf
                                {{method_field('delete')}}
                                <button class="btn btn-warning" name="submit">UnSubscribe</button>
                            </form>
                            </p>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
