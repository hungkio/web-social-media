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
        <div class="col-sm-10">
            @if($post)
                @include('post-component', ['has_comment' => 1])
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            if ($('meta[name="auth_id"]').attr('content')) {
                $('.upvote').click(function () {
                    let post_id = $(this).closest('.post-description').data('idpost')
                    if ($(this).hasClass('text-blue')) {
                        $(this).removeClass('text-blue')
                        update_upvote(post_id, {{\App\Vote::REMOVE_VOTE}})

                        let count_upvote = parseInt($(this).closest('.post-description').find('.count-upvote').html())
                        $(this).closest('.post-description').find('.count-upvote').html((count_upvote - 1 ?? 0))
                    } else {
                        $(this).addClass('text-blue')

                        update_upvote(post_id, {{\App\Vote::UP_VOTE}})

                        let count_upvote = parseInt($(this).closest('.post-description').find('.count-upvote').html())
                        $(this).closest('.post-description').find('.count-upvote').html(count_upvote + 1)

                        if ($(this).closest('.post-description').find('.downvote').hasClass('text-danger')) {
                            $(this).closest('.post-description').find('.downvote').removeClass('text-danger')

                            let count_downvote = parseInt($(this).closest('.post-description').find('.count-downvote').html())
                            $(this).closest('.post-description').find('.count-downvote').html(count_downvote - 1)
                        }
                    }

                })

                $('.downvote').click(function () {
                    let post_id = $(this).closest('.post-description').data('idpost')
                    if ($(this).hasClass('text-danger')) {
                        $(this).removeClass('text-danger')
                        update_upvote(post_id, {{\App\Vote::REMOVE_VOTE}})

                        let count_downvote = parseInt($(this).closest('.post-description').find('.count-downvote').html())
                        $(this).closest('.post-description').find('.count-downvote').html((count_downvote - 1 ?? 0))
                    } else {
                        $(this).addClass('text-danger')
                        update_upvote(post_id, {{\App\Vote::DOWN_VOTE}})

                        let count_downvote = parseInt($(this).closest('.post-description').find('.count-downvote').html())
                        $(this).closest('.post-description').find('.count-downvote').html(count_downvote + 1)

                        if ($(this).closest('.post-description').find('.upvote').hasClass('text-blue')) {
                            $(this).closest('.post-description').find('.upvote').removeClass('text-blue')

                            let count_upvote = parseInt($(this).closest('.post-description').find('.count-upvote').html())
                            $(this).closest('.post-description').find('.count-upvote').html(count_upvote - 1)
                        }
                    }

                })

                // confirm delete post
                $('.delete_post').click(function () {
                    if (!confirm('Are you sure you want to delete this post?')) {
                        return false;
                    }
                })

                // comment
                let html = '<span class="reply-append"><a class="pull-left" href="#">\n' +
                    '                            <img class="avatar" src="https://bootdey.com/img/Content/user_1.jpg"\n' +
                    '                                 alt="avatar">\n' +
                    '                        </a>\n' +
                    '                        <input class=\'reply\' placeholder="write ur reply..." type="text"></span>';
                $('button.reply').click(function () {
                    if ($(this).closest('.comment-body').hasClass('appended')) {
                        $(this).closest('.comment-body').find('.reply-append').addClass('d-none')
                        $(this).closest('.comment-body').removeClass('appended')
                    } else {
                        // $(this).closest('.comment-body').append(html)
                        $(this).closest('.comment-body').find('.reply-append').removeClass('d-none')
                        $(this).closest('.comment-body').addClass('appended')
                    }
                })

                $('input[type=text]').keypress(function (e) {
                    var key = e.which;
                    if(key == 13)  // the enter key code
                    {
                        let content = $(this).val();
                        let post_id = {{ $post->id }};
                        let parent_id = $(this).data('parent_id') ?? '';
                        let user_reply = $(this).data('user_reply') ?? '';
                        let user_reply_name = $(this).data('user_reply_name') ?? '';
                        let html =
                            '    <a class="pull-left" href="#"><img class="avatar" src="https://bootdey.com/img/Content/user_1.jpg"alt="avatar"></a>\n' +
                            '    <div class="comment-body">\n' +
                            '        <div class="comment-heading"><h4 class="user">Gavino Free</h4><h5 class="time">5 minutes ago</h5></div>\n' +
                            '        <p class="mb-0">content_replace</p>\n' +
                            '        <div class="buttons">\n' +
                            '            <button type="button" class=\'btn upvote\'><i class="far fa-thumbs-up"></i><span class="count-upvote">0 </span>Up Vote</button>\n' +
                            '\n' +
                            '            <button type="button" class=\'btn downvote\'><i class="far fa-thumbs-down"></i><span class="count-downvote">0 </span>Down vote</button>\n' +
                            '\n' +
                            '            <button type="button" class=\'btn reply\'><i class="far fa-comment-alt"></i>Reply</button>\n' +
                            '        </div>\n' +
                            '        <span class="reply-append d-none">\n' +
                            '            <a class="pull-left" href="#"><img class="avatar" src="https://bootdey.com/img/Content/user_1.jpg" alt="avatar"></a>\n' +
                            '            <input class=\'reply\' placeholder="write ur reply..." type="text">\n' +
                            '        </span>\n' +
                            '    </div>';
                        if (content.trim() != '') {
                            comment(post_id, content, parent_id, user_reply)
                            $(this).val('')
                            if ($(this).hasClass('common-comment')) {
                                $('.new-comment').append(html.replace('content_replace', content))
                                $('.count_comment').html(parseInt($('.count_comment').html()) + 1)
                            } else {
                                if (!user_reply) {
                                    $(this).closest('.comment-reply-top').find('li.reply-comment').append(html.replace('content_replace', content))
                                    $('.count_comment').html(parseInt($('.count_comment').html()) + 1)
                                } else {
                                    $(this).closest('.comments-list').append(html.replace('content_replace', '<b>' + user_reply_name + '</b> ' + content))
                                    $('.count_comment').html(parseInt($('.count_comment').html()) + 1)
                                }
                            }
                        }
                        return false;
                    }
                });
            }
        })

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

        function comment(post_id, content, parent_id, user_reply, html) {
            $.ajax({
                url: '{{ route('post.save_comment') }}',
                method: 'post',
                data: {
                    'post_id': post_id,
                    'content': content,
                    'parent': parent_id,
                    'user_reply': user_reply
                },
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function () {
                    $('.post-footer').block()
                },
                complete: function () {
                    $('.post-footer').unblock()
                }
            })
        }

    </script>
@endsection
