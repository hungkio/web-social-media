<div class="panel panel-white post panel-shadow"  data-idpost="{{ $post->id }}">
    <div class="post-heading">
        <div class="pull-left image">
            <img src="https://bootdey.com/img/Content/user_1.jpg" class="img-circle avatar"
                 alt="user profile image">
        </div>
        <div class="pull-left meta">
            <div class="title h5">
                <a href="{{ route('post.user_post', $post->user->id) }}"><b>{{ $post->user->name ?? '' }}</b></a>
                made a post.
            </div>
            <h6 class="text-muted time">{{ $post->diff_time ?? '' }}</h6>
        </div>
    </div>
    <div class="post-description" style="padding-top: 0">
        <h3>{{ $post->title ?? '' }}</h3>
        {!! $post->content ?? '' !!}
        <div class="buttons">
            <button type="button" class='btn upvote
@if($post->votes()->whereNull('comment_id')->where('type', \App\Vote::UP_VOTE)->get()->contains('user_id', auth()->id())) text-blue @endif'>
                <i class="far fa-thumbs-up"></i><span
                    class="count-upvote">{{ $post->votes()->whereNull('comment_id')->where('type', \App\Vote::UP_VOTE)->count() ?? 0 }}</span>
                Up Vote
            </button>

            <button type="button" class='btn downvote
@if($post->votes()->whereNull('comment_id')->where('type', \App\Vote::DOWN_VOTE)->get()->contains('user_id', auth()->id())) text-danger @endif'>
                <i class="far fa-thumbs-down"></i><span
                    class="count-downvote">{{ $post->votes()->whereNull('comment_id')->where('type', \App\Vote::DOWN_VOTE)->count() ?? 0 }}</span>
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
                    <a class="dropdown-item url-post" data-url_post="{{ route('post.comment', $post->id) }}"><i class="fas fa-link"></i> Copy Link</a>
                </div>
            </button>

            <a href="{{ route('post.comment', $post->id) }}" type="button" class='btn float-right'>
                <i class="far fa-comment-alt"></i>
                @if($post->comments->count())
                    @if($post->comments->count() > 1)
                        {!! '<span class="count_comment">' . $post->comments->count() . '</span> Comments' !!}
                    @else
                        {!! '<span class="count_comment">' . $post->comments->count() . '</span> Comment' !!}
                    @endif
                @else
                    <span class="count_comment">0</span> Comment
                @endif
            </a>
        </div>
    </div>
    @if(isset($has_comment) && $comments)
        <div class="post-footer">
            <div class="input-group">
                <input class="form-control common-comment" placeholder="Add a comment" type="text">
            </div>
            <ul class="comments-list">
                <li class="comment new-comment"></li>
                @foreach($comments as $comment)
                    <li class="comment comment-reply-top">
                        <a class="pull-left" href="#">
                            <img class="avatar" src="https://bootdey.com/img/Content/user_1.jpg"
                                 alt="avatar">
                        </a>
                        <div class="comment-body">
                            <div class="comment-heading">
                                <h4 class="user">{{ $comment->user->name ?? '' }}</h4>
                                <h5 class="time">{{ $comment->diff_time }}</h5>
                            </div>
                            <p class="mb-0">{{ $comment->content ?? '' }}</p>
                            <div class="buttons">
                                <button type="button" class='btn upvote
@if($comment->votes()->whereNotNull('comment_id')->where('type', \App\Vote::UP_VOTE)->get()->contains('user_id', auth()->id())) text-blue @endif'
                                        data-comment_id="{{ $comment->id }}">
                                    <i class="far fa-thumbs-up"></i><span
                                        class="count-upvote">{{ $comment->votes()->whereNotNull('comment_id')->where('type', \App\Vote::UP_VOTE)->count() ?? 0 }}</span>
                                    Up Vote
                                </button>

                                <button type="button" class='btn downvote
