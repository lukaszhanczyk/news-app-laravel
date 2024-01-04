<?php

namespace App\Console\Commands;

use App\Http\Services\Clients\NewsApiClient;
use App\Http\Services\Updaters\NewsApiUpdater;
use Illuminate\Console\Command;

class UpdateNewsCommand extends Command
{
    private NewsApiUpdater $newsApiUpdater;

    public function __construct(NewsApiUpdater $newsApiUpdater)
    {
        parent::__construct();
        $this->newsApiUpdater = $newsApiUpdater;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-news-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to update news in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->newsApiUpdater->update();
    }
}
