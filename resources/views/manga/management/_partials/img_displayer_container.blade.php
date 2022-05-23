<?php if(isset($page)) ++$order ?>
<div class="img-block d-inline-block bg-dark-1 mb-1">
    <a href="{{ isset($qty_temp_files) ? route('page.display', ['manga' => $manga, 'order' => $order]) : asset($page->path) }}" target="_blank">
        <img src="{{ isset($qty_temp_files) ? route('page.display', ['manga' => $manga, 'order' => $order]) : asset($page->path) }}" alt="page {{$order}}" class="img-fluid d-block mx-auto">
    </a>
    <div class="row justify-content-center my-1">
        <div class="col-5">
            <div class="input-group mt-2">
                <input type="number" name="orders[{{$order}}]" min="1" max="{{$qty_temp_files ?? $chapter->pages->count()}}" placeholder="{{$order}}" value="{{ old("orders.$order") ?? $order }}" class="form-control form-control-sm">
                <a href="{{ isset($qty_temp_files) ? route('page.remove', ['manga' => $manga, 'order' => $order]) : route('page.edit.remove', ['chapter' => $chapter, 'order' => $order]) }}" class="btn btn-small btn-danger"><i class="fa-solid fa-x fa-sm text-light"></i></a>
            </div>
        </div>
    </div>
</div>