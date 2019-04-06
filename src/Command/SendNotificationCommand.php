<?php

namespace App\Command;

use App\Entity\User;
use App\Provider\Mailer\MailerProvider;
use App\Provider\Mailer\Ses\SesProvider;
use App\Service\NotificationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * SendNotificationCommand Class
 *
 * @author  Manuel Romero <manuelromerovidal@gmail.com>
 *
 */
class SendNotificationCommand extends Command
{
    protected static $defaultName = 'app:send-notification';

    private $notificationService;
    private $container;

    public function __construct(SesProvider $sesProvider, NotificationService $notificationService, MailerProvider $mailerProvider, ContainerInterface $container)
    {
        $this->notificationService = $notificationService;

        // Set provider (Ses) to mailerProvider
        $mailerProvider->setProvider($sesProvider);

        // Set the service (sesProvider) to notificationService
        $this->notificationService->setService($mailerProvider);

        $this->container = $container;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Send message by SesProvider')
            ->addArgument('user_id', InputArgument::REQUIRED, 'Id of User you want to notify')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $user_id = $input->getArgument('user_id');

        //check if its set user_id
        if (!$user_id) {
            $io->note('You must pass an argument: user_id');
        } else {

            //default message
            $message = "Mensaje que se ha enviado";

            // Get user from ID (Simnulate doctrine)
            $entityManager = $this->container->get('doctrine')->getManager();
            $user = $entityManager->getRepository(User::class)->getUserById($user_id);

            if(!$user) {
                // Not user found
                $output->write('Usuario no encontrado');

            } else {

                // Send notification (message) to User
                $result = $this->notificationService->notify($user, $message);

                // write result
                $output->writeln([
                    'id: ' . $user->getId(),
                    'email: ' . $user->getEmail(),
                    'message: ' . $message,
                    'result: ' . var_export($result, true),
                ]);
            }
        }
    }
}
