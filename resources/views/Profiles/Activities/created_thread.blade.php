<div class="card">
    <div class="card-header">
        {{$profile_user->name}} published <a href="{{ $activity->subject->path() }}">{{$activity->subject->title}}</a>
    </div>
    <div class="card-body">

        {{ $activity->subject->body }}

    </div>
</div>