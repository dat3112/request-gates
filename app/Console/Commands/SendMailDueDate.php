<?php

namespace App\Console\Commands;

use App\Services\Api\ManagerRequestService;
use Illuminate\Console\Command;

class SendMailDueDate extends Command
{
    protected $managerRequestService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:request_due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to assign when request due';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerRequestService $managerRequestService)
    {
        parent::__construct();
        $this->managerRequestService = $managerRequestService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->managerRequestService->sendMailDueDate();
    }
}
