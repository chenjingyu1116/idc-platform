<?php
namespace App\Jobs;

use App\Models\Service;
use App\Models\User;
use App\Services\Notify\NotifyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public User $user, public string $event, public array $data = []) {}

    public function handle(): void
    {
        match ($this->event) {
            'service_activated' => isset($this->data['service_id'])
                ? NotifyService::serviceActivated($this->user, Service::find($this->data['service_id']))
                : null,
            'service_expiring' => isset($this->data['service_id'])
                ? NotifyService::serviceExpiring($this->user, Service::find($this->data['service_id']), $this->data['days'] ?? 7)
                : null,
            default => null,
        };
    }
}
