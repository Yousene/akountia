<div class="d-inline-block">
    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
       data-bs-toggle="dropdown" aria-expanded="false"><i
            class="bx bx-dots-vertical-rounded"></i></a>
    <ul class="dropdown-menu dropdown-menu-end" style="">
        <li>
            <button type="button" class="dropdown-item text-danger delete-record" data-bs-toggle="modal"
                    data-bs-target="#modalCenter"
                    onclick="openSuppModal({{ $user->id }})">
                Supprimer
            </button>
        </li>
    </ul>
</div>
<a href="{{ route('user.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-icon item-edit"><i
        class="bx bxs-edit"></i></a>
