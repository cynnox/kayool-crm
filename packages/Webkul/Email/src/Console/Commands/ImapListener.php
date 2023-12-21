<?php

namespace Webkul\Email\Console\Commands;

use Webklex\IMAP\Commands\ImapIdleCommand;
use Webklex\PHPIMAP\Message;
use Webkul\Email\Helpers\ProcessInboxMail;
use Webkul\Email\Repositories\EmailRepository;

class ImapListener extends ImapIdleCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:listen_imap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Listen Imap Server';

    /**
     * EmailRepository object
     *
     * @var \Webkul\Email\Repositories\EmailRepository
     */
    protected $emailRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EmailRepository $emailRepository)
    {
        parent::__construct();
        $this->emailRepository = $emailRepository;

    }

    /**
     * Callback used for the idle command and triggered for every new received message
     * @param Message $message
     */
    public function onNewMessage(Message $message)
    {
        info("New message received: From: " . $message->getFrom() . "\tTo: " . $message->getTo() . "\tSubject: " . $message->getSubject());

        $processMail = new ProcessInboxMail($this->emailRepository, $message);
        $processMail->processMail();

    }
}
