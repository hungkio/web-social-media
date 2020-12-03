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
                    @foreach($users as $thread_member)
                        <tr>
                            <td>{{ $thread_member->id ?? '' }}</td>
                            <td>
                                <a href="#">
                                    <img src="{{ asset('storage/users-avatar/' . $thread_member->user->avatar ?? '') }}"
                                         class="avatar img-circle float-left" alt="Avatar">
                                    <span>{{ $thread_member->user->name }}</span>
                                </a>
                            </td>
                            <td>{{ $thread_member->user->created_at }}</td>
                            <td @if($thread_member->role == \App\ThreadMember::ADMIN) style="color: red" @endif>
                                {{ \App\ThreadMember::ROLE[$thread_member->role] }}
                            </td>
                            <td @if($thread_member->status == \App\ThreadMember::APPROVED) style="color: blue" @endif>
                                {{ \App\ThreadMember::STATUS[$thread_member->status] }}
                            </td>
                            <td>
                                @if($admin_id != $thread_member->user->id)
                                    <a href="{{ route('threads.deleteMember', $thread_member->id) }}" class="settings btn btn-danger delete-member" title="Delete" data-toggle="tooltip">Delete</a>
                                    @if($thread_member->status == \App\ThreadMember::APPROVED)
                                        <a href="{{ route('threads.changeApprove', ['id' => $thread_member->id, 'status' =>\App\ThreadMember::DISAPPROVED]) }}" class="delete btn btn-warning" title="Disapprove">Disapprove</a>
                                    @else
                                        <a href="{{ route('threads.changeApprove', ['id' => $thread_member->id, 'status' =>\App\ThreadMember::APPROVED]) }}" class="delete btn btn-success" title="Approve"
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
            $('.delete-member').click(function () {
                if (!confirm('Are you sure you want to fire this member?')) {
                    return false;
                }
            })
        });
    </script>
@endsection
