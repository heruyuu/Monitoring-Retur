<a href="javascript:void(0)" onclick="edit_data({{ $data->id }})" data-id="{{ $data->id }}" class="btn btn-sm btn-warning text-white edit-button" data-bs-toggle="modal" data-bs-backdrop="false" data-bs-target="#produk_edit" data-bs-backdrop="false" data-bs-placement="top" title="Edit">
    <i class="fa fa-edit"></i>
</a>
<a href="javascript:void(0)" onclick="delete_data({{ $data->id }})" class="btn btn-sm btn-danger text-white delete-button" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
    <i class="fa fa-trash"></i>
</a>
