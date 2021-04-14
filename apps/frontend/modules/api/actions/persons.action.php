<?php

load::app('modules/api/controller');

class api_persons_action extends api_controller
{
    /**
     * @inheritDoc
     */
    public function getRoutes()
    {
        $httpRequestMethod = $_SERVER['REQUEST_METHOD'];

        return [
            '/^\/api\/persons\/(?P<id>\d+)\/status_type.*/' => [
                function ($userId) use ($httpRequestMethod) {
                    switch ($httpRequestMethod) {
                        default:
                        case 'GET':
                            return $this->getStatusType((int) $userId);
                            break;
                        case 'POST':
                            return $this->setStatusType((int) $userId);
                            break;
                    }
                },
                ['id'],
            ],
        ];
    }

    private function getStatusType($userId)
    {
        return sprintf('person.getStatusType(%s)', $userId);
    }

    private function setStatusType($userId, $value)
    {
        return sprintf('person.setStatus(%s)', $userId);
    }
}