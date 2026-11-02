<?php

namespace App\Console\Commands;

use App\Models\ContactMessage;
use Illuminate\Console\Command;

class ListMessagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages {id? : ID pesan tertentu yang ingin dibaca lengkap}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lihat daftar pesan yang masuk dari formulir kontak portofolio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');

        if ($id) {
            $msg = ContactMessage::find($id);
            if (!$msg) {
                $this->error("Pesan dengan ID {$id} tidak ditemukan.");
                return 1;
            }

            $this->info("========================================");
            $this->info(" DETAIL PESAN #{$msg->id}");
            $this->info("========================================");
            $this->line("<fg=yellow>Pengirim :</> {$msg->name} <{$msg->email}>");
            $this->line("<fg=yellow>Layanan  :</> {$msg->service_type}");
            $this->line("<fg=yellow>Subjek   :</> " . ($msg->subject ?: '(Tanpa Subjek)'));
            $this->line("<fg=yellow>Waktu    :</> " . $msg->created_at->format('d M Y H:i:s'));
            $this->line("<fg=yellow>Status   :</> " . ($msg->is_read ? '<fg=green>Sudah Dibaca</>' : '<fg=red>Belum Dibaca</>'));
            $this->line("----------------------------------------");
            $this->line("<fg=cyan>Isi Pesan:</>\n{$msg->message}");
            $this->info("========================================");

            // Tandai sudah dibaca
            if (!$msg->is_read) {
                $msg->update(['is_read' => true]);
            }

            return 0;
        }

        $messages = ContactMessage::latest()->get();

        if ($messages->isEmpty()) {
            $this->warn("Belum ada pesan yang masuk dari formulir kontak.");
            return 0;
        }

        $this->info("Total Pesan Masuk: " . $messages->count());

        $headers = ['ID', 'Nama Pengirim', 'Email', 'Layanan', 'Subjek', 'Tanggal', 'Status'];
        $rows = [];

        foreach ($messages as $m) {
            $rows[] = [
                $m->id,
                $m->name,
                $m->email,
                $m->service_type,
                \Illuminate\Support\Str::limit($m->subject ?: '(Tanpa Subjek)', 25),
                $m->created_at ? $m->created_at->format('d M Y H:i') : '-',
                $m->is_read ? 'Dibaca' : 'BARU',
            ];
        }

        $this->table($headers, $rows);
        $this->line("\n<fg=gray>Tips: Ketik 'php artisan messages [id]' untuk membaca isi pesan lengkap.</>");

        return 0;
    }
}
