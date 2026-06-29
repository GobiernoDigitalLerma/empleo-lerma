{{-- Formulario compartido de eventos; espera $event, $statuses y $action. --}}
@csrf
@isset($method)
    @method($method)
@endisset

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label" for="title">Título</label>
        <input id="title" class="form-control" name="title" value="{{ old('title', $event->title) }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="status">Estado</label>
        <select id="status" class="form-select" name="status" required>
            @foreach($statuses as $status)
                <option value="{{ $status->value }}" @selected(old('status', $event->status?->value) === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label" for="description">Descripción</label>
        <textarea id="description" class="form-control" name="description" rows="5">{{ old('description', $event->description) }}</textarea>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="event_date">Fecha</label>
        <input id="event_date" class="form-control" type="datetime-local" name="event_date" value="{{ old('event_date', optional($event->event_date)->format('Y-m-d\TH:i')) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label" for="location">Ubicación</label>
        <input id="location" class="form-control" name="location" value="{{ old('location', $event->location) }}">
    </div>
    <div class="col-md-4">
        <label class="form-label" for="link">Liga externa</label>
        <input id="link" class="form-control" type="url" name="link" value="{{ old('link', $event->link) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="image_file">Imagen de publicidad</label>
        <input id="image_file" class="form-control" type="file" name="image_file" accept="image/jpeg,image/png,image/webp">
        <div class="form-text">Formatos permitidos: JPG, PNG o WebP. Tamaño máximo: 4 MB.</div>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="image_path">Ruta de imagen existente</label>
        <input id="image_path" class="form-control" name="image_path" value="{{ old('image_path', $event->image_path) }}" placeholder="images/brand/evento-empleo-demo.svg">
        @if($event->image_path)
            <div class="mt-2">
                <img src="{{ asset($event->image_path) }}" alt="Imagen actual de {{ $event->title }}" class="event-admin-preview">
            </div>
        @endif
    </div>
    <div class="col-12 d-flex gap-2">
        <button class="btn btn-primary" type="submit">{{ $buttonLabel }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.events.index') }}">Cancelar</a>
    </div>
</div>
