<?php

namespace App\Apis;

use Exception;
use Illuminate\Support\Facades\Log;
use VK\Client\VKApiClient;

/**
 * Class VKApi
 *
 * @property VKApiClient $vk Клиент VK
 * @property string $accessToken Токен доступа
 * @property string $groupId ID группы
 */
class VKApi
{
    public function __construct(private readonly VKApiClient $vk, private readonly string $accessToken, private readonly string $groupId)
    {
    }

    public function isMessagesFromGroupAllowed(int $userId): bool
    {
        try {
            $result = $this->vk->messages()->isMessagesFromGroupAllowed($this->accessToken, [
                'group_id' => $this->groupId,
                'user_id' => $userId,
            ]);
        } catch (Exception $e) {
            Log::error('Ошибка при проверке разрешения на отправку сообщений группе из ВКонтакте', ['message' => $e->getMessage()]);
            return false;
        }

        return isset($result['is_allowed']) && $result['is_allowed'];
    }

    public function sendMessage($userId, $message): void
    {
        try {
            $this->vk->messages()->send($this->accessToken, [
                'user_id' => $userId,
                'random_id' => 0,
                'message' => $message,
            ]);
        } catch (Exception $e) {
        }
    }
}
