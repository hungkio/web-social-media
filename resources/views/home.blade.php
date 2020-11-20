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
            }

            $('.url-post').click(function () {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(this).data('url_post')).select();
                document.execCommand("copy");
                $temp.remove();
            })
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
    </script>
@endsection
