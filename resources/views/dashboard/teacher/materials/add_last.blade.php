@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <h2>Upload Study Material</h2>
        <form id="material-form" action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
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

            <div class="form-group" id="file-upload-group">
                <label for="file">Upload File</label>
                <input type="file" class="form-control-file" id="file" name="file">
                <small class="form-text text-muted" id="file-type-hint"></small>
            </div>

            <div class="form-group d-none" id="text-editor-group">
                <label>Content</label>
                <div id="editor"></div>
                <textarea name="content" id="content" style="display:none;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" id="submit-btn">Upload Material</button>
            <div id="form-messages" class="mt-3"></div>
        </form>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Quill editor
            const quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Enter your text content here...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{
                            'header': 1
                        }, {
                            'header': 2
                        }],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'script': 'sub'
                        }, {
                            'script': 'super'
                        }],
                        [{
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        [{
                            'direction': 'rtl'
                        }],
                        [{
                            'size': ['small', false, 'large', 'huge']
                        }],
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'font': []
                        }],
                        [{
                            'align': []
                        }],
                        ['clean'],
                        ['link', 'image']
                    ]
                }
            });

            // Get all required elements
            const typeSelect = document.getElementById('type');
            const fileGroup = document.getElementById('file-upload-group');
            const textGroup = document.getElementById('text-editor-group');
            const fileInput = document.getElementById('file');
            const fileTypeHint = document.getElementById('file-type-hint');
            const form = document.getElementById('material-form');
            const contentInput = document.getElementById('content');
            const submitBtn = document.getElementById('submit-btn');
            const formMessages = document.getElementById('form-messages');

            // Handle material type change
            typeSelect.addEventListener('change', function() {
                const type = this.value;

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
                        fileTypeHint.textContent =
                        'Accepted: PDF, Word (doc, docx), PowerPoint (ppt, pptx)';
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

            // Update content textarea whenever Quill content changes
            quill.on('text-change', function() {
                if (typeSelect.value === 'text') {
                    const htmlContent = quill.root.innerHTML;
                    contentInput.value = htmlContent;
                }
            });

            // Form submission handler
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Update Quill content if text type is selected
                if (typeSelect.value === 'text') {
                    const htmlContent = quill.root.innerHTML;
                    contentInput.value = htmlContent;

                    // Validate content isn't empty
                    const textContent = quill.getText().trim();
                    const isEmpty = !textContent || 
                        textContent === '' || 
                        textContent === 'Enter your text content here...';

                    if (isEmpty) {
                        formMessages.innerHTML = `
                    <div class="alert alert-danger">
                        Please enter some content for the text material
                    </div>
                `;
                        return;
                    }
                }

                // Disable submit button during submission
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Uploading...
        `;

                // Clear previous messages
                formMessages.innerHTML = '';

                try {
                    // Create FormData object
                    const formData = new FormData(form);

                    // Ensure content is added to FormData for text type
                    if (typeSelect.value === 'text') {
                        formData.set('content', contentInput.value);
                    }

                    // Send AJAX request
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw data;
                    }

                    // Success case
                    formMessages.innerHTML = `
                <div class="alert alert-success">
                    ${data.message || 'Material uploaded successfully!'}
                </div>
            `;

                    // Reset form
                    form.reset();
                    if (typeSelect.value === 'text') {
                        quill.setText('');
                        contentInput.value = '';
                    }

                    // Redirect after 2 seconds
                    setTimeout(() => {
                        window.location.href = data.redirect ||
                        "{{ route('materials.index') }}";
                    }, 2000);

                } catch (error) {
                    console.error('Error:', error);
                    let errorHtml = '<div class="alert alert-danger"><ul>';

                    if (error.errors) {
                        Object.values(error.errors).forEach(err => {
                            errorHtml += `<li>${err[0]}</li>`;
                        });
                    } else {
                        errorHtml += `<li>${error.message || 'An error occurred'}</li>`;
                    }

                    errorHtml += '</ul></div>';
                    formMessages.innerHTML = errorHtml;
                } finally {
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Upload Material';
                }
            });

            // Trigger change event on page load to set initial state
            typeSelect.dispatchEvent(new Event('change'));
        });
    </script>
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

        .ql-editor {
            min-height: 250px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }
    </style>
@endpush