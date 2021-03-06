<style>
    .card_ {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: white!important;
    }

    .title_ {
        color: grey;
        font-size: 14px;
    }

    .card_ button, label {
        border: none;
        outline: 0;
        display: inline-block;
        padding: 8px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }

    .card_ a {
        text-decoration: none;
        font-size: 22px;
        color: black;
    }

    .card_ button:hover, a:hover {
        opacity: 0.7;
    }

    .avatar_edit {
        position: relative;
    }

    .avatar_edit img {
        border-radius: 50%;
        width: 14em;
        height: 14em;
        padding-top: 10px;
    }

    .btn_avatar {
        border-radius: 50%;
        height: 36px;
        width: 36px !important;
        position: absolute;
        bottom: -4px;
        right: 12px;
    }

    .card_ label {
        cursor: pointer;
        /* Style as you please, it will become the visible UI component. */
    }

    .card_ #upload-photo {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }
</style>
<div class="card_">
    <div class="avatar_edit">
        <img src="{{ asset('/storage/users-avatar/' . $post->thread->avatar) }}" alt="John">
    </div>
    <h2>{{ $post->thread->name }}</h2>
    <p class="title_">{{ $post->thread->description ?? '' }}</p>
    <p class="title_">
        @if($post->thread->members->count() > 1)
            {{ $post->thread->members->count() . ' Members' }}
        @else
            {{ $post->thread->members->count() . ' Member' }}
        @endif
    </p>
</div>

