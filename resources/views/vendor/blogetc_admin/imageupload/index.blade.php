@php
    /** @var UploadedPhoto[] $uploaded_photos */
    use WebDevEtc\BlogEtc\Models\UploadedPhoto;$uploadedPhoto = $uploaded_photos
@endphp
@extends('blogetc_admin::layouts.home')
@push('css')
    <title>ExpenseNg - Upload Images</title>
@endpush
@section('content')
<div class="content" id="app">
    <div class="container-fluid">
        <main class="py-4">
            <div class="row">
                <div class="col-md-9">
                    <h5 class="text-center p-4 text-white" style="background: #6c757d">Admin - Uploaded Images</h5>
                    <script>
                      function show_uploaded_file_row(id, img) {
                        [].forEach.call(document.querySelectorAll('.' + id), function(el) {
                          el.style.display = 'block';
                        });
                        document.getElementById(id).innerHTML = '<a href=\'' + img + '\'><img src=\'' + img +
                            '\' style=\'max-width:100%; height:auto;\'></a>';
                      }
                    </script>

                    @foreach($uploaded_photos as $uploadedPhoto)
                        <div style="border-radius:15px; border:2px solid #efefef; background : #fefefe; margin: 15px;padding:15px">
                            <h3>Image ID: {{$uploadedPhoto->id}}: {{$uploadedPhoto->image_title ?? "Untitled Photo"}}</h3>
                            <h4>
                                <small title="{{$uploadedPhoto->created_at}}">
                                    Uploaded {{$uploadedPhoto->created_at->diffForHumans()}}</small>
                            </h4>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row" style=" margin: 10px; background: #eee; overflow:auto; padding:5px;">
                                        <?php
                                            $smallest = null;
                                            $smallest_size = -1;
                                            foreach ($uploadedPhoto->uploaded_images as $file_key => $file) {
                                            $id = 'uploaded_' . ($uploadedPhoto->id) . '_' . $file_key; ?>

                                            <div class="col-md-12">
                                                <p class="text-center mt-3 float-left">
                                                    <strong>{{$file_key}}</strong> - {{$file['w']}} x {{$file['h']}}:
                                                </p>
                                                <p class="text-center float-right"><a
                                                            href="{{asset(     config("blogetc.blog_upload_dir") . "/". $file['filename'])}}"
                                                            target="_blank">[link]</a> / <span
                                                            class="btn btn-sm btn-primary"
                                                            style="cursor: zoom-in;"
                                                            onclick='show_uploaded_file_row("{{$id}}","{{asset(     config("blogetc.blog_upload_dir") . "/". $file['filename'])}}")'>show</span>
                                                </p>

                                                <div id="{{$id}}"></div>
                                            </div>
                                            <div class="col-md-6 {{$id}}" style="display:none;">
                                                <div>
                                                    <small class="text-muted">Image URL</small>
                                                    <input type="text" readonly="readonly" class="form-control"
                                                           value="{{ asset( config("blogetc.blog_upload_dir") . "/". $file['filename'])}}" />
                                                </div>
                                            </div>
                                            <div class="col-md-6 {{$id}}" style="display:none;">
                                                <div>
                                                    <small class="text-muted">img tag</small>
                                                    <input type="text" readonly="readonly" class="form-control"
                                                           value='{{"<img src='".asset(     config("blogetc.blog_upload_dir") . "/". $file['filename'])."' alt='" . e($uploadedPhoto->image_title) . "' >"}}'>
                                                </div>
                                            </div>
                                            

                                            <?php
                                                $area = $file['w'] * $file['h'];
                                                if ($area < $smallest_size || $smallest_size < 0) {
                                                    $smallest = $file;
                                                    $smallest_size = $area;
                                                }

                                            }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    @if($smallest)
                                        <div style="text-align:center;">
                                            <a style="cursor: zoom-in;"
                                               href="{{ asset(config("blogetc.blog_upload_dir") . "/". $smallest['filename']) }}"
                                               target="_blank">
                                                <img alt="" src="{{ asset(config("blogetc.blog_upload_dir") . "/". $smallest['filename']) }}"
                                                     style="max-width:100%; height: auto;">
                                            </a>
                                        </div>

                                    @else
                                        <div class="alert alert-danger">
                                            No image found
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                     @endforeach
                </div>
                <div class="col-md-3">
                    @include("blogetc_admin::layouts.sidebar")
                </div>
            </div>
  
            <div class="text-center">
                {{ $uploaded_photos->links() }}
            </div>
        </main>
    </div>
</div>
@endsection