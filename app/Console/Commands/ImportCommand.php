<?php

namespace App\Console\Commands;

use App\Services\Import\CompositeImporter;
use App\Services\Import\ImporterContext;
use Illuminate\Console\Command;
use App\Services\Import\Google\Importer as GoogleImporter;
use App\Services\Import\NewYorkTime\Importer as NYTImporter;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:import {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import command';

    protected ImporterContext $context;
    protected CompositeImporter $compositeImporter;

    /**
     * @param GoogleImporter $googleImporter
     * @param NYTImporter $nytImporter
     */
    public function __construct(ImporterContext $context, CompositeImporter $compositeImporter)
    {
        parent::__construct();

        $this->compositeImporter = $compositeImporter;
        $this->context = $context;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->input->getOption('type')) {
            $this->context->import($this->input->getOption('type'));
        } else {
            $this->compositeImporter->import();
        }

        $this->output->success('Imported executed successfully!');

        return 0;
    }
}
