<a href="{{ route('utsmengajar.show', $id) }}" data-toggle="tooltip" data-original-title="Lihat" class="edit btn btn-info btn-xs edit">
Lihat
</a>
<a href="{{ route('utsmengajar.edit', $id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success btn-xs edit">
Edit
</a>
<a href="javascript:void(0)" data-id="{{ $id }}" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-xs btn-danger">
Delete
</a>
<!-- <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('pendaftaran.destroy', $id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
</form> -->
