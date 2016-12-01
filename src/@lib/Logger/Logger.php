<?php //namespace Grinza\Logger;
//
//use Grinza\Logger\Handlers\HandlerInterface;
//
//class Logger extends \Psr\Log\AbstractLogger
//{
//    /**
//     * @var HandlerInterface []
//     */
//    protected $handlers;
//
//    /**
//     * Logs with an arbitrary level.
//     *
//     * @param mixed $level
//     * @param string $message
//     * @param array $context
//     *
//     * @return void
//     */
//    public function log($level, $message, array $context = [])
//    {
//        $now    = new \DateTimeImmutable('now');
//        $record = new Record($now, $level, $message, $context);
//
//        foreach ($this->handlers as $handler) {
//            $handler->handle($record);
//        }
//    }
//}