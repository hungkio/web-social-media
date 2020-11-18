@extends('layouts.app')

@section('content1')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous"/>
    <style>
        .panel-shadow {
            box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
        }

        .panel-white {
            border: 1px solid #dddddd;
        }

        .panel-white .panel-heading {
            color: #333;
            background-color: #fff;
            border-color: #ddd;
        }

        .panel-white .panel-footer {
            background-color: #fff;
            border-color: #ddd;
        }

        .post .post-heading {
            height: 95px;
            padding: 20px 15px;
        }

        .post .post-heading .avatar {
            width: 60px;
            height: 60px;
            display: block;
            margin-right: 15px;
        }

        .post .post-heading .meta .title {
            margin-bottom: 0;
        }

        .post .post-heading .meta .title a {
            color: black;
        }

        .post .post-heading .meta .title a:hover {
            color: #aaaaaa;
        }

        .post .post-heading .meta .time {
            margin-top: 8px;
            color: #999;
        }

        .post .post-image .image {
            width: 100%;
            height: auto;
        }

        .post .post-description {
            padding: 15px;
        }

        .post .post-description p {
            font-size: 14px;
        }

        .post .post-description .stats {
            margin-top: 20px;
        }

        .post .post-description .stats .stat-item {
            display: inline-block;
            margin-right: 15px;
        }

        .post .post-description .stats .stat-item .icon {
            margin-right: 8px;
        }

        .post .post-footer {
            border-top: 1px solid #ddd;
            padding: 15px;
        }

        .post .post-footer .input-group-addon a {
            color: #454545;
        }

        .post .post-footer .comments-list {
            padding: 0;
            margin-top: 20px;
            list-style-type: none;
        }

        .post .post-footer .comments-list .comment {
            display: block;
            width: 100%;
            margin: 20px 0;
        }

        .post .post-footer .comments-list .comment .avatar {
            width: 35px;
            height: 35px;
        }

        .post .post-footer .comments-list .comment .comment-heading {
            display: block;
            width: 100%;
        }

        .post .post-footer .comments-list .comment .comment-heading .user {
            font-size: 14px;
            font-weight: bold;
            display: inline;
            margin-top: 0;
            margin-right: 10px;
        }

        .post .post-footer .comments-list .comment .comment-heading .time {
            font-size: 12px;
            color: #aaa;
            margin-top: 0;
            display: inline;
        }

        .post .post-footer .comments-list .comment .comment-body {
            margin-left: 50px;
        }

        .post .post-footer .comments-list .comment > .comments-list {
            margin-left: 50px;
        }

        .buttons a {
            color: #828282;
            padding: 5px 10px 5px 10px;
        }

        .button {
            overflow: hidden;
            color: #454545;
            height: 100px;
        }

        .buttons a:hover {
            background-color: #ddd;
            text-decoration: none;
        }

        .far {
            padding: 5px;
        }

        .reply {
            margin-left: 15px;
        }

        .text-blue {
            color: blue!important;
        }
    </style>
    <div class="container bootstrap snippets bootdey">
        <div class="col-sm-12">
            @if($data && $data->isNotEmpty())
                @foreach($data as $post)
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
                                <h6 class="text-muted time">1 minute ago</h6>
                            </div>
                        </div>
                        <div class="post-description" style="padding-top: 0" data-idpost="{{ $post->id }}">
                            <h3>{{ $post->title ?? '' }}</h3>
                            {!! $post->content ?? '' !!}
                            <div class="buttons">
                                <button type="button" class='btn upvote'>
                                    <i class="far fa-thumbs-up"></i><span class="count-upvote">{{ $post->up_vote ?? 0 }}</span> Up Vote
                                </button>

                                <button type="button" class='btn downvote'>
                                    <i class="far fa-thumbs-down"></i><span class="count-downvote">{{ $post->down_vote ?? 0 }}</span> Down vote
                                </button>

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
                @endforeach
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('.upvote').click(function () {
                let post_id = $(this).closest('.post-description').data('idpost')
                if ($(this).hasClass('text-blue')) {
                    $(this).removeClass('text-blue')
                    update_upvote(post_id, {{\App\Vote::REMOVE_VOTE}})
                    let count_upvote = parseInt($('.count-upvote').html())
                    $('.count-upvote').html((count_upvote - 1 ?? 0))
                } else {
                    $(this).addClass('text-blue')
                    update_upvote(post_id, {{\App\Vote::UP_VOTE}})
                    let count_upvote = parseInt($('.count-upvote').html())
                    $('.count-upvote').html(count_upvote + 1)
                }
            })

            $('.downvote').click(function () {
                let post_id = $(this).closest('.post-description').data('idpost')
                if ($(this).hasClass('text-danger')) {
                    $(this).removeClass('text-danger')
                    update_upvote(post_id, {{\App\Vote::REMOVE_VOTE}})
                    let count_downvote = parseInt($('.count-downvote').html())
                    $('.count-downvote').html((count_downvote - 1 ?? 0))
                } else {
                    $(this).addClass('text-danger')
                    update_upvote(post_id, {{\App\Vote::DOWN_VOTE}})
                    let count_downvote = parseInt($('.count-downvote').html())
                    $('.count-downvote').html(count_downvote + 1)
                }
            })
        })

        function update_upvote(post_id, vote)
        {
            $.ajax({
                url: '{{ route('vote.update') }}',
                method: 'post',
                data: {
                    'post_id' : post_id,
                    'vote' : vote
                },
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
            })
        }
    </script>
@endsection
