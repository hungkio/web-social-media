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
    <link rel="stylesheet" href="{{ asset('css/style_threads.css') }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="wrapper">
                    <!-- Sidebar Holder -->
                    <nav id="sidebar">
                        <div class="sidebar-header">
                            <h3>Categories</h3>
                        </div>

                        <ul class="list-unstyled components">
                            @if($categories)
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('threads.index', $category->id) }}">{{$category->name}}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </nav>

                    <!-- Page Content Holder -->
                    <div id="content" style="padding-top: 0">

                        <h2>Today's Top Growing in {{ $category->name }}</h2>

                        <div class="line"></div>
                        @if($threads)
                            <?php $i = 1 ?>
                            @foreach($threads as $thread)
                                    <a href="{{ route('threads.post', $thread->id) }}"><h3><span>{{ $i++ }} . </span> {{ $thread->name }}</h3></a>
                            @endforeach
                        @endif
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
