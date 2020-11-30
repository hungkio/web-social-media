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
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <div class="container bootstrap snippets bootdey list-post">
        <div class="col-sm-12">
            <div class="panel panel-white post panel-shadow">
                <div class="post-heading">
                    <div class="pull-left meta">
                        <div class="title h5">
                            <h3>{{ ucwords($thread->name) }} - {{ ucwords($thread->description) }}</h3>
                        </div>
                    </div>
                    <div class="float-right mt-3">
                        @if(auth()->id())
                            @if($thread->user_id != auth()->id())
                                @if($is_join)
                                    <button class="btn btn-default btn-join btn-success">Leave
                                    </button>
                                @else
                                    <button class="btn btn-default btn-join"><span
                                            class="glyphicon glyphicon-plus"></span>
                                        Join
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('threads.manage', $thread->id) }}"
                                   class="btn btn-success mr-3">Manage
                                </a>
                                <a href="{{ route('threads.delete', $thread->id) }}"
                                   class="btn btn-danger delete-thread">Delete
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-10 list-post-append">
            @if($data && $data->isNotEmpty())
                @foreach($data as $post)
                    @include('post-component')
                @endforeach
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            init()

            $('.btn-join').click(function () {
                let btn_text = $(this).text()
                let thread_id = '{{ $thread->id }}'
                if (btn_text.trim() == 'Join') {
                    $(this).html('Leave');
                    $(this).addClass('btn-success');
                    let is_join = 1;
                    join_thread(is_join, thread_id)
                }
                if (btn_text.trim() == 'Leave') {
                    $(this).html('<span class="glyphicon glyphicon-plus"></span> Join')
                    $(this).removeClass('btn-success')
                    let is_join = 0;
                    join_thread(is_join, thread_id)
                }
            })

            $(window).scroll(function() {
                let page = 1;
                if($(window).scrollTop() == $(document).height() - $(window).height()) {
                    page++;
                    let count_post = $('.list-post-append').find('.panel').length
                    console.log({{ $data->total() ?? 0 }})
                    if (count_post < {{ $data->total() ?? 0 }}) {
                        $.ajax({
                            url: '{{ route('threads.postAjax', $thread->id) }}' + '?page=' + page,
                            method: 'get',
                            success: function (res) {
                                $('.list-post-append').append(res.data)
                                unbin_onclick()
                                init()
                            },
                        })
                    }
                }
            });
        })

        function unbin_onclick() {
            $.each($(".upvote").unbind('click'), function (key, val) {
                $(val).prop("onclick", null).off("click");
            })
            $.each($(".downvote").unbind('click'), function (key, val) {
                $(val).prop("onclick", null).off("click");
            })
            $.each($(".delete_post").unbind('click'), function (key, val) {
                $(val).prop("onclick", null).off("click");
            })
            $.each($(".url-post").unbind('click'), function (key, val) {
                $(val).prop("onclick", null).off("click");
            })
        }

        function init() {
            if ($('meta[name="auth_id"]').attr('content')) {
                $('.upvote').click(function () {
                    let post_id = $(this).closest('.panel').data('idpost')
                    if ($(this).hasClass('text-blue')) {
                        $(this).removeClass('text-blue')
                        update_upvote(post_id, {{\App\Vote::REMOVE_VOTE}})

                        let count_upvote = parseInt($(this).find('.count-upvote').html())
                        $(this).find('.count-upvote').html((count_upvote - 1 ?? 0))
                    } else {
                        $(this).addClass('text-blue')

                        update_upvote(post_id, {{\App\Vote::UP_VOTE}})

                        let count_upvote = parseInt($(this).find('.count-upvote').html())
                        $(this).find('.count-upvote').html(count_upvote + 1)

                        if ($(this).closest('.buttons').find('.downvote').hasClass('text-danger')) {
                            $(this).closest('.buttons').find('.downvote').removeClass('text-danger')

                            let count_downvote = parseInt($(this).closest('.buttons').find('.count-downvote').html())
                            $(this).closest('.buttons').find('.count-downvote').html(count_downvote - 1)
                        }
                    }

                })

                $('.downvote').click(function () {
                    let post_id = $(this).closest('.panel').data('idpost')
                    if ($(this).hasClass('text-danger')) {
                        $(this).removeClass('text-danger')
                        update_upvote(post_id, {{\App\Vote::REMOVE_VOTE}})

                        let count_downvote = parseInt($(this).find('.count-downvote').html())
                        $(this).find('.count-downvote').html((count_downvote - 1 ?? 0))
                    } else {
                        $(this).addClass('text-danger')
                        update_upvote(post_id, {{\App\Vote::DOWN_VOTE}})

                        let count_downvote = parseInt($(this).find('.count-downvote').html())
                        $(this).find('.count-downvote').html(count_downvote + 1)

                        if ($(this).closest('.buttons').find('.upvote').hasClass('text-blue')) {
                            $(this).closest('.buttons').find('.upvote').removeClass('text-blue')

                            let count_upvote = parseInt($(this).closest('.buttons').find('.count-upvote').html())
                            $(this).closest('.buttons').find('.count-upvote').html(count_upvote - 1)
                        }
                    }

                })

                $('.delete_post').click(function () {
                    if (!confirm('Are you sure you want to delete this post?')) {
                        return false;
                    }
                })

                $('.delete-thread').click(function () {
                    if (!confirm('Are you sure you want to delete this Thread?')) {
                        return false;
                    }
                })
            }

            $('.url-post').click(function () {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(this).data('url_post')).select();
                document.execCommand("copy");
                $temp.remove();
            })
        }

        function update_upvote(post_id, vote) {
            $.ajax({
                url: '{{ route('vote.update') }}',
                method: 'post',
                data: {
                    'post_id': post_id,
                    'vote': vote
                },
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
            })
        }

        function join_thread(is_join, thread_id) {
            if (thread_id) {
                $.ajax({
                    url: '{{ route('threads.join') }}',
                    method: 'post',
                    data: {
                        'thread_id': thread_id,
                        'is_join': is_join
                    },
                    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}
                })
            }
        }
    </script>
@endsection
