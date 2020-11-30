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
    <style>
        .avatar {
            width: 60px;
            height: 60px;
            display: block;
            margin-right: 15px;
        }

        tbody tr td {
            line-height: 400% !important;
        }
    </style>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-5">
                            <h2>Members Management</h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Date Join</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->user->id ?? '' }}</td>
                            <td>
                                <a href="#">
                                    <img src="{{ asset('storage/users-avatar/' . $user->user->avatar ?? '') }}"
                                         class="avatar img-circle float-left" alt="Avatar">
                                    <span>{{ $user->user->name }}</span>
                                </a>
                            </td>
                            <td>{{ $user->user->created_at }}</td>
                            <td @if($user->role == \App\ThreadMember::ADMIN) style="color: red" @endif>
                                {{ \App\ThreadMember::ROLE[$user->role] }}
                            </td>
                            <td>{{ \App\ThreadMember::STATUS[$user->status] }}
                            </td>
                            <td>
                                @if($admin_id != $user->user->id)
                                    <a href="#" class="settings btn btn-danger" title="Delete" data-toggle="tooltip">Delete</a>
                                    @if($user->status == \App\ThreadMember::APPROVED)
                                        <a href="#" class="delete btn btn-warning" title="Disapprove">Disapprove</a>
                                    @else
                                        <a href="#" class="delete btn btn-success" title="Approve"
                                           data-toggle="tooltip">Approve</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <script>
        $(document).ready(function () {
            $.noConflict();
            $('table').DataTable();
        });
    </script>
@endsection
