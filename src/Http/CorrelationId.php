<?php

namespace Chocofamily\Http;

use Phalcon\Di\Injectable;

/**
 * Класс для отслеживания запросов по всем микросервисам
 * @package Chocolife.me
 * @author  docxplusgmoon <nurgabylov.d@chocolife.kz>
 */
class CorrelationId extends Injectable
{
    /** @var string */
    private $correlationId = '';

    /** @var integer */
    private $spanId = 0;

    /** @var integer */
    private $nextSpanId = 0;

    /** @var CorrelationId */
    private static $instance;

    private function __construct()
    {
        if (PHP_SAPI == 'cli') {
            return;
        }

        $request = $this->getDI()->getShared('request');
        $this->correlationId = $request->getQuery('correlation_id', 'string', md5(time() . getmypid()));

        $this->spanId = $request->getQuery('span_id', 'int', 0);
        $this->nextSpanId = $this->spanId + 1;
    }

    /**
     * @return CorrelationId
     */
    public static function getInstance() : CorrelationId
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return array
     */
    public function getNextQueryParams() : array
    {
        return [
            'correlation_id' => $this->correlationId,
            'span_id' => $this->nextSpanId
        ];
    }

    /**
     * @return array
     */
    public function getCurrentQueryParams() : array
    {
        return [
            'correlation_id' => $this->correlationId,
            'span_id' => $this->spanId
        ];
    }

    /**
     * @return string
     */
    public function getCorrelationId(): string
    {
        return $this->correlationId;
    }

    /**
     * @return int
     */
    public function getSpanId(): int
    {
        return $this->spanId;
    }

    /**
     * @return int
     */
    public function getNextSpanId(): int
    {
        return $this->nextSpanId;
    }
}
