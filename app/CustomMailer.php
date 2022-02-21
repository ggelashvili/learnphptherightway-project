<?php

declare(strict_types = 1);

namespace App;

use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\RawMessage;

class CustomMailer implements MailerInterface
{
    protected TransportInterface $transport;

    public function __construct(protected string $dsn)
    {
        $this->transport = Transport::fromDsn($dsn);
    }

    public function send(RawMessage $message, Envelope $envelope = null): void
    {
        //... some logic

        $this->transport->send($message, $envelope);

        // ... some more logic
    }
}
