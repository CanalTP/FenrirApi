<?php

namespace TyrSynchroBundle\Service;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use FOS\UserBundle\Model\UserManagerInterface;

class TyrEventConsumer implements ConsumerInterface
{
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@InheritDoc}
     *
     * Expected JSON message:
     * {"event": "create_user", "data": {...}}
     */
    public function execute(AMQPMessage $msg)
    {
        $message = json_decode($msg->getBody());

        switch ($message->event) {
            case 'create_user':
                $this->createUser($message->data);
                break;

            case 'update_user':
                $this->updateUser($message->data);
                break;

            case 'delete_user':
                $this->deleteUser($message->data);
                break;

            default:
                throw new \RuntimeException('Unknown event "'.$message->event.'"');
        }
    }

    /**
     * @param \stdClass $data
     */
    private function createUser(\stdClass $data)
    {
    }

    /**
     * @param \stdClass $data
     */
    private function updateUser(\stdClass $data)
    {
    }

    /**
     * @param \stdClass $data
     */
    private function deleteUser(\stdClass $data)
    {
    }
}
