<?php

declare(strict_types=1);

namespace App\Infrastructure;

/**
 * Class ApiKey
 *
 * @package App\Infrastructure
 */
class ApiKey
{
    /**
     * @var null $instance
     */
    private static $instance = null;

    /**
     * @var string $apiKey
     */
    private $apiKey;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var bool $enabled
     */
    private $enabled;

    /**
     * ApiKey constructor.
     * @param string $apiKey
     */
    private function __construct(string $apiKey)
    {
        $config = (require '../config/apikey.php')($apiKey);

        $this->setApiKey($apiKey);

        if ($config) {
            $this->setName($config['name']);
            $this->setEnabled($config['enabled']);
        }
    }

    /**
     * @param string $apiKey
     * @return ApiKey|null
     */
    public static function singleton(string $apiKey): self
    {
        if (!self::$instance) {
            self::$instance = new self($apiKey);
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function isEnabled()
    {
        return $this->enabled && $this->getApiKey() === $_ENV['API_KEY_VALUE'];
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }
}
