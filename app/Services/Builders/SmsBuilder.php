<?php

declare(strict_types=1);

namespace App\Services\Builders;

use App\Enums\ClientLocale;
use App\Helpers\ClientDomainService;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Uri;
use InvalidArgumentException;
use RuntimeException;

final class SmsBuilder
{
    use Conditionable;

    private string $messageKey;

    private array $messageParams = [];

    private ?int $messageTemplate = 2;

    private ?User $user = null;

    private ?string $path = null;

    private ?string $baseUrl = null;

    private array $queryParams = [];

    private bool $withToken = false;

    private string $tokenName;

    private array $tokenScopes;
    private ClientLocale $locale = ClientLocale::FA;

    private DateTimeInterface $tokenExpireAt;

    private function __construct(string $messageKey)
    {
        $this->messageKey = $messageKey;
    }

    public static function make(string $messageKey): self
    {
        throw_unless(str_starts_with($messageKey, 'sms.'), InvalidArgumentException::class, "The message key must start with 'sms.'.");

        throw_unless(Lang::has($messageKey), InvalidArgumentException::class, "The [{$messageKey}] message key does not exist in translations.");

        return new self($messageKey);
    }

    public function parameters(array $messageParams): self
    {
        $this->messageParams = $messageParams;

        return $this;
    }

    public function messageTemplate(int $template): self
    {
        $this->messageTemplate = $template;

        return $this;
    }

    public function locale(ClientLocale $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function noMessageTemplate(): self
    {
        $this->messageTemplate = null;

        return $this;
    }

    public function path(string $path, User $user): self
    {
        $this->path = $path;
        $this->user = $user;

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function baseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function queryParams(array $params): self
    {
        $this->queryParams = $params;

        return $this;
    }

    public function withToken(?string $name = null, array $scopes = ['*'], ?DateTimeInterface $expireAt = null): self
    {
        $this->withToken     = true;
        $this->tokenName     = $name ?: class_basename(self::class);
        $this->tokenScopes   = $scopes;
        $this->tokenExpireAt = $expireAt ?: now()->addDays();

        return $this;
    }

    public function withProductUtms(string $campaign = 'productsms'): self
    {
        \Illuminate\Support\Arr::set($this->queryParams, 'utm_source', 'product');
        \Illuminate\Support\Arr::set($this->queryParams, 'utm_medium', 'sms');
        \Illuminate\Support\Arr::set($this->queryParams, 'utm_campaign', $campaign);

        return $this;
    }

    public function build(): string
    {
        $this->addTokenToQueryParams();
        $this->addLinkToMessageParams();
        $this->ensureAllPlaceholdersAreFilled();

        $body = __($this->messageKey, $this->messageParams, $this->locale->value);

        return is_int($this->messageTemplate)
            ? __("sms.templates.{$this->messageTemplate}", ['body' => $body], $this->locale->value)
            : $body;
    }

    private function addTokenToQueryParams(): void
    {
        if ($this->withToken)
        {
            throw_unless($this->user, RuntimeException::class, 'User must be provided through the `path()` method to generate auth token.');

            $token = $this->user->createToken(
                name: $this->tokenName,
                abilities: $this->tokenScopes,
                expiresAt: $this->tokenExpireAt,
            )->plainTextToken;
            \Illuminate\Support\Arr::set($this->queryParams, 'token', $token);
        }
    }

    private function addLinkToMessageParams(): void
    {
        if (filled($this->path))
        {
            throw_if(array_key_exists('link', $this->messageParams), RuntimeException::class, "The 'link' parameter is reserved and must not be provided in the parameters array.");

            \Illuminate\Support\Arr::set($this->messageParams, 'link', $this->createShortlink());
        }
    }

    private function createShortlink(): string
    {
        $baseUrl = $this->baseUrl ?? ClientDomainService::getUserDomainWithFallback($this->user)->value;

        $uri = Uri::of($baseUrl)
            ->withPath($this->path)
            ->withQuery($this->queryParams);

        // TODO: implement shortlink
        return $uri->value();
    }

    private function ensureAllPlaceholdersAreFilled(): void
    {
        $rawMessage = __($this->messageKey, locale: $this->locale->value);
        preg_match_all('/:([a-zA-Z0-9_]+)/', $rawMessage, $matches);
        $placeholders  = \Illuminate\Support\Arr::get($matches, 1);
        $missingParams = array_diff($placeholders, array_keys($this->messageParams));

        throw_unless(empty($missingParams), RuntimeException::class, "Missing parameters for {$this->messageKey}: " . implode(', ', $missingParams));
    }
}
