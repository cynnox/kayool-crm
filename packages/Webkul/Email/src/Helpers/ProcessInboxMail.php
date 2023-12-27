<?php
namespace Webkul\Email\Helpers;

use Webklex\PHPIMAP\Message;
use Webkul\Email\Repositories\EmailRepository;

class ProcessInboxMail
{

    /**
     * EmailRepository object
     *
     * @var \Webkul\Email\Repositories\EmailRepository
     */
    protected $emailRepository;

    protected $message;

    public function __construct(
        EmailRepository $emailRepository,
        Message $message
    ) {
        // parent::__construct();

        $this->emailRepository = $emailRepository;
        $this->message = $message;

    }

    public function processMail()
    {
        info("From: " . $this->message->getFrom() . "\tTo: " . $this->message->getTo() . "\tSubject: " . $this->message->getSubject());

        // if (strpos($this->message->getFrom(), "contact@kayool.com") !== false || strpos($this->message->getFrom(), "arungirivasan@gmail.com") !== false) {
        $header = $this->message->getHeader();
        $headerAttributes = $header->getAttributes();

        if (!empty($headerAttributes['in_reply_to'])) {

            if ($this->message->hasHTMLBody()) {
                // info("\tMessage HTML: " . $this->message->getHTMLBody());
                $mailBody = $this->message->getHTMLBody();
            } else if ($this->message->hasTextBody()) {
                // info("\tMessage Text: " . $this->message->getTextBody());
                $mailBody = $this->message->getTextBody();
            }

            $messageID = strval($this->message->message_id);

            // foreach ($headerAttributes as $key => $value) {
            //     info("\t" . $key . "\t" . $value);
            // }

            // get parent mailID from DB
            $repliedEmail = $this->emailRepository->findMailByMessageID($headerAttributes['in_reply_to']);
            if ($headerAttributes['in_reply_to'] != null && $repliedEmail == null) {
                info("Skipping message couldn't find reply message from db - " . $headerAttributes['in_reply_to']);
                return;
            }
            // info("replied mail - " . $repliedEmail);
            if ($repliedEmail != null) {
                $parentID = $this->getParentID($repliedEmail);
                $folders = $repliedEmail->folders;
            } else {
                $folders = ['inbox'];
            }
            // if repliedEmail is not exist in inbox then add it to inbox
            if (!in_array('inbox', $folders)) {
                // add inbox to folders
                $folders[] = 'inbox';
                $this->emailRepository->update([
                    'folders' => $folders,
                ], $parentID);
            }

            $emailReq = [
                'subject' => strval($this->message->getSubject()),
                'source' => 'email',
                'user_type' => 'person',
                'name' => $this->parseNameFromEmailAddress(strval($this->message->getFrom())),
                'reply' => $mailBody,
                'folders' => $folders,
                'from' => $this->parseEmailAddress(strval($this->message->getFrom())),
                'reply_to' => $this->getEmailAddressArray($this->message->getTo()),
                'cc' => $this->getEmailAddressArray($headerAttributes['in_reply_to']),
                'unique_id' => $messageID,
                'message_id' => $messageID,
                'reference_ids' => $this->getReferencesFromHeader($headerAttributes, $messageID),
                'parent_id' => $parentID,
                'attachments' => [],
            ];
            if (!empty($repliedEmail->lead_id)) {
                $emailReq = array_merge($emailReq, ['lead_id' => $repliedEmail->lead_id]);
            }

            $attachmentsExist = $this->message->hasAttachments();
            if ($attachmentsExist) {
                $attachments = $this->message->getAttachments();
                $emailReq = array_merge($emailReq, ['attachments' => $attachments]);
            }

            $email = $this->emailRepository->findMailByMessageID($messageID);
            if ($email == null) {
                info("Email not exist. Save new email to DB");
                // info("req: " . json_encode($emailReq));
                $email = $this->emailRepository->create($emailReq);
                info("Saved - \n" . $email);
            } else {
                info("Email already exist in DB.");
            }
        }

        // }
        info("------------");
    }

    public function getAllFolders($client)
    {
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folders = $client->getFolders(false);

        /** @var \Webklex\PHPIMAP\Folder $folder */
        foreach ($folders as $folder) {
            info("Accessing folder: " . $folder->path);

            $messages = $folder->messages()->all()->limit(3, 0)->get();

            info("Number of messages: " . $messages->count());

            /** @var \Webklex\PHPIMAP\Message $message */
            foreach ($messages as $message) {
                info("\tMessage: " . $message->message_id);
                info("\tSubject: " . $message->getSubject());
            }
        }
    }

    /**
     * @param string $type
     * @return array
     */
    public function parseEmailAddress($fromAddress)
    {
        // regular expression to extract email address. eg: from address 'Kerala Startup Mission <updates@startupmission.in>'
        $pattern = '/<([^>]+)>/';
        preg_match($pattern, $fromAddress, $matches);
        if (isset($matches[1])) {
            $emailAddress = $matches[1];
            return $emailAddress;
        }
        return $fromAddress;
    }

    public function parseNameFromEmailAddress($fromAddress)
    {
        // regular expression to extract name from the email address. eg: address 'Kerala Startup Mission <updates@startupmission.in>'
        $pattern = '/^(.*?)\s*<([^>]+)>/';
        preg_match($pattern, $fromAddress, $matches);
        if (isset($matches[1])) {
            $name = trim($matches[1]);
            return $name;
        }
        return $fromAddress;
    }

    public function getReferencesFromHeader($headerAttributes, $messageID)
    {
        $references = [];
        $ref = explode(', ', $headerAttributes['references']);
        foreach ($ref as $r) {
            if (!in_array($r, $references)) {
                $references[] = $r;
            }
        }
        // add messageID to reference
        if (!in_array($messageID, $references)) {
            $references = array_merge($references, [$messageID]);
        }
        return $references;
    }

    public function getEmailAddressArray($data)
    {
        if ($data == null) {
            return null;
        }

        $mailAddress = [];
        $ref = explode(', ', $data);
        foreach ($ref as $r) {
            $r = $this->parseNameFromEmailAddress(strval($r));
            if (!in_array($r, $mailAddress)) {
                $mailAddress[] = $r;
            }
        }
        return $mailAddress;
    }

    public function getParentID($mail)
    {
        $parentID = $mail->id;
        if ($mail->parent_id != null) {
            $parentMail = $this->emailRepository->findByID($mail->parent_id);
            if ($parentMail != null) {
                return $this->getParentID($parentMail);
            } else {
                return $parentID;
            }
        } else {
            return $parentID;
        }
    }

}
