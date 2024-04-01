<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} | 403 Forbidden</title>
</head>
<body>
<div class="container">
    <img src="{{ asset('cp/images/errors/403.png') }}" alt="403">
    <div class="buttons">
        <x-filament::link class="buttons-item" :href="route('filament.cp.pages.dashboard')">На главную
        </x-filament::link>
        <x-filament::link class="buttons-item" :href="url()->previous()">Назад</x-filament::link>
    </div>
</div>
</body>
</html>

<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    .buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .buttons-item {
        font-family: Arial, sans-serif;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #4f46e5;
        color: #fff;
        text-decoration: none;
        font-weight: bold;
    }
</style>
