<?php

declare(strict_types = 1);

use App\Config;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\ORMSetup;

use Slim\Views\Twig;

use Twig\Extra\Intl\IntlExtension;

use function DI\create;

return [
    Config::class        => create(Config::class)->constructor($_ENV),
    EntityManager::class => fn(Config $config) => EntityManager::create(
        $config->db,
        ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/../app/Entity'])
    ),
    Twig::class          => function (Config $config) {
        $twig = Twig::create(VIEW_PATH, [
            'cache'       => STORAGE_PATH . '/cache',
            'auto_reload' => $config->environment === 'development',
        ]);

        $twig->addExtension(new IntlExtension());

        return $twig;
    },
];
