<?php

namespace Webkul\Email\Repositories;

use Illuminate\Container\Container;
use Webkul\Core\Eloquent\Repository;

class EmailInboxTrackJobRepository extends Repository
{

    public function __construct(
        Container $container
    ) {
        parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\Email\Contracts\EmailInboxTrackJob';
    }

    public function create(array $data)
    {
        $job = parent::create($data);
        return $job;
    }

    public function findLastOne()
    {
        $job = parent::orderBy('id', 'desc')->first();
        return $job;
    }

    public function update(array $data, $jobID)
    {
        $job = $this->findOrFail($jobID);

        parent::update($data, $jobID);

        return $job;

    }
}
