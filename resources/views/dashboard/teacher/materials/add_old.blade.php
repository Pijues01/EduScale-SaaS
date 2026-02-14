@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <h2>Upload Study Material</h2>
        <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="class_id">Class</label>
                <select class="form-control" id="class_id" name="class_id" required>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="type">Material Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="document">Document (PDF, Word, PPT)</option>
                    <option value="video">Video</option>
                    <option value="image">Image</option>
                    <option value="text">Text</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <!-- File upload (shown for document, video, image) -->
            <div class="form-group" id="file-upload-group">
                <label for="file">Upload File</label>
                <input type="file" class="form-control-file" id="file" name="file">
                <small class="form-text text-muted" id="file-type-hint"></small>
            </div>

            <!-- Rich text editor (shown for text type) -->
            <div class="form-group d-none" id="text-editor-group">
                <label>Content</label>
                <div id="editor">
                    <p>Enter your text content here...</p>
                </div>
                <input type="hidden" name="content" id="content">
            </div>

            <button type="submit" class="btn btn-primary" onclick="handleSubmit()">Upload Material</button>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    {{-- <script>
        // Initialize Quill editor
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['clean'],
                    ['link', 'image']
                ]
            }
        });

        // Update hidden input with Quill content before form submission
        document.querySelector('form').addEventListener('submit', function() {
            console.log(quill.root.innerHTML);
            document.getElementById('content').value = quill.root.innerHTML;
            console.log(document.getElementById('content'));

        });

        // Handle material type change
        document.getElementById('type').addEventListener('change', function() {
            const type = this.value;
            const fileGroup = document.getElementById('file-upload-group');
            const textGroup = document.getElementById('text-editor-group');
            const fileInput = document.getElementById('file');
            const fileTypeHint = document.getElementById('file-type-hint');

            if (type === 'text') {
                fileGroup.classList.add('d-none');
                textGroup.classList.remove('d-none');
                fileInput.removeAttribute('required');
            } else {
                fileGroup.classList.remove('d-none');
                textGroup.classList.add('d-none');
                fileInput.setAttribute('required', 'required');

                // Update file type hint
                if (type === 'document') {
                    fileTypeHint.textContent = 'Accepted: PDF, Word (doc, docx), PowerPoint (ppt, pptx)';
                    fileInput.setAttribute('accept', '.pdf,.doc,.docx,.ppt,.pptx');
                } else if (type === 'video') {
                    fileTypeHint.textContent = 'Accepted: MP4, MOV, AVI';
                    fileInput.setAttribute('accept', '.mp4,.mov,.avi');
                } else if (type === 'image') {
                    fileTypeHint.textContent = 'Accepted: JPG, PNG, GIF';
                    fileInput.setAttribute('accept', '.jpg,.jpeg,.png,.gif');
                }
            }
        });

        // Trigger change event on page load to set initial state
        document.getElementById('type').dispatchEvent(new Event('change'));
    </script> --}}


@endpush

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <style>
        #editor {
            height: 300px;
            background-color: white;
        }

        .d-none {
            display: none;
        }
    </style>
@endpush
