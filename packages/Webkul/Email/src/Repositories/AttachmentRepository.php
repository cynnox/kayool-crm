<?php

namespace Webkul\Email\Repositories;

use Illuminate\Support\Facades\Storage;
use Webkul\Core\Eloquent\Repository;

class AttachmentRepository extends Repository
{
    /**
     * Parser object
     *
     * @var \Webkul\Email\Helpers\Parser
     */
    protected $emailParser;

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\Email\Contracts\Attachment';
    }

    /**
     * @param  \Webkul\Email\Helpers\Parser  $emailParser
     * @return self
     */
    public function setEmailParser($emailParser)
    {
        $this->emailParser = $emailParser;

        return $this;
    }

    /**
     * @param  \Webkul\Email\Contracts\Email  $email
     * @param  array $data
     * @return void
     */
    public function uploadAttachments($email, array $data)
    {
        if (!isset($data['source'])) {
            return;
        }

        if ($data['source'] == 'email') {
            // email attachment code written by krayin developers
            foreach ($this->emailParser->getAttachments() as $attachment) {

                Storage::put($path = 'emails/' . $email->id . '/' . $attachment->getFilename(), $attachment->getContent());

                $this->create([
                    'path' => $path,
                    'name' => $attachment->getFileName(),
                    'content_type' => $attachment->contentType,
                    'content_id' => $attachment->contentId,
                    'size' => Storage::size($path),
                    'email_id' => $email->id,
                ]);
            }

            // email attach code by arun
            if ($data['attachments'] != null) {
                foreach ($data['attachments'] as $attachment) {
                    $filename = $attachment->getName();
                    $content = $attachment->getContent();
                    $attributes = $attachment->getAttributes();

                    Storage::put($path = 'emails/' . $email->id . '/' . $filename, $content);

                    $attchmentDBReq = [
                        'path' => $path,
                        'name' => $attachment->getName(),
                        'content_type' => $attachment->getMimeType(),
                        'content_id' => $attributes['id'],
                        'size' => Storage::size($path),
                        'email_id' => $email->id,
                    ];
                    $this->create($attchmentDBReq);
                }
            }
        } else {
            if (!isset($data['attachments'])) {
                return;
            }

            foreach ($data['attachments'] as $index => $attachment) {
                $this->create([
                    'path' => $path = request()->file('attachments.' . $index)->store('emails/' . $email->id),
                    'name' => $attachment->getClientOriginalName(),
                    'content_type' => $attachment->getClientMimeType(),
                    'size' => Storage::size($path),
                    'email_id' => $email->id,
                ]);
            }
        }
    }
}
