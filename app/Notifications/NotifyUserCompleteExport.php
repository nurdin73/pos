<?php

namespace App\Notifications;

use App\Models\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotifyUserCompleteExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user_id;
    public $filename;
    public $pathname;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user_id, $filename, $pathname)
    {
        $this->user_id = $user_id;
        $this->filename = $filename;
        $this->pathname = $pathname;
    }

    public function handle()
    {
        $notif = [
            'user_id' => $this->user_id,
            'payload' => json_encode([
                'title' => "Export Transaksi berhasil dibuat.",
                'body'  => "File excel <strong>" . $this->filename . "</strong> sudah bisa didownload",
                'link'  => asset($this->pathname)
            ])
        ];
        $create = Notifications::create($notif);
        Log::debug($create);
    }
}
