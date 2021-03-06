<?php namespace Avram\Guard\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EmailShow extends BaseCommand
{

    protected function configure()
    {
        $this
            ->setName('email:show')
            ->setDescription('Show email notification settings');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $transport = $this->guardFile->getEmail('transport');

        $row   = [];
        $row[] = str_replace(',', ', ', $this->guardFile->getEmail('address'));
        $row[] = $this->guardFile->getEmail('transport');

        switch ($transport) {
            case 'sendmail':
                $header = array('Address', 'Transport', 'Sendmail path');
                $row[]  = $this->guardFile->getEmail('sendmail');
                break;
            case 'smtp':
                $header     = array('Address', 'Transport', 'SMTP host', 'SMTP port', 'SMTP username', 'Encryption');
                $row[]      = $this->guardFile->getEmail('smtp_host');
                $row[]      = $this->guardFile->getEmail('smtp_port');
                $row[]      = $this->guardFile->getEmail('smtp_user');
                $encryption = $this->guardFile->getEmail('smtp_encrypt');
                $row[]      = empty($encryption) ? 'none' : $encryption;
                break;
            default:
                $header = array('Address', 'Transport');
        }

        $this->table($header, [$row]);
    }
}