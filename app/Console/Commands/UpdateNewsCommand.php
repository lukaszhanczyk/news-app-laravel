<?php

namespace App\Console\Commands;

use App\Http\Services\Clients\NewsApiClient;
use App\Http\Services\Updaters\GuardianApiUpdater;
use App\Http\Services\Updaters\NewsApiUpdater;
use App\Http\Services\Updaters\NYTApiUpdater;
use App\Models\Article;
use Illuminate\Console\Command;

class UpdateNewsCommand extends Command
{
    private NewsApiUpdater $newsApiUpdater;
    private GuardianApiUpdater $guardianApiUpdater;
    private NYTApiUpdater $NYTApiUpdater;

    public function __construct(
        NewsApiUpdater $newsApiUpdater,
        GuardianApiUpdater $guardianApiUpdater,
        NYTApiUpdater $NYTApiUpdater
    ){
        parent::__construct();
        $this->newsApiUpdater = $newsApiUpdater;
        $this->guardianApiUpdater = $guardianApiUpdater;
        $this->NYTApiUpdater = $NYTApiUpdater;
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
        Article::query()->delete();
//        $this->newsApiUpdater->update();
//        $this->guardianApiUpdater->update();
        $this->NYTApiUpdater->update();
    }
}
