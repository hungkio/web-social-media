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
        .require {
            color: #666;
        }

        label small {
            color: #999;
            font-weight: normal;
        }

        .avatar_edit {
            position: relative;
        }

        .edit-img {
            font-size: 18px;
            border: none;
            outline: 0;
            display: inline-block;
            padding: 8px;
            color: white;
            background-color: #000;
            text-align: center;
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

        .card_ {
            max-width: 300px;
            margin: auto;
            text-align: center;
            font-family: arial;
            margin-top: 5em;
        }
    </style>
    <div class="container-fluid">
        <form action="{{ route('threads.store') }}" method="POST" ENCTYPE="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 col-md-offset-2">

                    <h3>Create Threads</h3>

                    @if($categories && $categories->isNotEmpty())
                        <label for="title">Select a Category</label>
                        <select class="form-control mb-3" id="exampleFormControlSelect1" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    @endif

                    <div class="form-group">
                        <label for="title">Title <span class="require">*</span></label>
                        <input type="text" class="form-control" name="name"/>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input class="form-control" name="description"></input>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                        <button class="btn btn-default">
                            <a href="{{ route('post.my_post') }}">Cancel</a>
                        </button>
                    </div>

                </div>
                <div class="col-md-2">
                    <div class="card_">
                        <div class="avatar_edit">
                            <img id="img_preview" src="{{ asset('storage/users-avatar/avatar.png') }}" alt="John">
                            <label class="btn_avatar edit-img" for="upload-photo"><i class="fas fa-pen"></i></label>
                            <input type="file" name="avatar" id="upload-photo" accept="image/*"/>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
@endsection
@section('script')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js" defer></script>
    <script>
        $(function () {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img_preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $("#upload-photo").change(function() {
                readURL(this);
            });
        });
    </script>
@endsection
