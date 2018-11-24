@php $reply_id = $activity->subject->favorite_id;
$reply = \App\Models\Reply::find($reply_id);
@endphp

<div class="card">
    <div class="card-header">
        <a href="{{ $reply->path() }}">
        {{$profile_user->name}} Favorited a Reply
        </a>

    </div>

    <div class="card-body">

        {{ $reply->body }}
    </div>
</div>
