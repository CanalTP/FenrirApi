<?php

namespace ApiBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use FOS\UserBundle\Util\CanonicalizerInterface;
use FOS\UserBundle\Doctrine\UserManager as BaseUserManager;
use FOS\UserBundle\Model\UserInterface;
use ApiBundle\Service\OriginManager;

class UserManager extends BaseUserManager
{
    private $originManager;

    public function __construct(EncoderFactoryInterface $encoderFactory, CanonicalizerInterface $usernameCanonicalizer, CanonicalizerInterface $emailCanonicalizer, ObjectManager $om, $class, OriginManager $originManager)
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $om, $class);

        $this->originManager = $originManager;
    }

    private function setProperties(UserInterface $user, array $data)
    {
        if (array_key_exists('username', $data) && !is_null($data['username'])) {
            $user->setUsername($data['username']);
        }
        if (array_key_exists('originId', $data) && !is_null($data['originId'])) {
            $user->setOrigin($this->originManager->find($data['originId']));
        }
        if (array_key_exists('enabled', $data) && !is_null($data['enabled'])) {
            $user->setEnabled($data['enabled'] == 1 ? true : false);
        }
        if (array_key_exists('locked', $data) && !is_null($data['locked'])) {
            $user->setLocked($data['locked'] == 1 ? true : false);
        }
        if (array_key_exists('expired', $data) && !is_null($data['expired'])) {
            $user->setExpired($data['expired'] == 1 ? true : false);
        }
        if (array_key_exists('credentials_expired', $data) && !is_null($data['credentials_expired'])) {
            $user->setCredentialsExpired($data['credentials_expired'] == 1 ? true : false);
        }
        if (array_key_exists('email', $data) && !is_null($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (array_key_exists('password', $data) && !is_null($data['password'])) {
            $user->setPlainPassword($data['password']);
        }
    }

    public function create(array $data)
    {
        $user = $this->createUser();

        $this->setProperties($user, $data);
        $this->objectManager->persist($user);
        $this->objectManager->flush();
        return $user;
    }

    public function update(UserInterface $user, array $data)
    {
        $this->setProperties($user, $data);
        $this->updateUser($user);
        return $user;
    }
}