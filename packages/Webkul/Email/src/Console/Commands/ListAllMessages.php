<?php

namespace Webkul\Email\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use Webkul\Email\Helpers\ProcessInboxMail;
use Webkul\Email\Repositories\EmailInboxTrackJobRepository;
use Webkul\Email\Repositories\EmailRepository;

class ListAllMessages extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list_all_emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all emails using imap';

    /**
     * EmailRepository object
     *
     * @var \Webkul\Email\Repositories\EmailRepository
     */
    protected $emailRepository;

    /**
     * EmailInboxTrackJobRepository object
     *
     * @var \Webkul\Email\Repositories\EmailInboxTrackJobRepository
     */
    protected $emailInboxTrackJobRepository;

    public function __construct(EmailRepository $emailRepository,
        EmailInboxTrackJobRepository $emailInboxTrackJobRepository) {
        parent::__construct();
        $this->emailRepository = $emailRepository;
        $this->emailInboxTrackJobRepository = $emailInboxTrackJobRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // date format 01.01.2024, 31.12.2024
        $currentDate = date('d.m.Y');
        $lastCheckedDetails = $this->emailInboxTrackJobRepository->findLastOne();
        if ($lastCheckedDetails == null) {
            // this will execute only once
            $lastCheckedDate = $currentDate;
        } else {
            $lastCheckedDate = $lastCheckedDetails->last_checked_date;
        }
        info("checking for new emails " . $currentDate . " last checked on " . $lastCheckedDate);

        $client = Client::account("default");
        $client->connect();

        // get INBOX folder
        $folder = $client->getFolderByName('INBOX');
        $count = $folder->query()->since($lastCheckedDate)->all()->count();
        info("Total messages in INBOX: " . $count);
        $pageSize = 50;
        $loopLimit = (int) ($count / $pageSize);
        if ($count % $pageSize != 0) {
            $loopLimit += 1;
        }
        info("Total pages: " . $loopLimit);
        for ($pageIndex = 1; $pageIndex <= $loopLimit; $pageIndex++) {
            $this->getMessagesByPagination($folder, $lastCheckedDate, $pageSize, $pageIndex);
        }

        if ($lastCheckedDetails == null) {
            $this->emailInboxTrackJobRepository->create(['last_checked_date' => $currentDate]);
        } else {
            $this->emailInboxTrackJobRepository->update(['last_checked_date' => $currentDate], $lastCheckedDetails->id);
        }
        info("Process completed..");

        return Command::SUCCESS;
    }

    // page should be start from 1
    public function getMessagesByPagination($folder, $date, $lmt, $pge)
    {
        info("Getting messages of page: " . $pge);
        $messages = $folder->query()->setFetchOrder("desc")->since($date)->all()->limit($limit = $lmt, $page = $pge)->get();
        info("Number of messages: " . $messages->count());
        foreach ($messages as $message) {
            $processMail = new ProcessInboxMail($this->emailRepository, $message);
            $processMail->processMail();
        }
    }

}
