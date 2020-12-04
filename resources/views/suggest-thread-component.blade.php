<style>
    .card_ {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
        border: 1px solid #ccc;
        border-radius: 7px;
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
        background: linear-gradient(246.35deg, rgb(215, 46, 51) 0%, rgb(168, 36, 85) 100%);
        color: white;
        border-top-left-radius: 7px;
        border-top-right-radius: 7px;
    }

    .list-unstyled li:first-child {
        padding-top: 0.6em;
    }
    .view-all {
        font-size: 16px!important;
        width: 80%;
        border-radius: 20px;
    }

    .img-thread {
        width: 30px;
        height: 30px;
        display: block;
        margin-left: 1.5em;
        border-radius: 50%;
    }

</style>
<div class="card_">
    <div class="avatar_edit">
        <h4 class="mt-0 p-4">Some Threads You Might Like</h4>
    </div>
    <div>
        @if($suggest_threads)
            <ul class="list-unstyled components text-left">
                @foreach($suggest_threads as $thread)
                    <li>
                        <a class="d-inline-flex" href="{{ route('threads.post', $thread->id) }}">
                            <img class="img-thread" src="{{ asset('storage/users-avatar/' . $thread->avatar) }}" alt="">
                            <h5><b class="pl-3">{{ ucwords($thread->name) }}</b></h5>
                        </a>
                    </li>
                    <hr>
                @endforeach
                    <li class="text-center"><a href="{{ route('threads.index') }}" class="btn btn-success view-all"><b>View All</b></a></li>
            </ul>
        @endif
    </div>
</div>

