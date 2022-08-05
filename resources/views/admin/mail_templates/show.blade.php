@extends('layouts.admin.app')
@section('content')
    @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
        <link href="{{ asset('/css/template.css') }}" rel="stylesheet">
    @endpush




    <div class="container-field mt-3">
        <h2 class="mt-3 mb-3">メールテンプレート管理</h2>
        <hr>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('flash_message'))
        <div class="alert alert-success text-center">
            {{ session('flash_message') }}
        </div>
    @endif


    <div class="container-field">
        <form action="{{ route('admin.mail_templates.update') }}" method="post" enctype="multipart/form-data" id="form">
            @csrf
            <div class="mb-5">
                <p>メールテンプレートタイトル</p>
                <h1>{{ $template['title'] }}</h1>
            </div>

            <div class="mb-3">
                <p>表題</p>
                <input type="text" name="subtitle" value="{{ $template['subtitle'] }}" class="form-control">
            </div>

            <div class="mb-3">
                <p>本文</p>
                <div id="editor" style="height: 700px; background:white">{!! $template['body'] !!}</div>
                <input type="hidden" name="body" id="body" value="{{ $template['body'] }}">
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="submit" value="更新">
                {{-- <button type="button" id="submit">更新</button> --}}
            </div>
        </form>
    </div>

    <script>
        $('input[type="submit"]').on('click', function() {
            var input_text = $('.ql-editor').html();
			if (input_text==='<p><br></p>') {
				input_text='';
			}
            $('#body').val('').val(input_text);
            $('#form').submit();
        })

        var quill = new Quill('#editor', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    ['link', 'blockquote'],
                    [{
                        list: 'ordered'
                    }, {
                        list: 'bullet'
                    }],
                    ['clean']
                ]
            },
            theme: 'snow'
        });
    </script>
@endsection
