<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;

abstract class BaseCommand extends Command
{
    private const STYLED_MESSAGE_TEMPLATE = '<%s>%s</%s>';

    /**
     * @param string $message
     *
     * @return string
     */
    protected function getErrorMessage(string $message): string
    {
        return $this->getStyledMessage($message, 'error');
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function getQuestionMessage(string $message): string
    {
        return $this->getStyledMessage($message, 'question');
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function getCommentMessage(string $message): string
    {
        return $this->getStyledMessage($message, 'comment');
    }

    /**
     * @param string $message
     *
     * @return string
     */
    protected function getInfoMessage(string $message): string
    {
        return $this->getStyledMessage($message, 'info');
    }

    /**
     * @param string $message
     * @param string $messageType
     *
     * @return string
     */
    private function getStyledMessage(string $message, string $messageType): string
    {
        return sprintf(self::STYLED_MESSAGE_TEMPLATE, $messageType, $message, $messageType);
    }
}