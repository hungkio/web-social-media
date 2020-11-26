<style>
    .card_ {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .title_ {
        color: grey;
        font-size: 14px;
    }

    .card_ button, label {
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
<div class="card_">
    <div class="avatar_edit">
        <img src="{{ asset('storage/users-avatar/' . $user->avatar) }}" alt="John">
        @if(request('id') == auth()->id() || $user->id == auth()->id())
            <label class="btn_avatar" for="upload-photo"><i class="fas fa-pen"></i></label>
            <input type="file" name="avatar" id="upload-photo" accept="image/*"/>
        @endif
    </div>
    <h1>{{ $user->name }}</h1>
    <p class="title_">{{ $user->description ?? '' }}</p>
    <p class="title_"><i class="fas fa-birthday-cake"></i> {{ strftime('%d-%m-%Y', strtotime($user->birth)) }}</p>
</div>

