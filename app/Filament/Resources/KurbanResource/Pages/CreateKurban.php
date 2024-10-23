<?php

namespace App\Filament\Resources\KurbanResource\Pages;

use App\Filament\Resources\KurbanResource;
use App\Models\Kurban;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class CreateKurban extends CreateRecord
{
    protected static string $resource = KurbanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Takip kodu ve video yükleme token'ı ekliyoruz
        $data['tracking_code'] = Str::random(10);
        $data['video_upload_token'] = Str::random(32);


        $data['executor_phone_number'] = '+905529461610'; // Sabit telefon numarası

        return $data;
    }

    protected function afterCreate(): void
    {
        // Kaydettikten sonra mesaj gönderme işlemleri
        $this->sendMessages($this->record);
    }

    protected function sendMessages(Kurban $kurban)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');
        $client = new Client($sid, $token);

        // 1. Kurbanı kesecek kişiye mesaj gönderiyoruz
        if (!empty($kurban->executor_phone_number)) {
            $executorMessage = "Merhaba, kurbanı kestikten sonra bu bağlantıya giderek videoyu yükleyin: "
                . route('video.upload', ['token' => $kurban->video_upload_token]);

            $client->messages->create(
                $kurban->executor_phone_number, // Kurbanı kesecek kişinin telefon numarası
                [
                    'from' => $twilioNumber,
                    'body' => $executorMessage,
                ]
            );
        } else {
            Log::error('Executor phone number is missing for Kurban ID: ' . $kurban->id);
        }

        // 2. Bağışçıya teşekkür mesajı gönderiyoruz
        if (!empty($kurban->phone_num)) {
            $donorMessage = "Merhaba " . $kurban->donor_name . ", kurban kaydınız başarıyla oluşturulmuştur. Takip kodunuz: " . $kurban->tracking_code;

            $client->messages->create(
                $kurban->phone_num, // Bağışçının telefon numarası
                [
                    'from' => $twilioNumber,
                    'body' => $donorMessage,
                ]
            );
        } else {
            Log::error('Donor phone number is missing for Kurban ID: ' . $kurban->id);
        }
    }


    protected function getRedirectUrl(): string
    {
        // Bağış oluşturulduktan sonra yönlendirilecek URL
        return $this->getResource()::getUrl('index');
    }
}
