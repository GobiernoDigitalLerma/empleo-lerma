@props([
    'notifications',
    'readRoute',
    'readAllRoute',
    'showRecipient' => false,
])

{{-- Lista legible de notificaciones: oculta clases PHP y JSON técnico al usuario final. --}}
@php
    $titles = [
        \App\Notifications\AdminCompanyRegisteredNotification::class => 'Nueva empresa registrada',
        \App\Notifications\AdminVacancyRegisteredNotification::class => 'Nueva vacante registrada',
        \App\Notifications\ApplicationCreatedNotification::class => 'Nueva postulación',
        \App\Notifications\CitizenApplicationCreatedNotification::class => 'Postulación enviada',
        \App\Notifications\CitizenHiredNotification::class => 'Actualización de postulación',
        \App\Notifications\CitizenVacancyCoveredNotification::class => 'Vacante cubierta',
        \App\Notifications\CitizenVacancyExpiredNotification::class => 'Vacante vencida',
        \App\Notifications\CompanyRegisteredNotification::class => 'Registro recibido',
        \App\Notifications\CompanyVacancyCoveredNotification::class => 'Vacante cubierta',
        \App\Notifications\CompanyVacancyCreatedNotification::class => 'Vacante creada',
        \App\Notifications\CompanyVacancyExpiredNotification::class => 'Vacante vencida',
        \App\Notifications\CredentialExpiredNotification::class => 'Credencial vencida',
        \App\Notifications\CredentialExpiringNotification::class => 'Credencial por vencer',
        \App\Notifications\VacancyApprovedNotification::class => 'Vacante aprobada',
        \App\Notifications\VacancyRejectedNotification::class => 'Vacante rechazada',
    ];
@endphp

<section class="card border-0 shadow-sm">
    <div class="card-body border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
        <p class="mb-0 text-muted">
            Mostrando {{ $notifications->firstItem() ?? 0 }}-{{ $notifications->lastItem() ?? 0 }}
            de {{ $notifications->total() }} notificaciones
        </p>
        <form method="POST" action="{{ $readAllRoute }}">
            @csrf
            @method('PATCH')
            <button class="btn btn-outline-primary btn-sm" type="submit">Marcar todas como leídas</button>
        </form>
    </div>

    <div class="list-group list-group-flush">
        @forelse($notifications as $notification)
            @php
                $data = $notification->data ?? [];
                $title = $titles[$notification->type] ?? 'Notificación';
                $message = $data['message'] ?? 'Tienes una actualización en Empleo Lerma.';
                $url = $data['url'] ?? null;
            @endphp

            <article class="list-group-item notification-item {{ $notification->read_at ? '' : 'notification-item--unread' }}">
                <div class="d-flex flex-wrap justify-content-between gap-3">
                    <div class="notification-item__body">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h2 class="h6 mb-0">{{ $title }}</h2>
                            @unless($notification->read_at)
                                <span class="badge text-bg-primary">Nueva</span>
                            @endunless
                        </div>

                        <p class="mb-1">{{ $message }}</p>

                        <div class="text-muted">
                            @if($showRecipient)
                                <span>Destinatario #{{ $notification->notifiable_id }}</span>
                                <span aria-hidden="true">·</span>
                            @endif
                            <span>{{ $notification->created_at->format('d/m/Y H:i') }}</span>
                            <span aria-hidden="true">·</span>
                            <span>{{ $notification->read_at ? 'Leída '.$notification->read_at->format('d/m/Y H:i') : 'No leída' }}</span>
                        </div>
                    </div>

                    <div class="notification-item__actions">
                        @if($url)
                            <a class="btn btn-sm btn-outline-secondary" href="{{ $url }}">Revisar</a>
                        @endif

                        @unless($notification->read_at)
                            <form method="POST" action="{{ $readRoute($notification) }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-primary" type="submit">Marcar como leída</button>
                            </form>
                        @endunless
                    </div>
                </div>
            </article>
        @empty
            <div class="list-group-item text-muted">No hay notificaciones con esos filtros.</div>
        @endforelse
    </div>

    <div class="card-body">{{ $notifications->links() }}</div>
</section>
