@include('includes.validation-form')

<div>Pages:</div>
<form action="{{ isset($qty_temp_files) ? route('page.onUpload.order', $manga) : route('page.onEdit.order', $chapter) }}" method="post">
    @csrf
    @method('put')
    <div>
        @if (isset($qty_temp_files))
            @for ($order = 1; $order <= $qty_temp_files; $order++)
                @include('manga.management._partials.img_displayer_container')
            @endfor
        @else
            @foreach($chapter->pages as $order => $page)
                @include('manga.management._partials.img_displayer_container')
            @endforeach
        @endif
    </div>
    <div class="text-end mt-4">
        <span class="btn-group" role="group">
            <a href="{{ isset($qty_temp_files) ? route('chapter.upload.cancel', $manga) : route('manga.edit', $manga) }}" class="btn btn-danger text-light">{{ isset($qty_temp_files) ? 'Cancel' : 'Return' }}</a>
            <button class="btn btn-primary text-light" type="submit">Edit Order</button>
            @if (isset($qty_temp_files))
                <a href="{{ route('chapter.upload.finish', $manga) }}" class="btn btn-success text-light {{ $qty_temp_files < 2 || isset($chapter) && $chapter->pages->count() < 2 ? 'disabled' : null }}">Upload</a>
            @endif
        </span>
    </div>
</form>
<form action="{{ route('page.add', $manga) }}" method="post" enctype="multipart/form-data">
    <div class="row mt-2 justify-content-end">
        @csrf
        <div class="col-md-4">
            <div class="input-group">
                <input type="file" name="pages[]" class="form-control" multiple>
                <button class="btn btn-info text-light" type="submit">Add</button>
            </div>
        </div>
    </div>
</form>