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

class SendNotificationCommand extends Command
{
    protected static $defaultName = 'app:send-notification';
    private $notificationService;

    public function __construct(SesProvider $sesProvider, NotificationService $notificationService, MailerProvider $mailerProvider)
    {
        $this->notificationService = $notificationService;

        // Set provider (Ses) to mailerProvider
        $mailerProvider->setProvider($sesProvider);

        // Set the service (sesProvider) to notificationService
        $this->notificationService->setService($mailerProvider);

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Send message by SesProvider')
            ->addArgument('user_id', InputArgument::OPTIONAL, 'Id of User you want to notify')
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

            // Get user from ID
            $user = new User();

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
