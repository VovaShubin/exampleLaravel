<?php

namespace App\Core\Contracts\Sync;

interface SyncStatuses
{
    //Ожидает синхронизации
    const SYNC_STATUS_PENDING = 'Pending';
    //Находится в процессе синхронизации
    const SYNC_STATUS_ACTIVE = 'Active';
    //Синхронизациия прошла успешно
    const SYNC_STATUS_SUCCESS = 'Success';
    //Данные синхронизировались не полностью
    const SYNC_STATUS_WARNING = 'Warning';
    //Ошибка синхронизации данных
    const SYNC_STATUS_ERRORED = 'Errored';
}
