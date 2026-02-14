
@extends('dashboard.layout.master')

@section('content')
    <div class="container pb-5 mt-5">
        <h2 class="text-center mb-4">
            {{ isset($branch_details) ? 'Edit Branch' : 'Add New Branch' }}
        </h2>

        <form
            action="{{ isset($branch_details) ? route('admin.branches.update', $branch_details->id) : route('admin.branches.store') }}"
            method="POST" enctype="multipart/form-data" class="container">
            @csrf
            @if (isset($branch_details))
                @method('PUT') {{-- For update requests --}}
            @endif

            <div class="row">
                <div class="col-md-6">
                    <label for="branch_name" class="form-label">Branch Name</label>
                    <input type="text" name="branch_name" id="branch_name" class="form-control"
                        value="{{ $branch_details->branch_name ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control"
                        value="{{ $branch_details->location ?? '' }}" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ $branch_details->description ?? '' }}</textarea>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="working_hours" class="form-label">Working Hours</label>
                    <input type="text" name="working_hours" id="working_hours" class="form-control"
                        value="{{ $branch_details->working_hours ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label for="contact" class="form-label">Contact Number</label>
                    <input type="text" name="contact" id="contact" class="form-control"
                        value="{{ $branch_details->contact ?? '' }}" required>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control"
                        value="{{ $branch_details->email ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label for="images" class="form-label">Upload Images</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                    <div id="imagePreview" class="mt-2 d-flex flex-wrap">
                        {{-- @if (isset($branch_details) && !empty($branch_details->images))
                            @foreach (json_decode($branch_details->images) as $image)
                                <img src="{{ asset('uploads/branches/'.$image) }}" class="img-thumbnail m-1" width="100" height="100">
                            @endforeach
                        @endif --}}
                        @if (isset($branch_details) && !empty($branch_details->images))
                            @php
                                $images = is_string($branch_details->images)
                                    ? json_decode($branch_details->images)
                                    : $branch_details->images;
                            @endphp

                            {{-- @foreach ($images as $image)
                                <img src=" {{ asset('storage/' . $image) }}" class="img-thumbnail m-1" width="100"
                                    height="100">
                            @endforeach --}}
                            @php
                                $images = is_array($images) ? $images : json_decode($images, true);
                            @endphp

                            @foreach ($images as $image)
                                @if (is_array($image))
                                    @foreach ($image as $img)
                                        <img src="{{ asset('storage/' . $img) }}" class="img-thumbnail m-1" width="100"
                                            height="100">
                                    @endforeach
                                @else
                                    <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail m-1" width="100"
                                        height="100">
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary">
                    {{ isset($branch_details) ? 'Update Branch' : 'Save Branch' }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('images').addEventListener('change', function(event) {
            let imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = "";
            let files = event.target.files;

            if (files.length > 4) {
                alert("You can upload a maximum of 4 images.");
                this.value = ""; // Clear selected images
                return;
            }

            if (files.length > 0) {
                Array.from(files).forEach(file => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-thumbnail', 'm-1');
                        img.style.width = "100px";
                        img.style.height = "100px";
                        imagePreview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
@endpush
