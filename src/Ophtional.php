<?php

namespace Ophtional;

class Ophtional
{
	private $item;

	public function __construct()
	{
		$this->item = null;
	}

	public static function emptyOphtional()
	{
		return new Ophtional();
	}

	public function equals(Ophtional $ophtional)
	{
		if ($this === $ophtional) {
			return true;
		}
		return $ophtional->item === $this->item;
	}

	public function filter(callable $callable)
	{
		if (!$this->isPresent()) {
			return self::emptyOphtional();
		}
		if ($callable($this->item)) {
			return self::of($this);
		}
		return self::emptyOphtional();
	}

	public function flatMap(callable $callable)
	{
		if (!$this->isPresent()) {
			return self::emptyOphtional();
		}
		return $callable($this->item);
	}

	public function get()
	{
		if (!$this->isPresent()) {
			throw new NullPointerException();
		}
		return $this->item;
	}

	public function ifPresent(callable $callable)
	{
		if ($this->isPresent()) {
			$callable($this->item);
		}
	}

	public function ifPresentOrElse(callable $action, callable $elseAction)
	{
		if ($this->isPresent()) {
			$action($this->item);
		} else {
			$elseAction();
		}
	}

	public function isPresent()
	{
		return !is_null($this->item);
	}

	public function map(callable $callable)
	{
		if (!$this->isPresent()) {
			return self::emptyOphtional();
		}
		return self::of($callable($this->item));
	}

	public function of($item)
	{
		if (is_null($item)) {
			throw new NullPointerException();
		}
		$optional = new Ophtional();
		$optional->item = $item;
		return $optional;
	}

	public function ofNullable($item)
	{
		if (is_null($item)) {
			return self::emptyOphtional();
		}
		$optional = new Ophtional();
		$optional->item = $item;
		return $optional;
	}

	public function orOphtional(callable $callable)
	{
		if ($this->isPresent()) {
			return $this;
		}
		return $callable();
	}

	public function orElse($item)
	{
		if ($this->isPresent()) {
			return $this->item;
		}
		return $item;
	}

	public function orElseGet(callable $getter)
	{
		if ($this->isPresent()) {
			return $this->item;
		}
		return $getter();
	}

	public function orElseThrow(\Throwable $throwable)
	{
		if ($this->isPresent()) {
			return $this->item;
		}
		throw $throwable;
	}
}