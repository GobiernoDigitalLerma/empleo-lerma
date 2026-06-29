<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EventStatus;
use App\Http\Controllers\Admin\Concerns\RecordsAdminAudit;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * CRUD administrativo de eventos públicos.
 *
 * Permite capturar eventos nuevos, conservarlos como borrador, publicarlos y
 * archivarlos sin depender de carga directa en base de datos.
 */
class EventController extends Controller
{
    use RecordsAdminAudit;

    /**
     * Lista eventos con filtros por estado y texto.
     */
    public function index(Request $request)
    {
        $events = Event::query()
            ->with(['creator', 'updater'])
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%'))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('event_date')
            ->paginate(12)
            ->withQueryString();

        return view('admin.events.index', [
            'events' => $events,
            'statuses' => EventStatus::cases(),
        ]);
    }

    /**
     * Muestra formulario de creación de evento.
     */
    public function create()
    {
        return view('admin.events.create', ['event' => new Event(), 'statuses' => EventStatus::cases()]);
    }

    /**
     * Guarda un evento nuevo.
     */
    public function store(Request $request)
    {
        $data = $this->validatedEvent($request);

        $event = Event::create($this->eventPayload($data) + [
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        $this->audit('admin.events.create', $event, [], $event->only(['title', 'status', 'event_date']));

        return redirect()->route('admin.events.index')->with('status', 'Evento creado.');
    }

    /**
     * Muestra formulario de edición de evento.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', ['event' => $event, 'statuses' => EventStatus::cases()]);
    }

    /**
     * Actualiza un evento existente.
     */
    public function update(Request $request, Event $event)
    {
        $data = $this->validatedEvent($request);
        $oldValues = $event->only(['title', 'status', 'event_date', 'published_at']);

        $event->update($this->eventPayload($data, $event) + ['updated_by' => auth()->id()]);

        $this->audit('admin.events.update', $event, $oldValues, $event->only(['title', 'status', 'event_date', 'published_at']));

        return redirect()->route('admin.events.index')->with('status', 'Evento actualizado.');
    }

    /**
     * Publica un evento y lo hace visible en el sitio público.
     */
    public function publish(Event $event)
    {
        $oldValues = $event->only(['status', 'published_at']);

        $event->forceFill([
            'status' => EventStatus::Published,
            'published_at' => $event->published_at ?? now(),
            'updated_by' => auth()->id(),
        ])->save();

        $this->audit('admin.events.publish', $event, $oldValues, $event->only(['status', 'published_at']));

        return back()->with('status', 'Evento publicado.');
    }

    /**
     * Archiva un evento para retirarlo del público.
     */
    public function archive(Event $event)
    {
        $oldValues = $event->only(['status']);

        $event->forceFill(['status' => EventStatus::Archived, 'updated_by' => auth()->id()])->save();

        $this->audit('admin.events.archive', $event, $oldValues, $event->only(['status']));

        return back()->with('status', 'Evento archivado.');
    }

    /**
     * Reglas de validación compartidas por crear y editar.
     */
    private function validatedEvent(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'url', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'file', 'extensions:jpg,jpeg,png,webp', 'max:4096'],
            'status' => ['required', 'in:'.implode(',', array_column(EventStatus::cases(), 'value'))],
        ]);
    }

    /**
     * Normaliza datos antes de persistirlos.
     */
    private function eventPayload(array $data, ?Event $event = null): array
    {
        $titleChanged = is_null($event) || $event->title !== $data['title'];
        $imagePath = $data['image_path'] ?? $event?->image_path;

        if (request()->hasFile('image_file')) {
            $imagePath = $this->storeEventImage(request());
        }

        return [
            'title' => $data['title'],
            'slug' => $titleChanged ? Str::slug($data['title']).'-'.Str::lower(Str::random(6)) : $event->slug,
            'description' => $data['description'] ?? null,
            'event_date' => $data['event_date'] ?? null,
            'location' => $data['location'] ?? null,
            'link' => $data['link'] ?? null,
            'image_path' => $imagePath,
            'status' => $data['status'],
            'published_at' => $data['status'] === EventStatus::Published->value ? now() : null,
        ];
    }

    /**
     * Guarda la publicidad del evento en public/images/events para servirla con asset().
     */
    private function storeEventImage(Request $request): string
    {
        $file = $request->file('image_file');
        $directory = public_path('images/events');

        File::ensureDirectoryExists($directory);

        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'images/events/'.$filename;
    }
}
