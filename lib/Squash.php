<?php

namespace Squash;

use Squash as LegacySquash;
use Squash\Sorting\SortController;
use Squash\Api\Ollama\OllamaEndpointController;
use Squash\Number\LocaliseController;
use Squash\Contract\LocaliseInterface;
use Squash\Api\Discord\DiscordEndpointController;
use Squash\Contract\Api\OllamaEndpointInterface;
use Squash\Contract\Api\DiscordEndpointInterface;
use Squash\Contract\CalculatorInterface;
use Squash\Contract\ConverterInterface;
use Squash\Contract\FileSystemInterface;
use Squash\Contract\NumberFormatterInterface;
use Squash\Contract\RandomGeneratorInterface;
use Squash\Contract\SortInterface;
use Squash\Contract\TimerInterface;
use Squash\Contract\UuidInterface;
use Squash\Conversion\BiByteConverter;
use Squash\Conversion\ByteConverter;
use Squash\Conversion\Legacy\BiByteConverter as LegacyBiByteConverter;
use Squash\Conversion\Legacy\ByteConverter as LegacyByteConverter;
use Squash\Conversion\Unit;
use Squash\FileSystem\FileSystem;
use Squash\Number\Calculator;
use Squash\Number\Formatter;
use Squash\Number\Legacy as NumberLegacy;
use Squash\Random\Crypto;
use Squash\Timer\Milliseconds;
use Squash\Uuid\Uuid4;
use SquashConversionsBiByte;
use SquashConversionsByte;
use SquashNumber;
use stdClass;

final class Squash
{
    public static function create(): Squash
    {
        return new Squash(
            new ByteConverter(),
            new BiByteConverter(),
            new Crypto(),
            new FileSystem(),
            new Uuid4(),
            new Milliseconds(),
            new Formatter(),
            new Calculator(),
            new OllamaEndpointController(),
            new DiscordEndpointController(),
            new SortController(),
            new LocaliseController()
        );
    }

    public static function legacy(): Squash
    {
        $legacy = new Legacy(new LegacySquash());
        $byteConverter = new LegacyByteConverter(new SquashConversionsByte());
        $biByteConverter = new LegacyBiByteConverter(new SquashConversionsBiByte());
        $numberLegacy = new NumberLegacy(new SquashNumber());

        return new Squash(
            $byteConverter,
            $biByteConverter,
            $legacy,
            $legacy,
            $legacy,
            $legacy,
            $numberLegacy,
            $numberLegacy,
            new OllamaEndpointController(),
            new DiscordEndpointController(),
            new SortController(),
            new LocaliseController()
        );
    }

    public function __construct(
        private ConverterInterface $byteConverter,
        private ConverterInterface $biByteConverter,
        private RandomGeneratorInterface $randomGenerator,
        private FileSystemInterface $fileSystem,
        private UuidInterface $uuid,
        private TimerInterface $timer,
        private NumberFormatterInterface $numberFormatter,
        private CalculatorInterface $calculator,
        private OllamaEndpointInterface $ollamaEndpoint,
        public DiscordEndpointInterface $discordEndpoint,
        public SortInterface $sort,
        public LocaliseInterface $localise
    ) {
    }

    public function uuid(): string
    {
        return $this->uuid->generateUuid();
    }

    public function generateRandomString(int $length = 25): string
    {
        return $this->randomGenerator->generateString($length);
    }

    public function replaceFile(string $directory, string $destination, string $source): void
    {
        $this->fileSystem->replaceFile($directory, $destination, $source);
    }

    /**
     * I got lazy.
     * TODO: extract interface, possibly integrate with some HTTP clients.
     *
     * @param string $url
     *
     * @return stdClass
     */
    public function fetchJson(string $url): stdClass
    {
        return json_decode(file_get_contents($url));
    }

    public function convertBytes(Unit $from, string $to): Unit
    {
        return $this->byteConverter->from($from)->to($to)->convert();
    }

    public function convertBiBytes(Unit $from, string $to): Unit
    {
        return $this->biByteConverter->from($from)->to($to)->convert();
    }

    public function wait(int $period): void
    {
        $this->timer->wait($period);
    }

    public function calculate($left, $operator, $right)
    {
        return $this->calculator->calculate([$left, $operator, $right]);
    }

    public function formatNumber(float $number): string
    {
        return $this->numberFormatter->format($number);
    }

    public function roundNumber(float $number, int $decimals = 0): string
    {
        return $this->numberFormatter->round($number, $decimals);
    }

    public function ollama(): OllamaEndpointInterface
    {
        return $this->ollamaEndpoint;
    }
}
