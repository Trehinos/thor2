<?php

namespace Thor\Configuration;

use Thor\Globals;
use Symfony\Component\Yaml\Yaml;

class ConfigurationFromFile extends Configuration
{

    private static array $configurations = [];

    public static function get(mixed ...$args): static
    {
        return static::$configurations[static::class] ??= new static(...$args);
    }

    public function __construct(string $filename, bool $isStatic = false)
    {
        parent::__construct(self::loadYml($filename, $isStatic));
    }

    /**
     * Gets the configuration from a file in the resources' folder.
     *
     * @param string $name
     * @param bool   $staticResource If false (default), search in the res/config/ folder.
     *                               If true, search in the res/static/ folder.
     *
     * @return static
     */
    public static function fromFile(string $name, bool $staticResource = false): static
    {
        return new static($name, $staticResource);
    }

    public static function loadYml(string $name, bool $staticResource = false): array
    {
        return Yaml::parseFile(($staticResource ? Globals::STATIC_DIR : Globals::CONFIG_DIR) . "$name.yml");
    }

    public static function writeTo(Configuration $configuration, string $name, bool $staticResource = false): bool
    {
        $str = Yaml::dump(
                   $configuration->getArrayCopy(),
                   6,
            flags: Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK | Yaml::DUMP_NULL_AS_TILDE
        );
        return file_put_contents(
                   ($staticResource ? Globals::STATIC_DIR : Globals::CONFIG_DIR) . "$name.yml",
                   $str
               ) !== false;
    }

}
