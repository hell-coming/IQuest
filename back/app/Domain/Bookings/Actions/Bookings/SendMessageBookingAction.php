<?php

namespace App\Domain\Bookings\Actions\Bookings;

use App\Apis\VKApi;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;
use App\Dto\CertificateNewRequest;
use App\Dto\FullLoungeNewRequest;
use App\Dto\HolidayNewRequest;
use App\Dto\LoungeNewRequest;
use App\Dto\QuestNewRequest;

/**
 * Class SendMessageBookingAction
 *
 * @property VKApi $vk
 */
class SendMessageBookingAction
{
    public function __construct(private readonly VKApi $vk)
    {
    }

    public function execute(Booking $booking): void
    {
        $city = $booking->city;
        $userIds = User::query()
            ->whereHas('filials', fn($query) => $query->where('city_id', $city->id))
            ->whereNotNull('vk_id')
            ->whereIn('role', [Role::ADMIN->value, Role::OPERATOR->value])
            ->pluck('vk_id')
            ->toArray();

        $userIds = array_filter($userIds, function ($userId) {
            return $this->vk->isMessagesFromGroupAllowed($userId);
        });

        if (!empty($userIds)) {
            match ($booking->type->value) {
                BookingType::QUEST->value => $this->sendMessageQuest($booking, $userIds),
                BookingType::LOUNGE->value => $this->sendMessageLounge($booking, userIds: $userIds),
                BookingType::HOLIDAY->value => $this->sendMessageHoliday($booking, $userIds),
                BookingType::CERTIFICATE->value => $this->sendMessageCertificate($booking, $userIds),
            };
        }
    }

    private function sendMessageQuest(Booking $booking, $userIds): void
    {
        $bookingScheduleQuest = $booking->bookingScheduleQuest;

        $adminFilials = $this->getAdminFilials($bookingScheduleQuest->timeslot->scheduleQuest->quest->filial_id);
        $userIds = array_merge($userIds, $adminFilials);

        $comment = $bookingScheduleQuest->comment ? $bookingScheduleQuest->comment : '';

        $questNewRequest = new QuestNewRequest();
        $questNewRequest->new_request = $booking->type->value;
        $questNewRequest->quest = $bookingScheduleQuest->timeslot->scheduleQuest->quest->name;
        $questNewRequest->date_and_time = "{$bookingScheduleQuest->timeslot->scheduleQuest->date} {$bookingScheduleQuest->timeslot->time}";
        $questNewRequest->customer_name = "$booking->name";
        $questNewRequest->customer_phone = "$booking->phone";
        $questNewRequest->count_participants = "$bookingScheduleQuest->count_participants";
        $questNewRequest->final_price = "$bookingScheduleQuest->final_price";
        $questNewRequest->comment = $comment;

        $messageString = implode('<br>', $questNewRequest->toArray());

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    public function sendMessageLounge(Booking $booking, array $userIds): void
    {
        $loungeNewRequest = new LoungeNewRequest();
        $loungeNewRequest->new_request = $booking->type->value;
        $loungeNewRequest->customer_name = $booking->name;
        $loungeNewRequest->customer_phone = $booking->phone;

        if ($booking->bookingScheduleLounge()->exists()) {
            $userIds = $this->getAdminFilials($booking->bookingScheduleLounge->scheduleLounge->lounge->filial_id);

            $loungeNewRequest->lounge = $booking->bookingScheduleLounge->scheduleLounge->lounge->name;
            $loungeNewRequest->date_and_time = "{$booking->bookingScheduleLounge->scheduleLounge->date} с {$booking->bookingScheduleLounge->scheduleLounge->time_from} по {$booking->bookingScheduleLounge->scheduleLounge->time_to}";
        }

        $messageString = implode('<br>', $loungeNewRequest->toArray());

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function sendMessageHoliday(Booking $booking, $userIds): void
    {
        $holidayPackage = $booking->bookingHoliday->holidayPackage;

        $holidayNewRequest = new HolidayNewRequest();
        $holidayNewRequest->new_request = $booking->type->value;
        $holidayNewRequest->holiday = $holidayPackage->holiday->type->value;
        $holidayNewRequest->package = $holidayPackage->package->name;
        $holidayNewRequest->customer_name = $booking->name;
        $holidayNewRequest->customer_phone = $booking->phone;

        $messageString = implode('<br>', $holidayNewRequest->toArray());

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function sendMessageCertificate(Booking $booking, $userIds): void
    {
        $bookingCertificate = $booking->bookingCertificate;

        $certificateNewRequest = new CertificateNewRequest();
        $certificateNewRequest->new_request = $booking->type->value;
        $certificateNewRequest->certificate = $bookingCertificate->certificateType->name;
        $certificateNewRequest->customer_name = $booking->name;
        $certificateNewRequest->customer_phone = $booking->phone;

        $messageString = implode('<br>', $certificateNewRequest->toArray());

        foreach ($userIds as $userId) {
            $this->vk->sendMessage($userId, $messageString);
        }
    }

    private function getAdminFilials($filialId): array
    {
        return User::query()
            ->whereHas('filials', fn($query) => $query
                ->where('filial_id', $filialId))
            ->whereNotNull('vk_id')
            ->where('role', Role::FILIAL_ADMIN->value)
            ->pluck('vk_id')
            ->toArray();
    }
}
