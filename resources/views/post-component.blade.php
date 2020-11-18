<div class="panel panel-white post panel-shadow">
    <div class="post-heading">
        <div class="pull-left image">
            <img src="https://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar"
                 alt="user profile image">
        </div>
        <div class="pull-left meta">
            <div class="title h5">
                <a href="#"><b>{{ $post->user->name ?? '' }}</b></a>
                made a post.
            </div>
            <h6 class="text-muted time">{{ $post->diff_time ?? '' }}</h6>
        </div>
    </div>
    <div class="post-description" style="padding-top: 0" data-idpost="{{ $post->id }}">
        <h3>{{ $post->title ?? '' }}</h3>
        {!! $post->content ?? '' !!}
        <div class="buttons">
            <button type="button" class='btn upvote
@if($post->votes()->where('type', \App\Vote::UP_VOTE)->get()->contains('user_id', auth()->id())) text-blue @endif'>
                <i class="far fa-thumbs-up"></i><span
                    class="count-upvote">{{ $post->votes()->where('type', \App\Vote::UP_VOTE)->count() ?? 0 }}</span>
                Up Vote
            </button>

            <button type="button" class='btn downvote
@if($post->votes()->where('type', \App\Vote::DOWN_VOTE)->get()->contains('user_id', auth()->id())) text-danger @endif'>
                <i class="far fa-thumbs-down"></i><span
                    class="count-downvote">{{ $post->votes()->where('type', \App\Vote::DOWN_VOTE)->count() ?? 0 }}</span>
                Down vote
            </button>

            @if($post->user_id == auth()->id())
                <button type="button" class='btn float-right delete_post'>
                    <a href="{{ route('post.delete', $post->id) }}">
                        <i class="far fa-trash-alt"></i>Delete
                    </a>
                </button>

                <button type="button" class='btn float-right'>
                    <a href="{{ route('post.edit', $post->id) }}">
                        <i class="fas fa-edit"></i>Edit
                    </a>
                </button>
            @endif
            <button type="button" class="btn dropdown float-right">
                                    <span class='button' id="dropdownMenuButton" data-toggle="dropdown"
                                          aria-haspopup="true" aria-expanded="false"><i
                                            class="far fa-share-square"></i>Share</span>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </button>

            <button type="button" class='btn float-right'>
                <i class="far fa-comment-alt"></i>
                {{ $post->comments->count() ?? 0 }} Comments
            </button>
        </div>
    </div>
    {{--                        <div class="post-footer">--}}
    {{--                            <div class="input-group">--}}
    {{--                                <input class="form-control" placeholder="Add a comment" type="text">--}}
    {{--                                <span class="input-group-addon"><a href="#"><i class="fa fa-edit"></i></a></span>--}}
    {{--                            </div>--}}
    {{--                            <ul class="comments-list">--}}
    {{--                                <li class="comment">--}}
    {{--                                    <a class="pull-left" href="#">--}}
    {{--                                        <img class="avatar" src="https://bootdey.com/img/Content/user_1.jpg"--}}
    {{--                                             alt="avatar">--}}
    {{--                                    </a>--}}
    {{--                                    <div class="comment-body">--}}
    {{--                                        <div class="comment-heading">--}}
    {{--                                            <h4 class="user">Gavino Free</h4>--}}
    {{--                                            <h5 class="time">5 minutes ago</h5>--}}
    {{--                                        </div>--}}
    {{--                                        <p>Sure, oooooooooooooooohhhhhhhhhhhhhhhh</p>--}}
    {{--                                    </div>--}}
    {{--                                    <ul class="comments-list">--}}
    {{--                                        <li class="comment">--}}
    {{--                                            <a class="pull-left" href="#">--}}
    {{--                                                <img class="avatar" src="https://bootdey.com/img/Content/user_3.jpg"--}}
    {{--                                                     alt="avatar">--}}
    {{--                                            </a>--}}
    {{--                                            <div class="comment-body">--}}
    {{--                                                <div class="comment-heading">--}}
    {{--                                                    <h4 class="user">Ryan Haywood</h4>--}}
    {{--                                                    <h5 class="time">3 minutes ago</h5>--}}
    {{--                                                </div>--}}
    {{--                                                <p>Relax my friend</p>--}}
    {{--                                            </div>--}}
    {{--                                        </li>--}}
    {{--                                        <li class="comment">--}}
    {{--                                            <a class="pull-left" href="#">--}}
    {{--                                                <img class="avatar" src="https://bootdey.com/img/Content/user_2.jpg"--}}
    {{--                                                     alt="avatar">--}}
    {{--                                            </a>--}}
    {{--                                            <div class="comment-body">--}}
    {{--                                                <div class="comment-heading">--}}
    {{--                                                    <h4 class="user">Gavino Free</h4>--}}
    {{--                                                    <h5 class="time">3 minutes ago</h5>--}}
    {{--                                                </div>--}}
    {{--                                                <p>Ok, cool.</p>--}}
    {{--                                            </div>--}}
    {{--                                        </li>--}}
    {{--                                        <a class="pull-left" href="#">--}}
    {{--                                            <img class="avatar" src="https://bootdey.com/img/Content/user_1.jpg"--}}
    {{--                                                 alt="avatar">--}}
    {{--                                        </a>--}}
    {{--                                        <input class='reply' placeholder="write ur reply..." type="text">--}}


    {{--                                    </ul>--}}
    {{--                                </li>--}}
    {{--                            </ul>--}}
    {{--                        </div>--}}
</div>
