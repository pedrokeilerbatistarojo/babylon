<?php

namespace App\Shared\Infrastructure\Cli;

use App\Shared\Contracts\KeyPairGeneratorInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateKeyPairCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-key-pair';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create key pair';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private readonly KeyPairGeneratorInterface $keyPairGenerator)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $directoryPath = storage_path('app/transactions/');
        $publicKeyPath = storage_path('app/transactions/public.key');
        $privateKeyPath = storage_path('app/transactions/private.key');

        // Check if the directory already exists
        if (! File::exists($directoryPath)) {
            // Create the directory tree
            if (! File::makeDirectory($directoryPath, 0755, true)) {
                throw new \Exception('Error creating key directory');
            }
        }

        if (File::exists($publicKeyPath) && File::exists($privateKeyPath)) {
            return;
        }

        $publicKey = $this->keyPairGenerator->getPublicKey();
        $privateKey = $this->keyPairGenerator->getPrivateKey();

        file_put_contents($publicKeyPath, $publicKey);
        file_put_contents($privateKeyPath, $privateKey);

    }
}
