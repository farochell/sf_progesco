<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   29/12/2019
 * @time  :   23:49
 */

namespace App\Security\Service;


use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserPasswordEncoderService
 *
 * @package App\Security\Service
 *
 */
class UserPasswordEncoderService implements UserPasswordEncoderInterface
{
    private $encoderFactory;
    
    /**
     * UserPasswordEncoderService constructor.
     *
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }
    
    /**
     * @inheritDoc
     */
    public function encodePassword(UserInterface $user, string $plainPassword)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
    
        return $encoder->encodePassword($plainPassword, $user->getSalt());
    }
    
    /**
     * @inheritDoc
     */
    public function isPasswordValid(UserInterface $user, string $raw)
    {
        if (null === $user->getPassword()) {
            return false;
        }
    
        $encoder = $this->encoderFactory->getEncoder($user);
    
        return $encoder->isPasswordValid($user->getPassword(), $raw, $user->getSalt());
    }
    
    /**
     * @inheritDoc
     */
    public function needsRehash(UserInterface $user): bool
    {
        if (null === $user->getPassword()) {
            return false;
        }
    
        $encoder = $this->encoderFactory->getEncoder($user);
    
        return $encoder->needsRehash($user->getPassword());
    }
}