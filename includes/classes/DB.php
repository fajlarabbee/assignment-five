<?php

/**
 * Database Class.
 */
class DB
{
    /**
     * Base path of the database.
     */
    protected const DB_PATH = 'db';

    /**
     * Name of the database file.
     * @var string
     */
    protected string $dbName;


    /**
     * Database stream.
     * @var string
     */
    protected string $stream;

    /**
     * Database file content.
     * @var string|array
     */
    protected string|array $data;


    public function __construct(string $dbName)
    {
        $this->dbName = $dbName;
        $this->stream = getPath(self::DB_PATH . DIRECTORY_SEPARATOR . ltrim($dbName, '/'));
    }

    /**
     * Format the data based on the condition. If $json parameter is true it will return the formatted json data, serialized otherwise.
     *
     * @param $data
     * @param bool $toJson
     *
     * @return false|mixed|string
     */
    private function encode($data, bool $toJson = false)
    {
        if (is_array($data)) {
            if ($toJson) {
                $data = json_encode($data, JSON_PRETTY_PRINT);
            } else {
                $data = serialize($data);
            }
        }

        return $data;
    }

    /**
     * Decode the data.
     * @param $data
     * @param $isJson
     *
     * @return mixed
     */
    private function decode($data, $isJson = false)
    {
        if ($isJson) {
            return json_decode($data, true);
        }

        return unserialize($data);
    }

    /**
     * @param $data
     * @param $toJson
     *
     */
    public function write($data, $toJson = false)
    {
        $writeStatus = false;
        if (is_array($data)) {
            $data = $this->encode($data, $toJson);
        }

        if (file_exists($this->stream) && is_writable($this->stream)) {
            $writeStatus = file_put_contents($this->stream, $data, LOCK_EX);
        }
        return $writeStatus;
    }

    public function read(): self
    {
        if (file_exists($this->stream) && is_readable($this->stream)) {
            $this->data = file_get_contents($this->stream);
        }

        return $this;
    }

    public function getData(bool $asjson = false): string|array
    {
        if ($asjson) {
            return $this->decode($this->data, true) ?? [];
        }

        return $this->decode($this->data) ?? [];
    }
}