@if($comment->votes()->whereNotNull('comment_id')->where('type', \App\Vote::DOWN_VOTE)->get()->contains('user_id', auth()->id())) text-danger @endif'
                                        data-comment_id="{{ $comment->id }}">
                                    <i class="far fa-thumbs-down"></i><span
                                        class="count-downvote">{{ $comment->votes()->whereNotNull('comment_id')->where('type', \App\Vote::DOWN_VOTE)->count() ?? 0 }}</span>
                                    Down vote
                                </button>

                                <button type="button" class='btn reply' data-comment_id="{{ $comment->id }}">
                                    <i class="far fa-comment-alt"></i>Reply
                                </button>

                                @if($post->user_id == auth()->id() || $comment->user_id == auth()->id())
                                    <button type="button" class='btn float-right delete_comment'>
                                        <a href="{{ route('post.delete_comment', $comment->id) }}">
                                            <i class="far fa-trash-alt"></i>Delete
                                        </a>
                                    </button>
                                @endif
                            </div>
                            <span class="reply-append d-none">
                                <a class="pull-left" href="#">
                                    <img class="avatar" src="https://bootdey.com/img/Content/user_1.jpg" alt="avatar">
                                </a>
                                <input class='reply' placeholder="write ur reply..." type="text"
                                       data-parent_id="{{ $comment->id }}">
                            </span>
                        </div>
                        <ul class="comments-list">
                            <li class="comment reply-comment"></li>
                            @if(isset($comment->sub_comment))
                                <?php $comments = $comment->sub_comment; ?>
                                @foreach($comments as $sub_comment)
                                    <li class="comment">
                                        <a class="pull-left" href="#">
                                            <img class="avatar" src="https://bootdey.com/img/Content/user_2.jpg"
                                                 alt="avatar">
                                        </a>
                                        <div class="comment-body">
                                            <div class="comment-heading">
                                                <h4 class="user">{{ $sub_comment->user->name ?? '' }}</h4>
                                                <h5 class="time">{{ $sub_comment->diff_time }}</h5>
                                            </div>
                                            <p class="mb-0"><b>{{ $sub_comment->userReply->name ?? '' }} </b>{{ $sub_comment->content ?? '' }}</p>
                                            <div class="buttons">
                                                <button type="button" class='btn upvote
@if($sub_comment->votes()->whereNotNull('comment_id')->where('type', \App\Vote::UP_VOTE)->get()->contains('user_id', auth()->id())) text-blue @endif'
                                                        data-comment_id="{{ $sub_comment->id }}">
                                                    <i class="far fa-thumbs-up"></i><span
                                                        class="count-upvote">{{ $sub_comment->votes()->whereNotNull('comment_id')->where('type', \App\Vote::UP_VOTE)->count() ?? 0 }}</span>
                                                    Up Vote
                                                </button>

                                                <button type="button" class='btn downvote
@if($sub_comment->votes()->whereNotNull('comment_id')->where('type', \App\Vote::DOWN_VOTE)->get()->contains('user_id', auth()->id())) text-danger @endif'
                                                        data-comment_id="{{ $sub_comment->id }}">
                                                    <i class="far fa-thumbs-down"></i><span
                                                        class="count-downvote">{{ $sub_comment->votes()->whereNotNull('comment_id')->where('type', \App\Vote::DOWN_VOTE)->count() ?? 0 }}</span>
                                                    Down vote
                                                </button>

                                                <button type="button" class='btn reply'
                                                        data-comment_id="{{ $sub_comment->id }}">
                                                    <i class="far fa-comment-alt"></i>Reply
                                                </button>

                                                @if($post->user_id == auth()->id() || $sub_comment->user_id == auth()->id())
                                                    <button type="button" class='btn float-right delete_comment'>
                                                        <a href="{{ route('post.delete_comment', $sub_comment->id) }}">
                                                            <i class="far fa-trash-alt"></i>Delete
                                                        </a>
                                                    </button>
                                                @endif
                                            </div>
                                            <span class="reply-append d-none">
                                                <a class="pull-left" href="#">
                                                    <img class="avatar" src="https://bootdey.com/img/Content/user_1.jpg"
                                                         alt="avatar">
                                                </a>
                                                <input class='reply' placeholder="write ur reply..." type="text"
                                                       data-parent_id="{{ $comment->id }}"
                                                       data-user_reply="{{ $sub_comment->user_id }}"
                                                       data-user_reply_name="{{ $sub_comment->user->name ?? '' }}"
                                                >
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
