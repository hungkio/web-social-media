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

        .card_ {
            max-width: 300px;
            margin: auto;
            text-align: center;
            font-family: arial;
            margin-top: 5em;
        }

        .title_ {
            color: grey;
            font-size: 14px;
        }

        .card_ button {
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

        .edit-img {
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
    <div class="container-fluid">
        <form action="{{ route('user.update') }}" method="POST" ENCTYPE="multipart/form-data">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">

                    <h3>Profile settings
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#exampleModal">
                            Change Password
                        </button>
                    </h3>


                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="form-group">
                        <label for="name">Display name (require)</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}"/>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">About (optional)</label>
                        <input class="form-control" name="description"
                               value="{{ old('description', $user->description ?? '') }}"/>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="birth">Birth Day</label>
                        <input type="date" class="form-control" name="birth"
                               value="{{ strftime('%Y-%m-%d', strtotime($user->birth)) }}"/>
                        @error('birth')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                        <button class="btn btn-default">
                            <a href="{{ route('post.my_post') }}">Cancel</a>
                        </button>
                    </div>

                </div>
                <div class="col-md-2">
                    <div class="card_">
                        <div class="avatar_edit">
                            <img id="img_preview" src="{{ asset('storage/users-avatar/' . $user->avatar) }}" alt="John">
                            @if(request('id') == auth()->id() || isset($user))
                                <label class="btn_avatar edit-img" for="upload-photo"><i class="fas fa-pen"></i></label>
                                <input type="file" name="avatar" id="upload-photo" accept="image/*"/>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </form>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('user.change_pass') }}" method="post">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Change Password</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="birth">Current Password</label>
                                <input type="password" class="form-control" name="password" value="********"/>
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="birth">New Password</label>
                                <input type="password" class="form-control" name="new_password" value="********"/>
                                @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="birth">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password" value="********"/>
                                @error('confirm_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script>
        $(function () {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img_preview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $("#upload-photo").change(function () {
                readURL(this);
            });
            let error_pass = '{{\Session::has('error_pass')}}';
            let error_pass_content = '{{\Session::get('error_pass')}}';

            if (error_pass) {
                toastr.error(error_pass_content)
            }

            let success = '{{\Session::has('success')}}';
            let success_content = '{{\Session::get('success')}}';

            if (success) {
                toastr.success(success_content)
            }
        });
    </script>
@endsection
