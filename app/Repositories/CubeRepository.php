<?php

namespace App\Repositories;

use App\Services\Builders\Assembler;
use App\Services\Templates\CubeInterface;
use Illuminate\Support\Facades\Cache;

class CubeRepository
{
    protected int $increment;

    public function __construct(
        protected Assembler $assembler
    )
    {
        $cacheKey = $this->getIncrementKey();

        $increment = Cache::get($cacheKey);

        if (empty($increment)) {
            $this->increment = 0;
            Cache::put($cacheKey, $this->increment);
        } else {
            $this->increment = (int)$increment;
        }
    }

    public function getById(int $id): ?CubeInterface
    {
        $value = Cache::get($this->getCubeKey($id));

        if (empty($value)) {
            return null;
        }

        $cube = json_decode($value, true, 512, JSON_THROW_ON_ERROR);

        if (!isset($cube['size'], $cube['surfaces'])) {
            return null;
        }

        return $this->assembler->assemble($cube['size'], $cube['surfaces']);
    }

    public function create(CubeInterface $cube): int
    {
        $id = $this->nextIdentifier();

        $this->update($id, $cube);

        return $id;
    }

    public function update(int $id, CubeInterface $cube): bool
    {
        return Cache::put($this->getCubeKey($id), json_encode($cube, JSON_THROW_ON_ERROR));
    }

    protected function nextIdentifier(): int
    {
        Cache::put($this->getIncrementKey(), ++$this->increment);

        return $this->increment;
    }

    private function getIncrementKey(): string
    {
        return static::class . ':increment';
    }

    private function getCubeKey(int $id): string
    {
        return static::class . ':cube:' . $id;
    }

}
