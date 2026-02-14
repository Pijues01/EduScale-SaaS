@extends('dashboard.layout.master')

@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <h3>Manage Gallery</h3>

        <!-- Upload Image Form -->
        <form action="{{ route('admin.gallery.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Upload Image</button>
        </form>

        <hr>

        <table class="table table-bordered" id="galleryTable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $image)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $image->image_path) }}" width="100">
                        </td>
                        <td>
                            @if ($image->is_featured)
                                ✅
                            @else
                                ❌
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.gallery.feature', $image->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button data-id="{{ $image->id }}"
                                    class="btn btn-sm toggle-feature {{ $image->is_featured ? 'btn-warning' : 'btn-success' }}">
                                    {{ $image->is_featured ? 'Unfeature' : 'Feature' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.gallery.delete', $image->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                $('#galleryTable').DataTable();
            });


            document.addEventListener('DOMContentLoaded', function() {
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

                if (!csrfTokenMeta) {
                    console.error("CSRF token meta tag is missing!");
                    return;
                }

                document.querySelectorAll('.toggle-feature').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        let imageId = this.getAttribute('data-id');

                        fetch(`/admin/gallery/feature/${imageId}`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": csrfTokenMeta.getAttribute('content'),
                                    "Accept": "application/json",
                                    "Content-Type": "application/json"
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Feature status updated!');
                                    location.reload(); // Refresh UI
                                } else {
                                    alert(data.error);
                                }
                            })
                            .catch(error => console.error("Error:", error));
                    });
                });
            });
        </script>
    @endpush
@endsection
