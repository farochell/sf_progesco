<?php
/**
 * sf_progesco
 *
 * @author: emile.camara
 * @date  :   21/12/2019
 * @time  :   11:21
 */

namespace App\Security\Command;


use App\Security\Entity\User;
use App\Security\Service\UserPasswordEncoderService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Class CreateUserCommand
 *
 * @package App\Security\Command
 *
 */
class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';
    protected        $container;
    protected        $em;
    protected        $passwordEncoder;
    
    /**
     * CreateUserCommand constructor.
     *
     * @param ContainerInterface           $container
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(ContainerInterface $container, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->container       = $container;
        $this->em              = $container->get('doctrine.orm.default_entity_manager');
        $this->passwordEncoder = $passwordEncoder;
    
        parent::__construct();
    }
    
    /**
     *
     */
    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')
            
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...');
    }
    
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();
        $user->setFirstName('Emile');
        $user->setLastName('Camara');
        $user->setEmail('camara.emile@gmail.com');
        $user->setUsername('admin');
        $user->setIsActive(1);
        $password = $this->passwordEncoder->encodePassword($user, 'admin');
        $user->setPassword($password);
    
        
        $this->em->persist($user);
        $this->em->flush();
    }
}