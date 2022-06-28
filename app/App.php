<?php

declare(strict_types = 1);

namespace App;

use App\Contracts\EmailValidationInterface;
use App\Exceptions\RouteNotFoundException;
use App\Services\Emailable;
use App\Services\AbstractApi;
use Dotenv\Dotenv;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;
use Twig\Extra\Intl\IntlExtension;
use Twig\Loader\FilesystemLoader;

class App
{
    private Config $config;

    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = [],
    ) {
    }

    public function initDb(array $config)
    {
        $capsule = new Capsule();

        $capsule->addConnection($config);
        $capsule->setEventDispatcher(new Dispatcher($this->container));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function boot(): static
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->config = new Config($_ENV);

        $this->initDb($this->config->db);

        $twig = new Environment(
            new FilesystemLoader(VIEW_PATH),
            [
                'cache' => STORAGE_PATH . '/cache',
                'auto_reload' => true
            ]
        );

        $twig->addExtension(new IntlExtension());

        $this->container->bind(MailerInterface::class, fn() => new CustomMailer($this->config->mailer['dsn']));
        $this->container->singleton(Environment::class, fn() => $twig);

        $this->container->bind(
            EmailValidationInterface::class,
            fn() => new Emailable\EmailValidationService($this->config->apiKeys['emailable'])
        );
        //$this->container->bind(
        //    EmailValidationInterface::class,
        //    fn() => new AbstractApi\EmailValidationService($this->config->apiKeys['abstract_api_email_validation'])
        //);

        return $this;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}
