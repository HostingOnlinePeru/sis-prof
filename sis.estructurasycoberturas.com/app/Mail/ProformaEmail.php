<?php

namespace App\Mail;

use App\Models\CompanySetting;
use App\Models\Proforma;
use App\Support\ProformaPdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProformaEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Proforma $proforma,
        public CompanySetting|null $company,
        public string $bodyMessage,
        public Collection $documents,
    ) {
    }

    public function build(): static
    {
        $logoPath = $this->company?->proforma_logo_path
            ?: $this->company?->dashboard_logo_path
            ?: $this->company?->logo_path;
        $companyLogoPath = $logoPath && Storage::disk('public')->exists($logoPath)
            ? Storage::disk('public')->path($logoPath)
            : null;
        $pdf = ProformaPdf::make($this->proforma, $this->company)->output();
        $mail = $this
            ->subject('Proforma '.$this->proforma->number)
            ->view('emails.proforma')
            ->with([
                'bodyMessage' => $this->bodyMessage,
                'company' => $this->company,
                'companyLogoPath' => $companyLogoPath,
                'proforma' => $this->proforma,
            ])
            ->attachData($pdf, $this->proforma->number.'.pdf', [
                'mime' => 'application/pdf',
            ]);

        if ($this->company?->email) {
            $mail->replyTo($this->company->email, $this->company->business_name ?: null);
        }

        foreach ($this->documents as $document) {
            if (! $document->file_path || ! Storage::disk('public')->exists($document->file_path)) {
                continue;
            }

            $options = [
                'as' => $document->original_name ?: $document->title,
            ];

            if ($document->mime_type) {
                $options['mime'] = $document->mime_type;
            }

            $mail->attach(Storage::disk('public')->path($document->file_path), $options);
        }

        return $mail;
    }
}
